@extends('admin.layouts.master')

@section('content')
    <div class="wrap-admin-list-category-page">
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">{{ trans('admin.category.title') }}</h1>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        @include('admin.categories.modals.create')
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>{{ trans('admin.category.name') }}</th>
                                                <th>{{ trans('admin.category.belongs_to') }}</th>
                                                <th>{{ trans('admin.category.created_at') }}</th>
                                                <th>{{ trans('admin.category.updated_at') }}</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $index = 1;
                                            @endphp
                                            @foreach ($categories as $category)
                                                <tr>
                                                    <td>{{ $index++ }}</td>
                                                    <td>{{ $category->name }}</td>
                                                    <td>
                                                        @if ($category->parent_id != null)
                                                            @foreach ($parents as $parent)
                                                                @if ($parent->id == $category->parent_id)
                                                                    {{ $parent->name }}

                                                                    @break
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                    </td>
                                                    <td>{{ $category->created_at }}</td>
                                                    <td>{{ $category->updated_at }}</td>
                                                    <td>
                                                        @include('admin.categories.modals.edit')
                                                        @include('admin.categories.modals.delete')
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('bower_components/bower_project1/admin/js/dataTables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('bower_components/bower_project1/admin/js/dataTables/dataTables.bootstrap.min.js') }}"></script>
    <script src={{ mix('js/admin_list_brand.js') }}></script>
@endsection
