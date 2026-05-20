<?php

namespace App\Livewire\PocketWise\Transactions;

use App\Livewire\Forms\TransactionForm;
use App\Models\PocketWise\Categories;
use App\Models\PocketWise\Envelopes;
use Livewire\Attributes\On;
use Livewire\Component;

class Index extends Component
{
    public TransactionForm $form;

    public $state = 'create';

    public $envelopes = [];

    public function updatedFormCategoryId($value)
    {
        $this->envelopes = $this->form->updatedFormCategoryId($value);
        // dd($this->envelopes);
    }

    public function open()
    {
        $this->state = 'create';

        $this->form->open();
    }

    public function save()
    {
        $this->form->save();

        $this->dispatch('pg:eventRefresh-transactionsTable');
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

        $this->dispatch('pg:eventRefresh-transactionsTable');
    }

    #[On('destroy')]
    public function destroy($id)
    {
        $this->form->destroy($id);

        $this->dispatch('pg:eventRefresh-transactionsTable');
    }

    public function exit()
    {
        $this->form->exit();
    }

    public function render()
    {
        return view('livewire.pocket-wise.transactions.index',[
            'categories' => Categories::orderBy('name','asc')->pluck('name', 'id')
        ]);
    }
}
