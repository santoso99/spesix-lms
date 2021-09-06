<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard | {{ config('app.name') }}</title>
</head>
<body>
    <script>
        window.location.href = "{{ App\Providers\RouteServiceProvider::HOME }}";
    </script>
</body>
</html>