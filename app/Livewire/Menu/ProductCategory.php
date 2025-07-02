<?php

namespace App\Livewire\Menu;

use App\Livewire\BaseComponent;
use App\Models\ProductCategory as ModelsProductCategory;

class ProductCategory extends BaseComponent
{
    public $target = "create, edit, save, delete, toggleCrudModal";

    public $modalTitle = 'Form Kategori Produk';

    protected array $permissionMap = [
        'save' => ['edit product-category'],
        'edit' => ['edit product-category'],
        'delete' => ['delete product-category']
    ];

    public $editing =  [
        'id' => '',
        'code' => '',
        'name' => '',
        'description' => '',
    ];

    public function rules()
    {
        return [
            'editing.name' => 'required',
        ];
    }

    public function create()
    {
        $this->validate();

        $this->executeSave(function () {
            ModelsProductCategory::create([
                'code' => ModelsProductCategory::generateCategoryCode(),
                'name' => strtolower($this->editing['name']),
                'description' => $this->editing['description']
            ]);
        });
    }


    public function edit($id)
    {
        $this->editRecord($id, [
            'model' => ModelsProductCategory::class,
            'with' => [],
            'map' => function ($data) {
                return [
                    'id' => $data->id,
                    'name' => $data->name,
                    'description' => $data->description
                ];
            }
        ]);
    }

    public function save()
    {
        $this->validate();

        $this->executeSave(function () {
            $productCategory = ModelsProductCategory::findOrFail($this->editing['id']);

            $productCategory->update([
                'name' => strtolower($this->editing['name']),
                'description' => $this->editing['description']
            ]);
        });
    }

    public function delete($id)
    {
        $this->executeDelete(function () use ($id) {
            $productCategory = ModelsProductCategory::findOrFail($id);
            $productCategory->delete();
        });
    }

    public function render()
    {
        $rows = ModelsProductCategory::paginate();

        $columns = [
            'code' => 'Kode Kategori Produk',
            'name' => 'Nama Kategori Produk',
            'description' => 'Deskripsi Kategori Produk'
        ];

        return view('livewire.menu.product-category', compact(
            'rows',
            'columns'
        ));
    }
}
