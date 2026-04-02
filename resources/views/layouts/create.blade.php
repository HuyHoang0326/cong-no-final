<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('css/create.css') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
     @if ($errors->any())
    <div id="error-toast" class="error-toast">
        {{ $errors->first() }}
    </div>
@endif
<style>
.error-toast {
    position: fixed;
    top: 20px;
    right: 20px;
    background: #dc3545;
    color: #fff;
    padding: 12px 18px;
    border-radius: 6px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.2);
    z-index: 9999;
    animation: fadeIn 0.3s ease;
}

@keyframes fadeIn {
    from {opacity: 0; transform: translateY(-10px);}
    to {opacity: 1; transform: translateY(0);}
}
</style>
    @yield('content')
</body>
</html>
