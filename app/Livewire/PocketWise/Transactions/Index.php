<?php

namespace App\Livewire\PocketWise\Transactions;

use App\Livewire\Forms\TransactionForm;
use App\Models\PocketWise\Categories;
use App\Models\PocketWise\Envelopes;
use Flux\Flux;
use Livewire\Attributes\On;
use Livewire\Component;

class Index extends Component
{
    public TransactionForm $form;

    public $state = 'create';

    public ?int $idDestroy = null;

    public $envelopes = [];

    public function updatedFormCategoryId(int $value)
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
    public function edit(int $id)
    {
        $this->state = 'update';

        $this->envelopes = $this->form->edit($id);

        $this->form->show();
    }

    public function update()
    {
        $this->form->update();

        $this->dispatch('pg:eventRefresh-transactionsTable');
    }

    #[On('destroy')]
    public function destroy(int $id)
    {
        $this->idDestroy = $id;

        Flux::modal('delete-transaction')->show();
    }

    public function confirmDestroy()
    {
        $this->form->destroy($this->idDestroy);

        Flux::modal('delete-transaction')->close();

        $this->dispatch('pg:eventRefresh-transactionsTable');
        
        $this->idDestroy = null;
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
