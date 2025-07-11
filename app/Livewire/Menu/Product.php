<?php

namespace App\Livewire\Menu;

use App\Livewire\BaseComponent;
use App\Models\Product as ModelsProduct;
use App\Models\ProductCategory;

class Product extends BaseComponent
{
    public $target = "create, edit, save, delete, toggleCrudModal";

    public $modalTitle = 'Form Produk';

    protected array $permissionMap = [
        'save' => ['edit product'],
        'edit' => ['edit product'],
        'delete' => ['delete product']
    ];

    public $editing =  [
        'id' => '',
        'product_category_id' => '',
        'code' => '',
        'name' => '',
        'description' => '',
        'unit_type' => '',
        'price' => '',
        'is_active' => '1',
    ];

    public $productCategoriesGroup;

    public function mount()
    {
        $this->fetchProductCategories();
    }

    public function fetchProductCategories()
    {
        $this->productCategoriesGroup = ProductCategory::all();
    }

    public function rules()
    {
        return [
            'editing.product_category_id' => 'required',
            'editing.name' => 'required',
            'editing.unit_type' => 'required',
            'editing.price' => 'required',
            'editing.is_active' => 'required',
        ];
    }

    public function create()
    {
        $this->validate();

        $this->executeSave(function () {
            ModelsProduct::create([
                'code' => ModelsProduct::generateProductCode(),
                'product_category_id' => $this->editing['product_category_id'],
                'name' => $this->editing['name'],
                'description' => $this->editing['description'],
                'unit_type' => $this->editing['unit_type'],
                'price' => $this->editing['price'],
                'is_active' => $this->editing['is_active']
            ]);
        });
    }

    public function edit($id)
    {
        $this->editRecord($id, [
            'model' => ModelsProduct::class,
            'with' => ['category'],
            'map' => function ($data) {
                return [
                    'id' => $data->id,
                    'name' => $data->name,
                    'description' => $data->description,
                    'product_category_id' => $data->product_category_id,
                    'unit_type' => $data->unit_type,
                    'price' => $data->price,
                    'is_active' => $data->is_active,
                ];
            }
        ]);
    }

    public function save()
    {
        $this->validate();

        $this->executeSave(function () {
            $service = ModelsProduct::findOrFail($this->editing['id']);

            $service->update([
                'product_category_id' => $this->editing['product_category_id'],
                'name' => $this->editing['name'],
                'description' => $this->editing['description'],
                'unit_type' => $this->editing['unit_type'],
                'price' => $this->editing['price'],
                'is_active' => $this->editing['is_active']
            ]);
        });
    }

    public function delete($id)
    {
        $this->executeDelete(function () use ($id) {
            $service = ModelsProduct::findOrFail($id);
            $service->delete();
        });
    }

    public function render()
    {
        $rows = ModelsProduct::with(['category'])->paginate();

        $columns = [
            'code' => 'Kode Produk',
            'category.name' => 'Kategori Produk',
            'name' => 'Nama Produk',
            'description' => 'Deskripsi Produk',
            'unit_type' => 'Satuan',
            'price' => 'Harga Produk',
            'is_active' => 'Status'
        ];

        $columnFormats = [
            'price' => fn($row) => $this->format_rupiah($row->price),
            'is_active' => function ($row) {
                $label = $row->is_active ? 'Aktif' : 'Nonaktif';
                $color = $row->is_active ? 'bg-blue-100 text-blue-700' : 'bg-red-100 text-red-700';

                return '<span class="px-2 py-1 rounded-full text-xs ' . $color . '">' . $label . '</span>';
            },
        ];

        $cellClass = function ($row, $field) {
            $columnsWithClass = [
                'code',
                'name',
                'price'
            ];

            if (in_array($field, $columnsWithClass)) {
                return 'whitespace-nowrap';
            }
            return '';
        };

        return view('livewire.menu.product', compact(
            'rows',
            'columns',
            'columnFormats',
            'cellClass'
        ));
    }
}
