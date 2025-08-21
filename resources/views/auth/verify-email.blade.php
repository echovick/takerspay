<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Email Verification - TakersPay</title>
    <meta name="description" content="Verify your email address to complete your TakersPay account setup.">
    <link rel="icon" href="{{ asset('assets/imgs/takers-pay-logo.png') }}" type="image/x-icon">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('build/assets/app-CFeFbLk4.css') }}">
    <script src="{{ asset('build/assets/app-BIKGneNk.js') }}"></script>
    @livewireStyles
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-50">
    @livewire('auth.email-verification-form')
    
    @livewireScripts
</body>
</html>