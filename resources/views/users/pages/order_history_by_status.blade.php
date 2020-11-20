@extends('users.master')

@section('content')
<div class="wrap-user-order-history-by-status-page">
    <div class="hero-wrap hero-bread">
        <div class="container">
            <div class="row no-gutters slider-text align-items-center justify-content-center">
                <div class="col-md-9 ftco-animate text-center">
                    <h1 class="mb-0 bread">{{ trans('user.order_history') }}</h1>
                </div>
            </div>
        </div>
    </div>
    <section class="ftco-section bg-light">
        <div class="container">
            <div class="list-status">
                <a href="{{ route('user.orderHistory') }}" class="btn btn-info">{{ trans('user.order_history.show_all') }}</a>
                <a href="{{ route('user.orderHistoryByStatus') }}" class="btn btn-info">{{ trans('user.order_history.show_by_status') }}</a>
            </div>
            <div class="group-tabs">
                <ul class="nav nav-pills">
                    @foreach (config('order.status') as $key => $value)
                        <li
                            class="tab-status
                            @if ($value == config('order.status.pending'))
                                {{ "active" }}
                            @endif">
                            <a href="#{{ $key }}" data-toggle="tab">{{ trans('user.order.' .  $key) }}</a>
                        </li>
                    @endforeach
                </ul>
                <div class="tab-content">
                    @foreach (config('order.status') as $key => $status)
                        <div class="
                            tab-pane fade in active
                            @if ($status == config('order.status.pending'))
                                {{ "show" }}
                            @endif"
                             id="{{ $key }}" >
                            <table class="table table-bordered table-striped">
                                <thead class="thead-primary">
                                <tr>
                                    <th>#</th>
                                    <th>{{ trans('user.order_history.total_payment') }}</th>
                                    <th>{{ trans('user.order_history.status') }}</th>
                                    <th>{{ trans('user.order_history.note') }}</th>
                                    <th>{{ trans('user.order_history.time_order') }}</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @php
                                    $number = 1;
                                @endphp
                                @foreach ($orders->where('status', $status) as $order)
                                    <tr>
                                        <td>{{ $number++ }}</td>
                                        <td>{{ number_format($order->total_price) . trans('admin.money.vi') }}</td>
                                        <td><span class="label label-primary">{{ trans('user.order.' . $key) }}</span></td>
                                        <td>{{ $order->note }}</td>
                                        <td>{{ $order->created_at }}</td>
                                        <td>
                                            @include ('users.modals.order_detail')
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@section('js')
    <script src="{{ asset('js/order_history_by_status.js') }}"></script>
@endsection
