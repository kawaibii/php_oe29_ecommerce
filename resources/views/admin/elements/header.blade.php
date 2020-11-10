<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="navbar-header">
        <a class="navbar-brand" href="#">{{ trans('admin.title') }}</a>
    </div>
    <ul class="nav navbar-nav navbar-left navbar-top-links">
        <li>
            <a href="{{ route('user.home') }}"><i class="fa fa-home fa-fw"></i> {{ trans('admin.header.website') }}</a>
        </li>
    </ul>

    <ul class="nav navbar-right navbar-top-links">
        <li class="dropdown">
            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" dusk="language">
                {{ trans('language') }}
            </button>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="{{ route('localization', ['en']) }}">{{ trans('language.english') }}</a>
                <a class="dropdown-item" href="{{ route('localization', ['vi']) }}">{{ trans('language.vietnamese') }}</a>
            </div>
        </li>
        @auth
        <li class="dropdown" id="information">
            <a class="dropdown-toggle " data-toggle="dropdown" href="#" dusk="logout">
                {{ Auth::user()->name }}
            </a>
            <ul class="dropdown-menu dropdown-user">
                <li>
                    <a href="{{ route('user.logout') }}"><i class="fa fa-sign-out fa-fw"></i>{{ trans('admin.header.logout') }}</a>
                </li>
            </ul>
        </li>
        @endauth
    </ul>
    @include('admin.elements.menu')
</nav>
