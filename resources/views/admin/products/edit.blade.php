@extends('admin.products.form')

@push('title', 'Edit Product')
@section('header-title', 'Edit Product')
@section('action-url', route('admin.products.update', $product->id))
@section('method-field', method_field('PUT'))


@section('name', $product->name)
@section('purchase_price', $product->purchase_price)
@section('sale_price', $product->sale_price)
@section('image-show')
    <img src="{{$product->image}}" class="img-thumbnail w-70 mb-3" alt="Product image">
@endsection

@section('submit-btn-text', 'Edit')
