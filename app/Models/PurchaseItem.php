<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseItem extends Model
{
    use HasFactory;

    public function purchase_item_barcodes()
    {
        return $this->hasMany(PurchaseItemBarcode::class, 'purchase_item_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
