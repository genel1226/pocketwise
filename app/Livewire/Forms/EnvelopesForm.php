<?php

namespace App\Livewire\Forms;

use App\Models\PocketWise\Categories;
use App\Models\PocketWise\Envelopes;
use Flux\Flux;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Form;

class EnvelopesForm extends Form
{
    public ?Envelopes $envelopes;

    public ?int $user_id;

    public ?int $category_id;

    public ?float $allocated_amount;

    public ?float $spent_amount = 0;

    #[Validate('required')]
    public ?string $month_year;

    public function updatedCategoryId(int $value)
    {
        $category = Categories::findOrFail($value);

        $this->allocated_amount = $category?->monthly_budget;
    }

    public function show()
    {
        Flux::modal('create-envelopes')->show();
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

    public function save()
    {
        $this->validate();

        // dd(
        //     $category_id = $this->category_id,
        //     $allocated_amount = $this->allocated_amount,
        //     $spent_amount = $this->spent_amount
        // );

        Envelopes::create([
            'user_id' => $this->user_id = Auth::id(),
            'category_id' => $this->category_id,
            'allocated_amount' => $this->allocated_amount,
            'spent_amount' => $this->spent_amount,
            'month_year' => $this->month_year,
        ]);

        $this->exit();
    }

    public function edit(int $id)
    {
        $this->envelopes = Envelopes::findOrFail($id); 
        
        $this->category_id = $this->envelopes->category_id;
        $this->allocated_amount = $this->envelopes->allocated_amount;
        $this->spent_amount = $this->envelopes->spent_amount;
        $this->month_year = $this->envelopes->month_year;

        $this->show();
    }

    public function update()
    {
        $this->validate();

        Envelopes::findOrFail($this->envelopes->id)->update([
            'category_id' => $this->category_id,
            'allocated_amount' => $this->allocated_amount,
            'spent_amount' => $this->spent_amount,
            'month_year' => $this->month_year,
        ]);

        // $this->envelopes->update([
        //     'category_id' => $this->category_id,
        //     'allocated_amount' => $this->allocated_amount,
        //     'spent_amount' => $this->spent_amount,
        //     'month_year' => $this->month_year,
        //     ]
        // );

        $this->exit();
    }

    public function destroy(int $id)
    {
        Envelopes::findOrFail($id)->delete();
    }

    public function exit()
    {
        $this->refresh();

        Flux::modal('create-envelopes')->close();
    }

    public function refresh()
    {
        $this->reset(['user_id', 'category_id', 'allocated_amount', 'spent_amount', 'month_year']);
    }
}
