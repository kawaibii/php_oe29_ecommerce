<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="author" content="">
    <title>{{ trans('admin.title') }}</title>
    <link href="{{ asset('bower_components/bower_project1/admin/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('bower_components/bower_project1/admin/css/metisMenu.min.css') }}" rel="stylesheet">
    <link href="{{ asset('bower_components/bower_project1/admin/css/timeline.css') }}" rel="stylesheet">
    <link href="{{ asset('bower_components/bower_project1/admin/css/startmin.css') }}" rel="stylesheet">
    <link href="{{ asset('bower_components/bower_project1/admin/css/morris.css') }}" rel="stylesheet">
    <link href="{{ asset('bower_components/bower_project1/admin/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/all.css') }}" rel="stylesheet">
    <link href="{{ asset('bower_components/bower_project1/admin/css/dataTables/dataTables.bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('bower_components/bower_project1/admin/css/dataTables/dataTables.responsive.css') }}" rel="stylesheet">
    @yield('css')
    <script src="{{ asset('bower_components/ckeditor/ckeditor.js') }}"></script>
    <link href="{{ asset('bower_components/jAlert/dist/jAlert.css') }}" rel="stylesheet">
</head>
<body>
<div id="wrapper">
    @include('admin.elements.header')
    @yield('content')
</div>
    <script src="{{ asset('bower_components/bower_project1/admin/js/jquery.min.js') }}"></script>
    <script src="{{ asset('bower_components/bower_project1/admin/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('bower_components/bower_project1/admin/js/metisMenu.min.js') }}"></script>
    <script src="{{ asset('bower_components/bower_project1/admin/js/raphael.min.js') }}"></script>
    <script src="{{ asset('bower_components/bower_project1/admin/js/startmin.js') }}"></script>
    <script src="{{ asset('bower_components/highcharts/highcharts.js') }}"></script>
    <script src="{{ asset('bower_components/highcharts/modules/exporting.js') }}"></script>
    <script src="{{ asset('bower_components/chart.js/dist/Chart.min.js') }}"></script>
<script src="{{ asset('bower_components/jAlert/dist/jAlert.min.js') }}"></script>
<script src="{{ asset('bower_components/jAlert/dist/jAlert-functions.min.js') }}"></script>
<script src="https://www.gstatic.com/firebasejs/8.1.1/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.1.1/firebase-analytics.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.1.1/firebase-auth.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.1.1/firebase-firestore.js"></script>
<script src="https://www.gstatic.com/firebasejs/3.1.0/firebase.js"></script>
@yield('js');
<script>
    window.translations = {!! $translation !!};
    var lang = JSON.parse(window.translations);
    var firebaseConfig = {
        apiKey: "AIzaSyD6Vyj7cmDjQfcWQYzIyaWSzdHfe5io3rw",
        authDomain: "fir-user-d81b3.firebaseapp.com",
        databaseURL: "https://fir-user-d81b3.firebaseio.com",
        projectId: "fir-user-d81b3",
        storageBucket: "fir-user-d81b3.appspot.com",
        messagingSenderId: "968376625039",
        appId: "1:968376625039:web:c06430ca7bb60a7ef14dfa",
        measurementId: "G-BKN5P1DKQR"
    };
    firebase.initializeApp(firebaseConfig);
    var database = firebase.database();
    let data = database.ref('/user');
    // lang nghe su kien them don hang .
    data.orderByChild("timestamp").limitToLast(1).on('child_added', (snapshot) =>{
        const data = snapshot.val();
        if (data.status == 1) {
            let countNotification = parseInt($("#count-notification").text()) + 1;
            $("#count-notification").text(countNotification);
            let notifcation = '<div class="message-notification">' +
                '<li>' +
                '<a href="' + data.route + '" id="url-notification">' +
                '<div>' +
                '<i class="fa fa-comment fa-fw"></i>' +
                lang[data.message] + " " + data.name_user +
                '<span class="pull-right text-muted small">now</span>' +
                '</div>' +
                '</a>' +
                '</li>' +
                '<li class="divider"></li>' +
                '</div>';
            $(".view-notification").prepend(notifcation);
        }
    });
    // lang nghe su kien thay doi.
    data.on('child_changed', (snapshot) =>{
        const data = snapshot.val();
        if (data.status == 1) {
            let countNotification = parseInt($("#count-notification").text()) + 1;
            $("#count-notification").text(countNotification);
            let notifcation = '<div class="message-notification">' +
                '<li>' +
                '<a href="' + data.route + ' " id="url-notification">' +
                '<div>' +
                '<i class="fa fa-comment fa-fw"></i>' +
                lang[data.message] + " " + data.name_user +
                '<span class="pull-right text-muted small">now</span>' +
                '</div>' +
                '</a>' +
                '</li>' +
                '<li class="divider"></li>' +
                '</div>';
            $(".view-notification").prepend(notifcation);
        }
    });
</script>
</body>
</html>
