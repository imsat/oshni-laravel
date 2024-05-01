<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class StockReportController extends Controller
{
    public function index()
    {
        $products = DB::table('products')
            ->leftJoin('purchase_items', 'products.id', '=', 'purchase_items.product_id')
            ->leftJoin('purchase_item_barcodes', 'purchase_items.id', '=', 'purchase_item_barcodes.purchase_item_id')
            ->leftJoin('purchase_return_items', 'products.id', '=', 'purchase_return_items.product_id')
            ->leftJoin('purchase_return_item_barcodes', 'purchase_return_items.id', '=', 'purchase_return_item_barcodes.purchase_return_item_id')
            ->leftJoin('sale_items', 'products.id', '=', 'sale_items.product_id')
            ->leftJoin('sale_item_barcodes', 'sale_items.id', '=', 'sale_item_barcodes.sale_item_id')
            ->leftJoin('sale_return_items', 'products.id', '=', 'sale_return_items.product_id')
            ->leftJoin('sale_return_item_barcodes', 'sale_return_items.id', '=', 'sale_return_item_barcodes.sale_return_item_id')
            ->selectRaw('products.id as product_id,
            products.name as product_name,
            SUM(purchase_item_barcodes.quantity) as purchase_qty,
            CONCAT(purchase_return_item_barcodes.quantity) as purchase_return_qty,
            CONCAT(sale_item_barcodes.quantity) as sale_qty,
            CONCAT(sale_return_item_barcodes.quantity) as sale_return_qty,
            (SUM(purchase_item_barcodes.quantity) + CONCAT(sale_return_item_barcodes.quantity) - (CONCAT(sale_item_barcodes.quantity) +  CONCAT(purchase_return_item_barcodes.quantity))) as stock_qty
            ')
            ->groupBy('products.id')
            ->paginate(10);

        return view('admin.stocks.index', compact('products'));
    }
}
