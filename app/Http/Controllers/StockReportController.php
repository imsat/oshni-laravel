<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class StockReportController extends Controller
{
    public function index()
    {
        // Raw SQL query to fetch product quantities. not a fan for raw query!
        $productQuantitiesQuery = "
            SELECT
                p.id AS product_id,
                p.name AS product_name,
                COALESCE(purchase_qty, 0) AS purchase_qty,
                COALESCE(purchase_return_qty, 0) AS purchase_return_qty,
                COALESCE(sale_qty, 0) AS sale_qty,
                COALESCE(sale_return_qty, 0) AS sale_return_qty,
                (COALESCE(purchase_qty, 0) + COALESCE(sale_return_qty, 0)) - (COALESCE(sale_qty, 0) + COALESCE(purchase_return_qty, 0)) AS stock_qty
            FROM
                products p
            LEFT JOIN (
                SELECT
                    product_id,
                    SUM(pib.quantity) AS purchase_qty
                FROM
                    purchase_items pi
                LEFT JOIN
                    purchase_item_barcodes pib ON pi.id = pib.purchase_item_id
                GROUP BY
                    product_id
            ) purchases ON p.id = purchases.product_id
            LEFT JOIN (
                SELECT
                    product_id,
                    SUM(prib.quantity) AS purchase_return_qty
                FROM
                    purchase_return_items pri
                LEFT JOIN
                    purchase_return_item_barcodes prib ON pri.id = prib.purchase_return_item_id
                GROUP BY
                    product_id
            ) purchase_return_items ON p.id = purchase_return_items.product_id
            LEFT JOIN (
                SELECT
                    product_id,
                    SUM(sib.quantity) AS sale_qty
                FROM
                    sale_items si
                LEFT JOIN
                    sale_item_barcodes sib ON si.id = sib.sale_item_id
                GROUP BY
                    product_id
            ) sale_items ON p.id = sale_items.product_id
            LEFT JOIN (
                SELECT
                    product_id,
                    SUM(srib.quantity) AS sale_return_qty
                FROM
                    sale_return_items sri
                LEFT JOIN
                    sale_return_item_barcodes srib ON sri.id = srib.sale_return_item_id
                GROUP BY
                    product_id
            ) returns ON p.id = returns.product_id
        ";

        // Paginate the results
        $products = DB::table(DB::raw("($productQuantitiesQuery) as subquery"))
            ->paginate(10);

        return view('admin.stocks.index', compact('products'));


        // Old garbage code
//        $products = DB::table('products')
//            ->leftJoin('purchase_items', 'products.id', '=', 'purchase_items.product_id')
//            ->leftJoin('purchase_item_barcodes', 'purchase_items.id', '=', 'purchase_item_barcodes.purchase_item_id')
//            ->leftJoin('purchase_return_items', 'products.id', '=', 'purchase_return_items.product_id')
//            ->leftJoin('purchase_return_item_barcodes', 'purchase_return_items.id', '=', 'purchase_return_item_barcodes.purchase_return_item_id')
//            ->leftJoin('sale_items', 'products.id', '=', 'sale_items.product_id')
//            ->leftJoin('sale_item_barcodes', 'sale_items.id', '=', 'sale_item_barcodes.sale_item_id')
//            ->leftJoin('sale_return_items', 'products.id', '=', 'sale_return_items.product_id')
//            ->leftJoin('sale_return_item_barcodes', 'sale_return_items.id', '=', 'sale_return_item_barcodes.sale_return_item_id')
//            ->selectRaw('products.id as product_id,
//            products.name as product_name,
//            SUM(purchase_item_barcodes.quantity) as purchase_qty,
//            CONCAT(purchase_return_item_barcodes.quantity) as purchase_return_qty,
//            CONCAT(sale_item_barcodes.quantity) as sale_qty,
//            CONCAT(sale_return_item_barcodes.quantity) as sale_return_qty,
//            (SUM(purchase_item_barcodes.quantity) + CONCAT(sale_return_item_barcodes.quantity) - (CONCAT(sale_item_barcodes.quantity) +  CONCAT(purchase_return_item_barcodes.quantity))) as stock_qty
//            ')
//            ->groupBy('products.id')
//            ->paginate(10);
    }
}
