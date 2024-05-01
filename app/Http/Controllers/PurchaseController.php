<?php

namespace App\Http\Controllers;

use App\Models\Purchase;

class PurchaseController extends Controller
{
    public function index()
    {
        $purchases = Purchase::with([
            'supplier:id,name',
            'barcodes',
            'purchase_items:id,purchase_id,product_id',
            'purchase_items.product:id,name',
            'purchase_items.purchase_item_barcodes',
        ])
            ->withSum('barcodes', 'quantity')
            ->latest()
            ->paginate(10);

        return view('admin.purchases.index', compact('purchases'));
    }
}
