<!DOCTYPE html>
<html>
<body>
    <div class="email">
        <h1>Hello {{ $data['username'] }}</h1>
        <p>{{ trans('email.message_order') .": ". $data['quantity'] }}</p>
        <p>Time : {{ $data['time'] }}</p>
        <a href="{{ $data['route'] }}">{{ trans('email.click_view') }}</a>
        <p>Regards</p>
        <p>{{ config('mail.from.name') }}</p>
    </div>
</body>
<style>
    h1 {
        color: red;
    }
    body {
        background: #8CD0D3;
    }
    .email {
        background: white;
        margin: 30px;
        padding: 30px;
        font-size: 20px;
    }
</style>
</html>
