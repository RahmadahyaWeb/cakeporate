<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $guarded = [];

    public static function generateCustomerCode()
    {
        $lastCode = self::orderBy('code', 'desc')->value('code');

        $lastNumber = $lastCode ? (int)str_replace('CUST-', '', $lastCode) : 0;

        $nextNumber = $lastNumber + 1;

        return 'CUST-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
    }
}
