<?php

namespace App\Livewire\PocketWise\Envelopes;

use App\Livewire\Forms\EnvelopesForm;
use App\Models\PocketWise\Categories;
use Livewire\Attributes\On;
use Livewire\Component;

class Index extends Component
{
    public EnvelopesForm $form;

    public $state = 'create';

    public $category_id = '';

    public function open()
    {
        $this->state = 'create';

        $this->form->open();
    }

    public function save()
    {
        $this->form->save();

        $this->dispatch('pg:eventRefresh-envelopesTable');
    }

    public function updatedCategoryId($value)
    {
        $this->form->updatedCategoryId($value);
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

        $this->dispatch('pg:eventRefresh-envelopesTable');
    }

    #[On('destroy')]
    public function destroy($id)
    {
        $this->form->destroy($id);

        $this->dispatch('pg:eventRefresh-envelopesTable');
    }

    public function exit()
    {
        $this->form->exit();
    }

    public function render()
    {
        return view('livewire.pocket-wise.envelopes.index', ['categories' => Categories::orderBy('name','asc')->pluck('name', 'id')]);
    }
}
