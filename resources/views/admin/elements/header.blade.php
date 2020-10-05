<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="navbar-header">
        <a class="navbar-brand" href="#">{{ trans('admin.title') }}</a>
    </div>
    <ul class="nav navbar-nav navbar-left navbar-top-links">
        <li>
            <a href="{{ route('home') }}"><i class="fa fa-home fa-fw"></i> {{ trans('admin.header.website') }}</a>
        </li>
    </ul>

    <ul class="nav navbar-right navbar-top-links">
        <li class="dropdown">
            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                {{ trans('language') }}
            </button>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="{{ route('localization', ['en']) }}">{{ trans('language.english') }}</a>
                <a class="dropdown-item" href="{{ route('localization', ['vi']) }}">{{ trans('language.vietnamese') }}</a>
            </div>
        </li>
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                <i class="fa fa-user fa-fw"></i><b class="caret"></b>
            </a>
            <ul class="dropdown-menu dropdown-user">
                <li>
                    <a href="#"><i class="fa fa-key" aria-hidden="true"></i> {{ trans('admin.header.change_pasword') }}</a>
                </li>
                <li class="divider"></li>
                <li>
                    <a href="#"><i class="fa fa-sign-out fa-fw"></i> {{ trans('admin.header.logout') }}</a>
                </li>
            </ul>
        </li>
    </ul>
    @include('admin.elements.menu')
</nav>
