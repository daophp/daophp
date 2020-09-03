<!doctype html>
<html lang="zh-Hans">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="/favicon.ico"/>
    <title>{{ $title ?? 'untitled' }}</title>
    <link rel="stylesheet" href="/static/layui/css/layui.css">
    <link rel="stylesheet" href="/themes/default/css/app.css">
</head>
<body>
<header>
    header
</header>
<div class="container">
    @yield('content')
</div>
<footer>
    footer <a href="/console">管理后台</a>
</footer>
<script src="/static/layui/layui.all.js"></script>
<script src="/themes/default/js/app.js"></script>
</body>
</html>
