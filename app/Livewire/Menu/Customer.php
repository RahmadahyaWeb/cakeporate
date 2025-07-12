<?php

namespace App\Livewire\Menu;

use App\Livewire\BaseComponent;
use App\Models\Customer as ModelsCustomer;
use Livewire\Component;

class Customer extends BaseComponent
{
    public $target = "create, edit, save, delete, toggleCrudModal";

    public $modalTitle = 'Form Pelanggan';

    protected array $permissionMap = [
        'save' => ['edit customer'],
        'edit' => ['edit customer'],
        'delete' => ['delete customer']
    ];

    public $editing =  [
        'id' => '',
        'code' => '',
        'name' => '',
        'contact' => '',
        'address' => '',
    ];

    public function create()
    {
        $this->validate([
            'editing.name' => 'required',
            'editing.contact' => 'required',
        ]);

        $this->executeSave(function () {
            ModelsCustomer::create([
                'code' => ModelsCustomer::generateCustomerCode(),
                'name' => $this->editing['name'],
                'contact' => $this->editing['contact'],
                'address' => $this->editing['address']
            ]);
        });
    }

    public function edit($id)
    {
        $this->editRecord($id, [
            'model' => ModelsCustomer::class,
            'with' => [],
            'map' => function ($data) {
                return [
                    'id' => $data->id,
                    'name' => $data->name,
                    'contact' => $data->contact,
                    'address' => $data->address,
                ];
            }
        ]);
    }

    public function save()
    {
        $this->validate([
            'editing.name' => 'required',
            'editing.contact' => 'required',
        ]);

        $this->executeSave(function () {
            $user = ModelsCustomer::findOrFail($this->editing['id']);

            $user->name = $this->editing['name'];
            $user->contact = $this->editing['contact'];
            $user->address = $this->editing['address'];
            $user->save();
        });
    }

    public function delete($id)
    {
        $this->executeDelete(function () use ($id) {
            $user = ModelsCustomer::findOrFail($id);
            $user->delete();
        });
    }

    public function render()
    {
        $rows = ModelsCustomer::paginate();

        $columns = [
            'code' => 'Kode Pelanggan',
            'name' => 'Nama Pelanggan',
            'contact' => 'Kontak',
            'address' => 'Alamat'
        ];

        return view('livewire.menu.customer', compact(
            'rows',
            'columns'
        ));
    }
}
