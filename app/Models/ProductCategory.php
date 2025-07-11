<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    protected $fillable = ['name', 'description', 'code'];

    public static function generateCategoryCode()
    {
        $lastCode = self::orderBy('code', 'desc')->value('code');

        $lastNumber = $lastCode ? (int)str_replace('PC-', '', $lastCode) : 0;

        $nextNumber = $lastNumber + 1;

        return 'PC-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
