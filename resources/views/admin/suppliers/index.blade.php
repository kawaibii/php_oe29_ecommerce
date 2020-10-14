@extends('admin.layouts.master')

@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">{{ trans('admin.supplier.name') }}</h1>
                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal">{{ trans('admin.supplier.add_supplier') }}</button>
                </div>
            </div>
            @if (session('message_success'))
                <div class="text-center alert alert-success">
                    {{ session('message_success') }}
                </div>
        @endif
        <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            {{ trans('admin.supplier.data_supplier') }}
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
                                        <th>{{ trans('admin.supplier.name_supplier') }}</th>
                                        <th>{{ trans('admin.supplier.phone') }}</th>
                                        <th>{{ trans('admin.supplier.address') }}</th>
                                        <th>{{ trans('admin.description') }}</th>
                                        <th>{{ trans('admin.action') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($suppliers as $key => $supplier)
                                        <tr class="odd gradeX">
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $supplier->name }}</td>
                                            <td>{{ $supplier->phone }}</td>
                                            <td class="center">{{ $supplier->address }}</td>
                                            <td class="center">{{ $supplier->description }}</td>
                                            <td class="center">
                                                <button class="btn btn-primary">{{ trans('admin.supplier.import') }}</button>
                                                <button type="button" class="btn btn-primary">{{ trans('admin.detail') }}</button>
                                                <button type="button" class="btn btn-info">{{ trans('admin.edit') }}</button>
                                                <button class="btn btn-danger" type="submit">{{ trans('admin.delete') }}</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
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
    <div class="define" data-value = {{ $errors->first('show_modal') }} data-route={{ route('suppliers.edit', $errors->first('route')) }}></div>
    @include('admin.elements.loading')
@endsection
@section('js')
    <script src="{{ asset('bower_components/bower_project1/admin/js/dataTables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('bower_components/bower_project1/admin/js/dataTables/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ mix('js/admin_supplier.js') }}"></script>
@endsection
