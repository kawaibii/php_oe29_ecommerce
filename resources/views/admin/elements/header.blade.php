<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="navbar-header">
        <a class="navbar-brand" href="#">{{ trans('admin.title') }}</a>
    </div>
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="sr-only"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
    </button>

    <ul class="nav navbar-nav navbar-left navbar-top-links">
        <li>
            <a href="{{ route('user.home') }}"><i class="fa fa-home fa-fw"></i> {{ trans('admin.header.website') }}</a>
        </li>
    </ul>
    <ul class="nav navbar-right navbar-top-links">
        @auth
            <li class="dropdown navbar-inverse">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="fa fa-bell fa-fw" id="notification">
                        <span id="count-notification">{{ count($notifications->where('read_at', null)) }}</span>
                    </i>
                    <b class="caret"></b>
                </a>
                <ul class="dropdown-menu dropdown-alerts view-notification">
                    @foreach ($notifications as $notification)
                        <div class="message-notification
                        @if ($notification->read_at != null)
                            seen
                        @endif">
                            <li>
                                <a href="{{ route('orders.detail', json_decode($notification->data)->id) }}" id="url-notification">
                                    <div>
                                        <i class="fa fa-comment fa-fw"></i>
                                        {{ trans(json_decode($notification->data)->message) . $notification->notifiable->name }}
                                        <span class="pull-right text-muted small">{{ time_elapsed_string(strtotime($notification->created_at)) }}</span>
                                    </div>
                                </a>
                            </li>
                            <li class="divider"></li>
                        </div>
                    @endforeach
                </ul>
            </li>
        @endauth
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
