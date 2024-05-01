@extends('admin.layouts.app')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="text-center text-danger">[Solve using Eloquent ORM]</h3>
                </div>
                <div class="card-header">
                    <h3 class="card-title">Purchase List</h3>
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
                    <table class="table table-hover text-nowrap">
                        <thead>
                        <tr>
                            <th>Serial Number</th>
                            <th>Date</th>
                            <th>Supplier</th>
                            <th>Total Quantity</th>
                            <th>Item with Barcodes</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($purchases as $purchase)
                            <tr>
                                <td>{{$purchase->serial_number }}</td>
                                <td>{{$purchase->date}}</td>
                                <td>{{$purchase?->supplier?->name}}</td>
                                <td>{{$purchase?->barcodes_sum_quantity}}</td>
                                <td>
                                    @foreach($purchase?->purchase_items as $item)
                                                <p>{{$item?->product?->name}} => {{$item->purchase_item_barcodes->pluck('barcode')->implode(' || ')}}</p>
                                    @endforeach
{{--                                    {{$purchase->}}--}}
                                </td>

                            </tr>
                        @empty
                            <p class="text-center">No product yet</p>
                        @endforelse
                        </tbody>
                    </table>

                    <div class="d-flex justify-content-center">
                        {{ $purchases->links()}}
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
@endsection
