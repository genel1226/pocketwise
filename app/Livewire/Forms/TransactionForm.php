<?php

namespace App\Livewire\Forms;

use App\Models\PocketWise\Categories;
use App\Models\PocketWise\Envelopes;
use App\Models\PocketWise\Transactions;
use Carbon\Carbon;
use Flux\Flux;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Form;

class TransactionForm extends Form
{
    public ?int $user_id;

    #[Validate('required')]
    public ?int $category_id;

    public ?int $envelope_id = null;

    #[Validate('required|numeric|min:1')]
    public ?float $amount;

    #[Validate('required')]
    public ?string $type;

    public ?string $description = null;

    #[Validate('required')]
    public ?string $years;

    #[Validate('required')]
    public ?string $months = null;

    #[Validate('required')]
    public ?string $days;

    #[Validate('required|date')]
    public ?string $date;

    public ?string $tags;

    public ?string $receipt_path;

    public ?int $is_recurring;

    public $envelopes = [];

    public $envelopes_id = [];

    public ?Transactions $transaction;

    public function show()
    {
        Flux::modal('create-transactions')->show();
    }

    public function open()
    {
        $this->refresh();

        if (Categories::count('id') === 0) {

            session()->flash(
                'error',
                'Debe crear una categoría primero.'
            );

            return;
        }
        
        $this->show();
    }

    public function updatedFormCategoryId(int $value)
    {
        return Envelopes::with('category')
            ->where('category_id', $value)
            ->orderBy('month_year', 'asc')
            ->get()
            ->mapWithKeys(function ($envelope) {
                    return [
                        $envelope->id =>
                        $envelope->category->name . ' - ' . $envelope->month_year
                    ];
                });
    }

    public function save()
    {
        $this->date = $this->years . '-' . $this->months . '-' . $this->days;

        $this->validate();

        Transactions::create([
            'user_id' => $this->user_id = Auth::id(),
            'category_id' => $this->category_id,
            'envelope_id' => $this->envelope_id,
            'amount' => $this->amount,
            'type' => $this->type,
            'description' => $this->description,
            'date' => $this->date,
        ]);

        Flux::toast('Your changes have been saved.');

        $this->exit();
    }

    public function edit(int $id)
    {
        // $this->refresh();

        $this->transaction = Transactions::findOrFail($id);

        $this->envelopes = Envelopes::with('category')
            ->where('category_id', $this->transaction->category_id)
            ->orderBy('month_year', 'asc')
            ->get()
            ->mapWithKeys(function ($envelope) {

                return [
                    $envelope->id =>
                        $envelope->category->name . ' - ' . $envelope->month_year
                ];
            });
        $this->category_id = $this->transaction->category_id;
        $this->envelope_id = $this->transaction->envelope_id;
        $this->amount = $this->transaction->amount;
        $this->type = $this->transaction->type;
        $this->description = $this->transaction->description;
        $this->date = $this->transaction->date;
        $date = Carbon::parse($this->transaction->date);
        $this->years = $date->year;
        $this->months = $date->month;
        $this->days = $date->day;
        $this->is_recurring = $this->transaction->is_recurring;

        // dd(
        //     $this->transaction = Transactions::findOrFail($id),
        //     $this->category_id = $this->transaction->category_id,
        //     $this->envelope_id = $this->transaction->envelope_id,
        //     $this->amount = $this->transaction->amount,
        //     $this->type = $this->transaction->type,
        //     $this->description = $this->transaction->description,
        //     $this->date = $this->transaction->date,
        //     $date = Carbon::parse($this->transaction->date),
        //     $this->years = $date->year,
        //     $this->months = $date->month,
        //     $this->days = $date->day,
        //     $this->is_recurring = $this->transaction->is_recurring,
        // );

        return $this->envelopes;
    }

    public function update()
    {
        $this->date = $this->years.'-'.$this->months.'-'.$this->days;

        $this->validate();

        Transactions::findOrFail($this->transaction->id)->update(
            [
                'category_id' => $this->category_id,
                'envelope_id' => $this->envelope_id,
                'amount' => $this->amount,
                'type' => $this->type,
                'description' => $this->description,
                'date' => $this->date,
                'is_recurring' => $this->is_recurring,
            ]
        );
        
        // $this->transaction->update([
        //     'category_id' => $this->category_id,
        //     'envelope_id' => $this->envelope_id,
        //     'amount' => $this->amount,
        //     'type' => $this->type,
        //     'description' => $this->description,
        //     'date' => $this->date,
        //     'is_recurring' => $this->is_recurring,
        // ]);

        $this->exit();
    }

    public function destroy(int $id)
    {
        Transactions::findOrFail($id)->delete();
    }

    public function refresh()
    {
        $this->reset(['category_id', 'envelope_id', 'amount', 'type', 'description', 'years', 'months', 'days']);
    }

    public function exit()
    {
        $this->refresh();

        Flux::modal('create-transactions')->close();
        Flux::modal('delete-transaction')->close();
    }
}
