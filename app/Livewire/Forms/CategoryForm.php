<?php

namespace App\Livewire\Forms;

use App\Models\PocketWise\Categories;
use Illuminate\Support\Facades\Auth;
use Flux\Flux;
use Livewire\Attributes\Validate;
use Livewire\Form;

class CategoryForm extends Form
{
    public ?Categories $category = null;

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

    public $color = '#000000';

    public function save()
    {
        $this->validate();

        if ($this->is_fixed) {
            $fixed = 1;
        } else {
            $fixed = 0;
        }

        Categories::create([
            'user_id' => $this->user_id = Auth::id(),
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

    public function edit($id)
    {
        $this->category = Categories::findOrFail($id);

        $this->name = $this->category->name;
        $this->user_id = $this->category->user_id;
        $this->type = $this->category->type;
        $this->is_fixed = $this->category->is_fixed;
        $this->monthly_budget = $this->category->monthly_budget;
        $this->icon = $this->category->icon;
        $this->color = $this->category->color;

        Flux::modal('create-categories')->show();
    }

    public function update()
    {
        $this->validate();

        $this->category->update([
            'name' => $this->name,
            'type' => $this->type,
            'is_fixed' => $this->is_fixed,
            'monthly_budget' => $this->monthly_budget,
            'icon' => $this->icon,
            'color' => $this->color,
        ]);

        Flux::modal('create-categories')->close();
    }

    public function destroy($id)
    {
        Categories::findOrFail($id)->delete();
    }

    public function exit()
    {
        $this->reset(['name', 'type', 'is_fixed', 'fixed', 'monthly_budget', 'icon', 'color']);
        Flux::modal('create-categories')->close();
    }

    public function refresh()
    {
        $this->reset(['name', 'type', 'is_fixed', 'fixed', 'monthly_budget', 'icon', 'color']);
    }
}
