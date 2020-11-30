@extends('admin.layouts.master')

@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">{{ trans('admin.chart.title') }}</h1>
                </div>
            </div>
            <div class="row">
                <div id="container">
                    <div class="col-lg-12">
                        <canvas id="bar-chart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="url" data-url="{{ route('get_status_order_by_month') }}"></div>
@endsection

@section('js')
    <script src="{{ asset('js/admin_chart.js') }}"></script>
@endsection
