<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class StockReportController extends Controller
{
    public function index()
    {

        //without raw
//        $productQuantities = DB::table('products as p')
//            ->select('p.id as product_id', 'p.name as product_name')
//            ->leftJoin(function ($join) {
//                $join->select('pi.product_id', DB::raw('SUM(pib.quantity) as purchase_qty'))
//                    ->from('purchase_items as pi')
//                    ->leftJoin('purchase_item_barcodes as pib', 'pi.id', '=', 'pib.purchase_item_id')
//                    ->groupBy('pi.product_id');
//            }, 'p.id', '=', 'pi.product_id')
//            ->leftJoin(function ($join) {
//                $join->select('pri.product_id', DB::raw('SUM(prib.quantity) as purchase_return_qty'))
//                    ->from('purchase_return_items as pri')
//                    ->leftJoin('purchase_return_item_barcodes as prib', 'pri.id', '=', 'prib.purchase_return_item_id')
//                    ->groupBy('pri.product_id');
//            }, 'p.id', '=', 'pri.product_id')
//            ->addSelect(DB::raw('COALESCE(pi.purchase_qty, 0) as purchase_qty'))
//            ->addSelect(DB::raw('COALESCE(pri.purchase_return_qty, 0) as purchase_return_qty'))
//            ->get();

        $products = DB::table('products as p')
            ->leftJoin(DB::raw('(SELECT product_id, SUM(pib.quantity) AS purchase_qty FROM purchase_items pi LEFT JOIN purchase_item_barcodes pib ON pi.id = pib.purchase_item_id GROUP BY product_id) AS purchases'), 'p.id', '=', 'purchases.product_id')
            ->leftJoin(DB::raw('(SELECT product_id, SUM(prib.quantity) AS purchase_return_qty FROM purchase_return_items pri LEFT JOIN purchase_return_item_barcodes prib ON pri.id = prib.purchase_return_item_id GROUP BY product_id) AS purchase_returns'), 'p.id', '=', 'purchase_returns.product_id')
            ->leftJoin(DB::raw('(SELECT product_id, SUM(sib.quantity) AS sale_qty FROM sale_items si LEFT JOIN sale_item_barcodes sib ON si.id = sib.sale_item_id GROUP BY product_id) AS sales'), 'p.id', '=', 'sales.product_id')
            ->leftJoin(DB::raw('(SELECT product_id, SUM(srib.quantity) AS sale_return_qty FROM sale_return_items sri LEFT JOIN sale_return_item_barcodes srib ON sri.id = srib.sale_return_item_id GROUP BY product_id) AS sale_returns'), 'p.id', '=', 'sale_returns.product_id')
            ->selectRaw('p.id as product_id,
                                   p.name as product_name,
                                   COALESCE(purchases.purchase_qty, 0) AS purchase_qty,
                                   COALESCE(purchase_returns.purchase_return_qty, 0) AS purchase_return_qty,
                                   COALESCE(sales.sale_qty, 0) AS sale_qty,
                                   COALESCE(sale_returns.sale_return_qty, 0) AS sale_return_qty,
                                   (COALESCE(purchases.purchase_qty, 0) + COALESCE(sale_returns.sale_return_qty, 0)) - (COALESCE(sales.sale_qty, 0) + COALESCE(purchase_returns.purchase_return_qty, 0)) AS stock_qty
                                   ')
        ->paginate(10);
        return view('admin.stocks.index', compact('products'));


        /* Raw SQL query to fetch product quantities. not a fan for raw query!*/
//        $productQuantitiesQuery = "
//            SELECT
//                p.id AS product_id,
//                p.name AS product_name,
//                COALESCE(purchase_qty, 0) AS purchase_qty,
//                COALESCE(purchase_return_qty, 0) AS purchase_return_qty,
//                COALESCE(sale_qty, 0) AS sale_qty,
//                COALESCE(sale_return_qty, 0) AS sale_return_qty,
//                (COALESCE(purchase_qty, 0) + COALESCE(sale_return_qty, 0)) - (COALESCE(sale_qty, 0) + COALESCE(purchase_return_qty, 0)) AS stock_qty
//            FROM
//                products p
//            LEFT JOIN (
//                SELECT
//                    product_id,
//                    SUM(pib.quantity) AS purchase_qty
//                FROM
//                    purchase_items pi
//                LEFT JOIN
//                    purchase_item_barcodes pib ON pi.id = pib.purchase_item_id
//                GROUP BY
//                    product_id
//            ) purchases ON p.id = purchases.product_id
//            LEFT JOIN (
//                SELECT
//                    product_id,
//                    SUM(prib.quantity) AS purchase_return_qty
//                FROM
//                    purchase_return_items pri
//                LEFT JOIN
//                    purchase_return_item_barcodes prib ON pri.id = prib.purchase_return_item_id
//                GROUP BY
//                    product_id
//            ) purchase_return_items ON p.id = purchase_return_items.product_id
//            LEFT JOIN (
//                SELECT
//                    product_id,
//                    SUM(sib.quantity) AS sale_qty
//                FROM
//                    sale_items si
//                LEFT JOIN
//                    sale_item_barcodes sib ON si.id = sib.sale_item_id
//                GROUP BY
//                    product_id
//            ) sale_items ON p.id = sale_items.product_id
//            LEFT JOIN (
//                SELECT
//                    product_id,
//                    SUM(srib.quantity) AS sale_return_qty
//                FROM
//                    sale_return_items sri
//                LEFT JOIN
//                    sale_return_item_barcodes srib ON sri.id = srib.sale_return_item_id
//                GROUP BY
//                    product_id
//            ) returns ON p.id = returns.product_id
//        ";
//
//
//        $products = DB::table(DB::raw("($productQuantitiesQuery) as subquery"))
//            ->paginate(10);

//        return view('admin.stocks.index', compact('products'));
    }
}
