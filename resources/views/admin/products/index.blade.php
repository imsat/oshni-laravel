@extends('admin.layouts.app')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="text-center text-danger">[Solve using Eloquent ORM]</h3>
                    <ul>
                        <li>List The Product</li>
                        <li>Store The Product</li>
                        <li>Update The Product</li>
                        <li>Delete The Product</li>
                    </ul>
                    <a href="{{route('admin.products.create')}}" class="btn btn-primary btn-sm float-right">Add New</a>
                </div>
                <div class="card-header">
                    <h3 class="card-title">Product List</h3>
                    <div class="card-tools">

                        <div class="input-group input-group-sm" style="width: 150px;">
                            <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

                            <div class="input-group-append">
                                <button type="submit" class="btn btn-default">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap text-center">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Image</th>
                            <th>Purchase Price</th>
                            <th>Sale Price</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($products as $product)
                            <tr>
                                <td>{{$product->id}}</td>
                                <td>{{$product->name}}</td>
                                <td><img src="{{$product->image}}" class="img-fluid w-70" alt="Product img"></td>
                                <td>{{$product->purchase_price}}</td>
                                <td>{{$product->sale_price}}</td>
                                <td>
                                    <a href="{{route('admin.products.edit', $product->id)}}" class=" text-success "><i class="fas fa-edit"></i></a>
                                    <form action="{{route('admin.products.destroy', $product->id)}}" class="d-inline" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn" onclick="return confirm('Are you sure to delete?')"><i class="fas fa-trash text-danger"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <p class="text-center">No product yet</p>
                        @endforelse
                        </tbody>
                    </table>

                    <div class="d-flex justify-content-center">
                        {{ $products->links()}}
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
@endsection
