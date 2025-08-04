<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 font-sans antialiased">
<div class="min-h-screen flex items-center justify-center">
    <div class="w-full max-w-md px-6 py-8 bg-white shadow-md rounded-lg">
        <div class="flex justify-center ">
            <x-application-logo class="w-10 h-10 fill-current text-gray-500" />
        </div>
        {{ $slot }}
    </div>
</div>
</body>
</html>
