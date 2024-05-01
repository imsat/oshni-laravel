<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    public function purchase_items()
    {
        return $this->hasMany(PurchaseItem::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function barcodes()
    {
        return $this->hasManyThrough(PurchaseItemBarcode::class,
            PurchaseItem::class,
            'purchase_id',
            'purchase_item_id',
            'id',
            'id'
        );
    }
}
