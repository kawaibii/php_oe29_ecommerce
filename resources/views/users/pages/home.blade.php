@extends('users.master')

@section('content')
    @include("users.elements.slide")
    @include('users.components.homes.introduce_component')
    @include('users.components.homes.new_shoes_arrival_component')
    @include('users.components.homes.sale_component')
    @include('users.components.homes.introduce_product_component')
    @include('users.components.homes.satisfied_customer_component')
@endsection

@section('js')

@endsection
