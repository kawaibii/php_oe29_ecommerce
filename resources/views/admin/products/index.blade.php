@extends('admin.layouts.master')

@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">{{ trans('admin.product.name') }}</h1>
                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal">{{ trans('admin.product.add_product') }}</button>
                </div>
            </div>
            @if (session('message_success'))
                <div class="text-center alert-danger">
                    {{ session('message_success') }}
                </div>
            @endif
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            {{ trans('admin.product.data_product') }}
                        </div>
                        @if (session('message'))
                            <div class="alert alert-danger">
                                {{ session('message') }}
                            </div>
                        @endif
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                    <tr>
                                        <th>{{ trans('admin.#') }}</th>
                                        <th>{{ trans('admin.product.name_product') }}</th>
                                        <th>{{ trans('admin.product.original_price') }}</th>
                                        <th>{{ trans('admin.product.current_price') }}</th>
                                        <th>{{ trans('admin.product.count_image') }}</th>
                                        <th>{{ trans('admin.product.count_product_detail') }}</th>
                                        <th>{{ trans('admin.action') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($products as $key => $product)
                                        <tr class="odd gradeX">
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $product->name }}</td>
                                            <td>{{ $product->original_price }}</td>
                                            <td class="center">{{ $product->current_price }}</td>
                                            <td class="center">{{ $product->images_count }}</td>
                                            <td class="center">{{ $product->product_details_count }}</td>
                                            <td class="center">
                                                <a href="{{ route('products.show', $product->id) }}">
                                                    <button class="btn btn-primary">{{ trans('admin.detail') }}</button>
                                                </a>
                                                <button type="button" class="btn btn-info">{{ trans('admin.edit') }}</button>
                                                <form action="{{ route('products.destroy', $product->id) }}"
                                                      data-message="{{ trans('confirm_delete', ['name' => $product->name]) }}"
                                                      method="post" onsubmit="deleteProduct(this)">
                                                    @csrf
                                                    @method("DELETE")
                                                    <button class="btn btn-danger" type="submit">{{ trans('admin.delete') }}</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
        </div>
        <!-- /.container-fluid -->
    </div>
    <div class="define" data-value = {{ $errors->first('show_modal') }} data-route={{ route('products.edit', $errors->first('route')) }}></div>
    @include('admin.products.modal_create_product')
@endsection
@section('js')
    <script src="{{ asset('bower_components/bower_project1/admin/js/dataTables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('bower_components/bower_project1/admin/js/dataTables/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ mix('js/productjs.js') }}"></script>
@endsection
