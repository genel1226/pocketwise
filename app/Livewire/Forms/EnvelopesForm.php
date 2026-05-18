<?php

namespace App\Livewire\Forms;

use App\Models\PocketWise\Categories;
use Flux\Flux;
use Livewire\Attributes\Validate;
use Livewire\Form;

class EnvelopesForm extends Form
{
    public $user_id;

    public $category_id;

    public $allocated_amount = '';

    #[Validate('required|numeric|min:1')]
    public $spent_amount;

    public $month_year;

    public $category_name = [];

    public ?Categories $category;

    public function updatedCategoryId($value)
    {
        $category = Categories::find($value);

        $this->allocated_amount = $category?->monthly_budget;
    }

    public function open()
    {
        $this->refresh();

        Flux::modal('create-envelopes')->show();
    }

    public function save()
    {
        // $this->validate();

        dd(
            $category_id = $this->category_id,
            $allocated_amount = $this->allocated_amount,
            $spent_amount = $this->spent_amount
        );
    }

    public function exit()
    {
        $this->reset(['user_id', 'category_id', 'allocated_amount', 'spent_amount', 'month_year']);

        Flux::modal('create-envelopes')->close();
    }

    public function refresh()
    {
        $this->reset(['user_id', 'category_id', 'allocated_amount', 'spent_amount', 'month_year']);
    }
}
