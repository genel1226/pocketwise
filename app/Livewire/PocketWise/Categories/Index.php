<?php

namespace App\Livewire\PocketWise\Categories;

use App\Livewire\Forms\CategoryForm;
use App\Models\PocketWise\Categories;
use Flux\Flux;
use Livewire\Attributes\On;
use Livewire\Component;

class Index extends Component
{
    public CategoryForm $form;

    public $state = 'create';

    public function open()
    {
        $this->state = 'create';

        $this->form->refresh();

        Flux::modal('create-categories')->show();
    }

    public function save()
    {
        $this->state = 'create';

        $this->form->save();

        $this->dispatch('pg:eventRefresh-categoriesTable'); // para refrescar la tabla y que no se refresque por completo la pagina
    }

    #[On('edit')]
    public function edit($id)
    {
        $this->state = 'update';

        $this->form->edit($id);
    }

    public function update()
    {
        $this->form->update();

        $this->dispatch('pg:eventRefresh-categoriesTable');
    }

    #[On('destroy')]
    public function destroy($id)
    {
        $this->form->destroy($id);

        $this->dispatch('pg:eventRefresh-categoriesTable');
    }

    public function exit()
    {
        $this->state = 'create';

        $this->form->exit();
    }

    public function render()
    {
        return view('livewire.pocket-wise.categories.index');
    }
}
