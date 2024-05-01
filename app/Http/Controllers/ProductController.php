<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Services\ProductService;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index()
    {
        try {
            $products = Product::select(['id', 'name', 'image', 'purchase_price', 'sale_price'])
                ->latest()
                ->paginate(10);
            return view('admin.products.index', compact('products'));
        } catch (\Exception $e) {
            return redirect()->back()->with('failed', $e->getMessage() ?? 'Something went wrong!');
        }
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        try {
            $data = $request->only(['name', 'image', 'purchase_price', 'sale_price']);
            $this->productService->createOrUpdate($data);
            return redirect()->route('admin.products.index')->with('success', 'Added successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('failed', $e->getMessage() ?? 'Something went wrong!');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        try {
            return view('admin.products.edit', compact('product'));
        } catch (\Exception $e) {
            return redirect()->back()->with('failed', $e->getMessage() ?? 'Something went wrong!');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, Product $product)
    {
        try {
            $data = $request->only(['name', 'image', 'purchase_price', 'sale_price']);
            $this->productService->createOrUpdate($data, $product);
            return redirect()->route('admin.products.index')->with('success', 'Updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('failed', $e->getMessage() ?? 'Something went wrong!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        try {
            $product->delete();
            return redirect()->back()->with('success', 'Deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('failed', $e->getMessage() ?? 'Something went wrong!');
        }
    }

}
