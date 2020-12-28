@component('mail::message')
# {{ trans('email.approved_order.header', ['name' => $name]) }}
{{ trans('email.approved_order.title') }}

* {{ trans('email.approved_order.name') }} : {{ $name }}
* {{ trans('email.approved_order.address') }} : {{ $order->address }}
* {{ trans('email.approved_order.phone') }} : {{ $order->phone }}
* {{ trans('email.approved_order.total_price') }} : {{ number_format($order->total_price) . " VND" }}
* {{ trans('email.approved_order.created_at') }} : {{ $order->created_at->format(config('setting.date')) }}
* {{ trans('email.approved_order.updated_at') }} : {{ $order->updated_at->format(config('setting.date')) }}

@component('mail::table')
| {{ trans('email.approved_order.item.product_name') }} | {{ trans('email.approved_order.item.quantity') }} | {{ trans('email.approved_order.item.unit_price') }} |
| :--------------------------------- | :---------------------- | :------------------------------------------------ |
@foreach ($itemInOrder as $item)
| {{ $item['product_detail_name'] }} | {{ $item['quantity'] }} | {{ number_format($item['unit_price']) . " VND" }} |
@endforeach
@endcomponent
{{ trans('email.auto_message') }}


{{ trans('email.regards') }},
\
{{ config('app.name') }}
@endcomponent
