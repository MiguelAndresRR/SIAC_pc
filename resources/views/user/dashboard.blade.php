<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard</title>
    <script src="https://kit.fontawesome.com/171f3dc321.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="{{ asset('css/dashboard/dashboard.css') }}">
    <script src="https://kit.fontawesome.com/171f3dc321.js" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Noto+Sans+JP:wght@100..900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
</head>

<body class="flex">
    @include('user.layout.sidebar')
    <div class="containerdashboard">
        <div class="header">
            <h1><i class="fa-solid fa-chart-line"></i>Dashboard</h1>
        </div>
        <div class="dashboard-data">
            <div class="informacion">
                @include('user.dashboard.graficos2')
            </div>
            <div class="informacion">
                @include('user.dashboard.graficos')
            </div>
            <div class="informacion">
                @include('user.dashboard.resumen2')
            </div>
            <div class="informacion">
                @include('user.dashboard.resumenes')
            </div>
        </div>
    </div>
</body>
</html>
