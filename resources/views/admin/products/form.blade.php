@extends('admin.layouts.app')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header">
                    <h2>Create Product</h2>
                </div>
                <div class="card-body">
                    <form class="form" action="@yield('action-url')" method="POST"
                          enctype="multipart/form-data">
                        @csrf
                        @yield('method-field')
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="name"
                                                   class="required @error('name') text-danger @enderror">Name</label>
                                            <input id="name"
                                                   class="form-control @error('name') is-invalid @enderror"
                                                   type="text" name="name" placeholder="Name"
                                                   @if (old('name')) value="{{ old('name') }}"
                                                   @else value="@yield('name')" @endif/>
                                            @error('name')
                                            <small class="form-text text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group m-0">
                                            <label for="bannerImage">Image</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input"
                                                           id="bannerImage" name="image"
                                                           accept=".png, .jpg, .jpeg, .svg, .webp, .gif">
                                                    <label class="custom-file-label" for="bannerImage">Choose image</label>
                                                </div>
                                            </div>
                                            <small
                                                class="text-muted">Image size can not be more than <b
                                                    class="text-danger">1024 KB</b>.</small>
                                            @error('image')
                                            <small class="form-text text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        @yield('image-show')
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="purchase_price @error('purchase_price') text-danger @enderror">Purchase Price</label>
                                    <input id="purchase_price"
                                           class="form-control  @error('purchase_price') is-invalid @enderror"
                                           type="number" name="purchase_price" placeholder="Purchase price"
                                           @if (old('purchase_price')) value="{{ old('purchase_price') }}"
                                           @else value="@yield('purchase_price')" @endif/>

                                    @error('purchase_price')
                                    <small class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="sale_price @error('sale_price') text-danger @enderror">Sale Price</label>
                                    <input id="sale_price"
                                           class="form-control  @error('sale_price') is-invalid @enderror"
                                           type="number" name="sale_price" placeholder="Sale price"
                                           @if (old('sale_price')) value="{{ old('sale_price') }}"
                                           @else value="@yield('sale_price')" @endif/>

                                    @error('sale_price')
                                    <small class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <button type="submit"
                                        class="btn btn-success rounded-1">@yield('submit-btn-text')</button>
                                <a href="{{ route('admin.products.index') }}"
                                   class="btn btn-danger rounded-1">Cancel</a>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
