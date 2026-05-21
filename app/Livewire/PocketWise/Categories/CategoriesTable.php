<?php

namespace App\Livewire\PocketWise\Categories;

use App\Models\PocketWise\Categories;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Blade;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use Closure;

final class CategoriesTable extends PowerGridComponent
{
    public string $tableName = 'categoriesTable';

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
        return Categories::with('user')
            ->selectRaw("
                categories.*,
                CASE type
                    WHEN 'want' THEN 'Deseo'
                    WHEN 'need' THEN 'Necesidad'
                    WHEN 'savings' THEN 'Ahorro'
                    ELSE type
                END as type_label
            ")
            ->selectRaw("
                categories.*,
                CASE is_fixed
                    WHEN 0 THEN 'Variable'
                    WHEN 1 THEN 'Fijo'
                END as is_fixed_label
            ")
            ->leftJoin('users', 'users.id', '=', 'categories.user_id')
            ->selectRaw('categories.*, users.name as user_name')
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
            ->add('name')
            ->add('type')
            ->add('is_fixed')
            ->add('monthly_budget')
            ->add('icon')
            ->add('color_preview', function ($category) {
                return '
                    <div 
                        class="w-6 h-6 rounded-full border mx-auto"
                        style="background-color: '.$category->color.'"
                    ></div>
                ';
            })
            ->add('updated_at')
            ->add('created_at');
    }

    public function columns(): array
    {
        return [
            Column::make('Id', 'id'),
            Column::make('User id', 'user_name'),
            Column::make('Name', 'name')
                ->sortable()
                ->searchable(),

            Column::make('Type', 'type_label')
                ->sortable()
                ->searchable(),

            Column::make('Is fixed', 'is_fixed_label')
                ->sortable()
                ->searchable(),

            Column::make('Monthly budget', 'monthly_budget')
                ->sortable()
                ->searchable(),

            Column::make('Icon', 'icon')
                ->sortable()
                ->searchable(),

            Column::make('Color', 'color_preview'),

            // Column::make('Uptated at', 'updated_at')
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
        ];
    }

    public function actions(Categories $row): array
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
                ->tooltip('Eliminar'),
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
