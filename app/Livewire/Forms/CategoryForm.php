<?php

namespace App\Livewire\Forms;

use App\Models\PocketWise\Categories;
use Illuminate\Support\Facades\Auth;
use Flux\Flux;
use Livewire\Attributes\Validate;
use Livewire\Form;

class CategoryForm extends Form
{
    public $user_id;

    #[Validate('required|min:3')]
    public $name;

    #[Validate('required')]
    public $type = null;

    public $is_fixed = false;
    public $fixed = 0;

    #[Validate('required|numeric|min:1')]
    public $monthly_budget = 0;

    public $icon = null;

    public $color;

    public function save()
    {
        $this->validate();

        if ($this->is_fixed) {
            $fixed = 1;
        }else{
            $fixed = 0;
        }

        Categories::create([
            'user_id' => $this->user_id=Auth::id(),
            'name' => $this->name,
            'type' => $this->type,
            'is_fixed' => $this->fixed,
            'monthly_budget' => $this->monthly_budget,
            'icon' => $this->icon,
            'color' => $this->color,
        ]);

        // dd(
        //     $user_id = $this->user_id=Auth::id(),
        //     $name = $this->name,
        //     $type = $this->type,
        //     $is_fixed = $this->fixed,
        //     $monthly_budget = $this->monthly_budget,
        //     $icon = $this->icon,
        //     $color = $this->color,
        // );

        $this->reset(['name', 'type', 'is_fixed', 'fixed', 'monthly_budget', 'icon', 'color']);
        Flux::modal('create-categories')->close();
    }

    public function exit()
    {
        $this->reset(['name', 'type', 'is_fixed', 'fixed', 'monthly_budget', 'icon', 'color']);
        Flux::modal('create-categories')->close();
    }
}
