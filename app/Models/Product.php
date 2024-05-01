<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image',
        'purchase_price',
        'sale_price',
    ];

    /**
     * Get the user's image.
     */
    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn ($image) => $image ? asset('storage'.  $image)  : 'https://picsum.photos/id/20/575/350',
        );
    }
}
