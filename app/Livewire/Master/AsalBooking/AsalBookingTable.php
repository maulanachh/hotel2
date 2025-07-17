<?php

namespace App\Livewire\Master\AsalBooking;

use App\Models\master\asalBooking;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Exportable;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Footer;
use PowerComponents\LivewirePowerGrid\Header;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\Traits\WithExport;
use Illuminate\Support\Facades\Auth;

final class AsalBookingTable extends PowerGridComponent
{
    use WithExport;
    public string $primaryKey = 'aslbooking_id';

    public string $sortField = 'aslbooking_id';
    public function setUp(): array
    {
        return [
            Exportable::make('export')
                ->striped()
                ->type(Exportable::TYPE_XLS, Exportable::TYPE_CSV),
            Header::make()->showSearchInput(),
            Footer::make()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    public function datasource(): Builder
    {
        return asalBooking::query();
    }

    public function relationSearch(): array
    {
        return [];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('aslbooking_id')
            ->add('aslbooking_name')
            ->add('keterangan')
            ->add('created_by')
            ->add('updated_by')
            ->add('deleted_by')
            ->add('created_at');
    }

    public function columns(): array
    {
        return [
            Column::make('id', 'aslbooking_id')
                ->sortable()
                ->searchable(),

            Column::make('asal booking', 'aslbooking_name')
                ->sortable()
                ->searchable(),

            Column::make('keterangan', 'keterangan')
                ->sortable()
                ->searchable(),

            Column::action('Action')
        ];
    }

    public function filters(): array
    {
        return [];
    }

    #[\Livewire\Attributes\On('edit')]
    public function edit($rowId): void
    {
        //$this->js('alert(' . $rowId . ')');
        $data = asalBooking::query()->find($rowId);
        session()->put([
            'aslbooking_id' => $rowId,
            'function' => 'edit'
        ]);
        redirect('/master/asalbooking/create');
    }
    #[\Livewire\Attributes\On('confirmDelete')]
    public function deleteRow($id)
    {
        $user = Auth::user();
        $data = asalBooking::find($id);
        if ($data) {
            $delete_data = $data->delete(); // Soft delete
            if ($delete_data) {
                $this->js("alert('asal booking \"{$data->aslbooking_name}\" berhasil dihapus.')");
            } else {
                $this->js("alert('Gagal menghapus asal booking \"{$data->aslbooking_name}\".')");
            }
        } else {
            $this->js("alert('Fitur tidak ditemukan.')");
        }
    }

    public function actions(asalBooking $row): array
    {
        return [
            Button::add('edit')
                ->slot('<i class="bx bx-edit-alt"></i> Edit')
                ->id()
                ->class('btn btn-ghost-primary waves-effect waves-light')
                ->dispatch('edit', ['rowId' => $row->aslbooking_id]),
            Button::add('delete')
                ->slot('<i class="bx bx-trash-alt"></i> delete')
                ->id()
                ->class('btn btn-ghost-danger waves-effect waves-light')
                ->dispatch('openDeleteModal', [
                    'rowId' => $row->aslbooking_id,
                    'jnskmrName' => $row->aslbooking_name,
                ])
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
