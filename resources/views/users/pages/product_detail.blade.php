@extends('users.master')

@section('content')
    <div class="wrap-user-product-detail-page">
        <section class="ftco-section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 mb-5 ftco-animate">
                        <img src="{{ asset(config('setting.image.product') . $images->first()->image_link) }}" class="img-fluid" alt="" id="image-show">
                        <div class="row">
                            @foreach ($images as $image)
                                <div class="col-xl-3">
                                    <img src="{{ asset(config('setting.image.product') . $image->image_link) }}" alt="" class="list-image">
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-lg-6 product-details pl-md-5 ftco-animate">
                        <h3 class="product-name">{{ $product->name }}</h3>
                        <div class="rating d-flex">
                            <p class="text-left mr-4">
                                <a href="#" class="mr-2">{{ $product->rate }}</a>
                                @for ($index = 0; $index < $product->rate; $index++)
                                    <a href="#"><span class="ion-ios-star"></span></a>
                                @endfor
                            </p>
                        </div>
                        <p class="price">
                            <span class="original-price">{{ number_format($product->original_price) . " VND" }}</span>
                            <span class="current-price">{{ number_format($product->current_price) . " VND" }}</span>
                        </p>
                        <p>{{ $product->description }}</p>
                        <form action="{{ route('user.addToCart') }}" method="POST">
                            @csrf
                            <div class="row mt-4">
                                <div class="wrap-size">
                                    @foreach ($productDetails as $detail)
                                        <input type="button" class="btn btn-primary btn-size" value="{{ $detail->size }}" data-url ="{{ route('user.quantity', $detail->id) }}" id="size-{{ $detail->size }}">
                                    @endforeach
                                </div>
                                <div class="w-100"></div>
                                <div class="input-group col-md-6 d-flex mb-3">
                                    <span class="input-group-btn mr-2">
                                        <button type="button" class="quantity-left-minus btn" data-type="minus" data-field="" id="btn-sub" disabled>
                                            <i class="ion-ios-remove"></i>
                                        </button>
                                    </span>
                                    <input type="text" id="quantity" name="quantity" class="quantity form-control input-number" value="1" min="0" disabled>
                                    <span class="input-group-btn ml-2">
                                        <button type="button" class="quantity-right-plus btn" data-type="plus" data-field="" id="btn-add" disabled>
                                            <i class="ion-ios-add"></i>
                                        </button>
                                    </span>
                                </div>
                                <div class="w-100"></div>
                                <div class="col-md-12">
                                    <p class="quantity">
                                        <span>{{ trans('user.product_detail.quantity') }}: </span>
                                        <span id="quantity-size"></span>
                                    </p>
                                </div>
                            </div>
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="size" id="add-size" value="">
                            <input type="submit" class="btn btn-black py-3 px-5 mr-2" value="{{ trans('user.product_detail.add_to_cart') }}">
                            <a href="#" class="btn btn-primary py-3 px-5">{{ trans('user.product_detail.buy_now') }}</a>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('js')
    <script src="{{ mix('js/product_detail.js') }}"></script>
@endsection
