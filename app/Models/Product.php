<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = [];

    public static function generateProductCode()
    {
        $lastCode = self::orderBy('code', 'desc')->value('code');

        $lastNumber = $lastCode ? (int)str_replace('PRD-', '', $lastCode) : 0;

        $nextNumber = $lastNumber + 1;

        return 'PRD-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
    }

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id');
    }
}
