<?php

namespace App\Livewire\PowerGrid\Categories;

use App\Livewire\Forms\CategoryForm;
use Livewire\Component;

class Index extends Component
{
    public CategoryForm $form;

    public function save()
    {
        $this->form->save();
    }

    public function exit()
    {
        $this->form->exit();
    }

    public function render()
    {
        return view('livewire.power-grid.categories.index');
    }
}
