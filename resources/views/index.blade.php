<!DOCTYPE html>
<html lang="en">
<head>
    <title>Savings Management</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <link rel="shortcut icon" href="{{ asset('img/save-money.png') }}">
    <link rel="stylesheet" href="{{ asset('css/graindashboard.css') }}">
</head>

<body class="has-sidebar has-fixed-sidebar-and-header">
@include('layouts.header')

<main class="main">
    @include('layouts.sidebar')

    <div class="content">
        @yield('content')
    </div>
</main>

@include('layouts.footer')

<script src="{{ asset('js/graindashboard.js') }}"></script>
<script src="{{ asset('js/graindashboard.vendor.js') }}"></script>
</body>

</html>
