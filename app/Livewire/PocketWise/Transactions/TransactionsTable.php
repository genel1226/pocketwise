<?php

namespace App\Livewire\PocketWise\Transactions;

use App\Models\PocketWise\Transactions;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Blade;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;

final class TransactionsTable extends PowerGridComponent
{
    public string $tableName = 'transactionsTable';

    public function setUp(): array
    {
        // $this->showCheckBox();

        return [
            PowerGrid::header()
                ->showSearchInput(),
            PowerGrid::footer()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    public function datasource(): Builder
    {
        return Transactions::query();
    }

    public function relationSearch(): array
    {
        return [];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('user_id')
            ->add('category_id')
            ->add('envelope_id')
            ->add('amount')
            ->add('type')
            ->add('description')
            ->add('date_formatted', fn (Transactions $model) => Carbon::parse($model->date)->format('d/m/Y'))
            ->add('tags')
            ->add('receipt_path')
            ->add('is_recurring')
            ->add('created_at');
    }

    public function columns(): array
    {
        return [
            Column::make('Id', 'id'),
            Column::make('Usuario', 'user_id'),
            Column::make('Categoría', 'category_id'),
            Column::make('Sobre', 'envelope_id'),
            Column::make('Monto', 'amount')
                ->sortable()
                ->searchable(),

            Column::make('Tipo', 'type')
                ->sortable()
                ->searchable(),

            Column::make('Descripción', 'description')
                ->sortable()
                ->searchable(),

            Column::make('Fecha', 'date_formatted', 'date')
                ->sortable(),

            // Column::make('Tags', 'tags')
            //     ->sortable()
            //     ->searchable(),

            // Column::make('Recibo', 'receipt_path')
            //     ->sortable()
            //     ->searchable(),

            Column::make('Recurrente', 'is_recurring')
                ->sortable()
                ->searchable(),

            // Column::make('Created at', 'created_at_formatted', 'created_at')
            //     ->sortable(),

            // Column::make('Created at', 'created_at')
            //     ->sortable()
            //     ->searchable(),

            Column::action('Action')
        ];
    }

    public function filters(): array
    {
        return [
            // Filter::datepicker('date'),
        ];
    }

    // #[\Livewire\Attributes\On('edit')]
    // public function edit($rowId): void
    // {
    //     $this->js('alert('.$rowId.')');
    // }

    public function actions(Transactions $row): array
    {
        return [
            Button::add('edit')
                ->slot(Blade::render('<x-heroicon-s-pencil-square class="w-3 h-3" />'))
                ->class('pg-btn-white dark:ring-pg-primary-600 dark:border-pg-primary-600 dark:hover:bg-pg-primary-700 dark:ring-offset-pg-primary-800 dark:text-pg-primary-300 dark:bg-pg-primary-700')
                ->dispatch('edit', ['id' => $row->id])
                ->tooltip('Editar'),
            Button::add('destroy')
                ->slot(Blade::render('<x-heroicon-s-trash class="w-3 h-3" />'))
                ->class('pg-btn-white dark:ring-pg-primary-600 dark:border-pg-primary-600 dark:hover:bg-pg-primary-700 dark:ring-offset-pg-primary-800 dark:text-pg-primary-300 dark:bg-pg-primary-700')
                ->dispatch('destroy', ['id' => $row->id])
                ->tooltip('Eliminar')
                ->confirm('Está seguro de eliminar esta Transacción?')
        ];
    }

    /*
    public function actionRules($row): array
    {
        return [
            // Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($row) => $row->id === 1)
                ->hide(),
        ];
    }
    */
}
