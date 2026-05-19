<?php

namespace App\Livewire\PocketWise\Envelopes;

use App\Models\PocketWise\Envelopes;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Blade;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;

final class EnvelopesTable extends PowerGridComponent
{
    public string $tableName = 'envelopesTable';

    public function setUp(): array
    {
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
        return Envelopes::with('user','category')
            ->join('users', 'users.id', '=', 'envelopes.user_id')
            ->join('categories', 'categories.id', '=', 'envelopes.category_id')
            ->selectRaw('envelopes.*, users.name as user_name')
            ->selectRaw('envelopes.*, categories.name as category_name')
            ->orderBy('id','desc');
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
            ->add('allocated_amount')
            ->add('spent_amount')
            ->add('month_year')
            ->add('updated_at')
            ->add('created_at');
    }

    public function columns(): array
    {
        return [
            Column::make('Id', 'id'),
            Column::make('Usuario', 'user_name'),
            Column::make('Categoría', 'category_name'),
            Column::make('Presupuesto', 'allocated_amount')
                ->sortable()
                ->searchable(),

            Column::make('Gastado', 'spent_amount')
                ->sortable()
                ->searchable(),

            Column::make('Año - Mes', 'month_year')
                ->sortable()
                ->searchable(),

            // Column::make('Ultima Actualización', 'updated_at')
            //     ->sortable(),

            Column::make('Fecha y Hora', 'created_at')
                ->sortable()
                ->searchable(),

            Column::action('Action')
        ];
    }

    public function filters(): array
    {
        return [
        ];
    }

    // #[\Livewire\Attributes\On('edit')]
    // public function edit($rowId): void
    // {
    //     $this->js('alert('.$rowId.')');
    // }

    public function actions(Envelopes $row): array
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
                ->confirm('Está seguro de eliminar este Sobre?')
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
