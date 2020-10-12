@extends('admin.layouts.master')
@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header text-center">{{ trans('admin.product.name_product') }} : {{ $product->name }}</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="container">
                @if (session('message_success'))
                    <div class="alert alert-success">
                        {{ session('message_success') }}
                    </div>
                @endif
                <div class="row">
                    <div class="col-md-8">
                        <p class="item-product">
                            <span id="infor">{{ trans('admin.brand.name') }} </span>
                            {{ $product->brand->name }}
                        </p>
                        <p class="item-product">
                            <span id="infor">{{ trans('admin.category.name') }}</span>
                            {{ $product->category->name }}
                        <p class="item-product">
                            <span id="infor">{{ trans('admin.rate') }}</span>
                            {{ $product->rate }}
                        </p>
                        <p class="item-product">
                            <span id="infor">{{ trans('admin.description') }}</span>
                            {!! $product->description !!}
                        </p>
                        <p class="item-product">
                            <span id="infor">{{ trans('admin.quantity') }}</span>
                            {{ $product->productDetails->sum('quantity') }}
                        </p>
                    </div>
                    @if (count($images) != 0)
                        <div class="col-md-4">
                            <img  id ="image-product" src="{{ asset(config('setting.image.product') . $product->images->first()->image_link) }}" >
                        </div>
                    @endif
                </div>
            </div>

            <div class="container">
                <ul class="nav nav-pills" id="jtab">
                    <li><a data-toggle="pill" href="#image">{{ trans('admin.image') }}</a></li>
                    <li><a data-toggle="pill" href="#detail">{{ trans('admin.product.list_size') }}</a></li>
                </ul>
                <div class="tab-content">
                    @if (count($images))
                        <div id="image" class="tab-pane fade in active">
                            <h3>{{ trans('admin.image') }}</h3>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>{{ trans('admin.#') }}</th>
                                        <th>{{trans('admin.image')}}</th>
                                        <th>{{ trans('admin.action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($images as $key => $image)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>
                                            <img class="item-image" src="{{ asset(config('setting.image.product') . $image->image_link) }}">
                                        </td>
                                        <td>
                                            <form action="{{ route('delete.image', $image->id) }}"
                                                data-message ="{{ trans('admin.delete') . trans('admin.image') }}"
                                                onsubmit="confirmDelete(this)"
                                                method="post" >
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger" type="submit">{{ trans('admin.delete') }}</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="text-center">{{ $images->appends(config('setting.paginate.image'))->links() }}</div>
                        </div>
                    @else
                        <div id="image" class="tab-pane fade in active text-center">
                           <h2>{{ trans('admin.product.currently_image') }}</h2>
                        </div>
                    @endif
                    @if (count($productDetails))
                        <div id="detail" class="tab-pane fade">
                                <h3>{{ trans('admin.product.list_size') }}</h3>
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>{{ trans('admin.#') }}</th>
                                        <th>{{ trans('admin.product_size') }}</th>
                                        <th>{{ trans('admin.quantity') }}</th>
                                        <th>{{ trans('admin.action') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($productDetails as $key => $productDetail)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $productDetail->size }}</td>
                                            <td>{{ $productDetail->quantity }}</td>
                                            <td>
                                                <form action="{{ route('delete.productDetail', $productDetail->id) }}"
                                                    data-message ="{{ trans('admin.delete') . trans('admin.product.list_size')}}"
                                                    onsubmit="confirmDelete(this)"
                                                    method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-danger" type="submit">{{ trans('admin.delete') }}</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <div class="text-center">{{ $productDetails->appends(config('setting.paginate.product_detail'))->links() }}</div>
                            </div>
                    @else
                        <div id="detail" class="tab-pane fade text-center">
                            <h2>{{ trans('admin.product.currently_product_detail') }}</h2>
                        </div>
                    @endif
                </div>
            </div>

            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
@endsection
@section('js')
    <script src="{{ mix('js/productjs.js') }}"></script>
@endsection
