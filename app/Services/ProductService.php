<?php

namespace App\Services;


use App\Models\Product;

class ProductService
{
    private $filePath = '/product';

    /**
     * Create or update user.
     *
     * @param $data
     * @param $product
     * @return Product|null
     */

    public function createOrUpdate($data, $product = null)
    {
        // Image upload
        if (data_get($data, 'image')) {
            if (!blank($product) && $product->getRawOriginal('image')) {
                UploadService::cleanFile($product->getRawOriginal('image'));
            }
            $data['image'] = UploadService::upload($data['image'], $this->filePath);
        }

        // Check exists product
        if (blank($product)) {
            $product = new Product();
        }
        $product->fill($data);
        $product->save();
        return $product->fresh();
    }

}
