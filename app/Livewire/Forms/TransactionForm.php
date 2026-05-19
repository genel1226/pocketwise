<?php

namespace App\Livewire\Forms;

use App\Models\PocketWise\Envelopes;
use App\Models\PocketWise\Transactions;
use Flux\Flux;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Form;

class TransactionForm extends Form
{
    public $user_id;

    public $category_id;

    public $envelope_id;

    public $amount;

    public $type;

    public $description;

    public $years;

    public $months;

    public $days;
    
    public $date;

    public $tags;

    public $receipt_path;

    public $is_recurring;

    public $envelopes = [];

    public $envelopes_id = [];

    public function open()
    {
        Flux::modal('create-transactions')->show();
    }

    public function updatedFormCategoryId($value)
    {
        return Envelopes::with('category')
        ->where('category_id', $value)
        ->get()
        ->pluck('category.name', 'id');
    }

    public function save()
    {
        $this->date = $this->years.'-'.$this->months.'-'.$this->days;
        // dd(
        //     $this->category_id,
        //     $this->envelope_id,
        //     $this->amount,
        //     $this->type,
        //     $this->description,
        //     $this->years,
        //     $this->months,
        //     $this->days,
        //     $this->is_recurring,
        //     $this->date
        // );

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

    public function exit()
    {
        Flux::modal('create-transactions')->close();
    }
}
