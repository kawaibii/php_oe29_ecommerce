<nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
    <div class="container">
        <a class="navbar-brand" href="#">{{ config('information_shop.name_shop') }}</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="oi oi-menu"></span> {{ trans('menu') }}
        </button>

        <div class="collapse navbar-collapse" id="ftco-nav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active"><a href="{{ route('home') }}" class="nav-link">{{ trans('home') }}</a></li>
                <li class="nav-item"><a href="{{ route('show.all.product') }}" class="nav-link" >{{ trans('category') }}</a></li>
                <li class="nav-item"><a href="{{ route('about') }}" class="nav-link">{{ trans('about') }}</a></li>
                <li class="nav-item"><a href="{{ route('contact') }}" class="nav-link">{{ trans('contact') }}</a></li>
                <li class="nav-item cta cta-colored"><a href="{{ route('cart') }}" class="nav-link"><span class="icon-shopping_cart"></span>[0]</a></li>
            </ul>
        </div>
    </div>
</nav>
