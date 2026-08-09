<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', $mcaCapTitle ?? mca_cap('app.title'))</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ \Mca\Captcha\Support\McaCaptchaView::uiCssUrl() }}">
    <link rel="stylesheet" href="{{ \Mca\Captcha\Support\McaCaptchaView::cssUrl() }}">
    @stack('mca-cap-head')
</head>
<body class="mca-ui-root mca-perm-root mca-cap-root">
    @include('mca-captcha::partials.header')

    <main class="mca-ui-main mca-perm-main mca-cap-main">
        @include('mca-captcha::partials.flash')
        @yield('content')
    </main>

    @php
        $mcaUiI18n = [
            'ok' => mca_cap('modal.ok'),
            'confirm' => mca_cap('modal.confirm'),
            'cancel' => mca_cap('modal.cancel'),
            'close' => mca_cap('modal.close'),
            'alert_title' => mca_cap('modal.alert_title'),
            'confirm_title' => mca_cap('modal.confirm_title'),
        ];
    @endphp
    <script>
        window.McaUiI18n = @json($mcaUiI18n);
    </script>
    <script src="{{ \Mca\Captcha\Support\McaCaptchaView::uiJsUrl() }}" defer></script>
    <script src="{{ \Mca\Captcha\Support\McaCaptchaView::jsUrl() }}" defer></script>
    @stack('mca-cap-scripts')
</body>
</html>
