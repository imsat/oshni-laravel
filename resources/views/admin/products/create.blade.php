@extends('admin.products.form')

@push('title', 'Add Product')
@section('header-title', 'Add Product')
@section('action-url', route('admin.products.store'))

@section('submit-btn-text', 'Add')
