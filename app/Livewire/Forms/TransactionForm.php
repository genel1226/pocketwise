<?php

namespace App\Livewire\Forms;

use App\Models\PocketWise\Envelopes;
use App\Models\PocketWise\Transactions;
use Carbon\Carbon;
use Flux\Flux;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Form;

class TransactionForm extends Form
{
    public $user_id;

    #[Validate('required')]
    public $category_id;

    public $envelope_id;

    #[Validate('required|numeric|min:1')]
    public $amount;

    #[Validate('required')]
    public $type;

    public $description;

    #[Validate('required')]
    public $years;

    #[Validate('required')]
    public $months;

    #[Validate('required')]
    public $days;

    #[Validate('required|date')]
    public $date;

    public $tags;

    public $receipt_path;

    public $is_recurring;

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
        $this->show();
    }

    public function updatedFormCategoryId($value)
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

        $this->exit();
    }

    public function edit($id)
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
        
        $this->transaction->update([
            'category_id' => $this->category_id,
            'envelope_id' => $this->envelope_id,
            'amount' => $this->amount,
            'type' => $this->type,
            'description' => $this->description,
            'date' => $this->date,
            'is_recurring' => $this->is_recurring,
        ]);

        $this->exit();
    }

    public function destroy($id)
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
    }
}
