<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Takers Pay</title>
    <meta name="description"
        content="Takers Pay - Your trusted platform for secure and seamless cryptocurrency trading. Buy, sell and trade crypto with our user-friendly digital trading platform.">
    <meta name="keywords"
        content="Takers Pay, cryptocurrency trading, crypto exchange, bitcoin, ethereum, digital assets, secure trading, crypto wallet">
    <meta name="author" content="Takers Pay">
    <meta name="robots" content="index, follow">
    <meta name="googlebot" content="index, follow">
    <meta name="google" content="notranslate">
    <meta name="google-site-verification" content="google-site-verification=google-site-verification">
    <link rel="icon" href="{{ asset('assets/imgs/takers-pay-logo.png') }}" type="image/x-icon">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('build/assets/app-BIKGneNk.js') }}">
    <link rel="stylesheet" href="{{ asset('build/assets/app-YcvK4Deo.css') }}">
    @livewireStyles
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        /* Global font styles */
        body {
            font-family: 'Inter', sans-serif;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: 'Poppins', sans-serif;
            /* Example: accent color for headings */
            font-weight: 700;
            /* Use bold headings for emphasis */
        }

        a {
            font-family: 'Inter', sans-serif;
            /* Example: link color */
            text-decoration: none;
        }

        a:hover {
            text-decoration: none !important;
        }

        .app-wrapper {
            padding: 5% !important;
            max-width: 1000px !important;
            margin: auto !important;
        }

        .animate-marquee {
            display: inline-block;
            animation: marquee 20s linear infinite;
        }

        @keyframes marquee {
            0% {
                transform: translateX(100%);
            }

            100% {
                transform: translateX(-100%);
            }
        }

        /* Add smooth scrolling */
        html {
            scroll-behavior: smooth;
        }

        /* Add transitions for interactive elements */
        a,
        button {
            transition: all 0.3s ease;
        }
    </style>
</head>

<body>
    @yield('content')
    @livewireScripts
    @stack('scripts')
    @push('script')
        <script>
            function triggerImageUpload() {
                document.getElementById('imageUploadInput').click();
            }

            // Optionally handle the file selection
            document.getElementById('imageUploadInput').addEventListener('change', function(event) {
                const file = event.target.files[0];
                if (file) {
                    console.log('Selected file:', file.name);
                    // You can now handle the uploaded image (e.g., preview or upload to server)
                }
            });

            async function fetchCryptoPrices() {
                const apiUrl =
                    'https://api.coingecko.com/api/v3/simple/price?ids=bitcoin,ethereum,binancecoin,solana&vs_currencies=usd';

                try {
                    const response = await fetch(apiUrl);
                    const data = await response.json();

                    // Format prices into a string separated by "|"
                    const prices = Object.entries(data)
                        .map(([name, value]) => `${name.toUpperCase()}: $${value.usd}`)
                        .join(' | ');

                    // Inject prices into the marquee
                    document.getElementById('crypto-prices').textContent = prices;
                } catch (error) {
                    console.error('Error fetching crypto prices:', error);
                    document.getElementById('crypto-prices').textContent = 'Failed to load prices.';
                }
            }

            // Fetch and display prices
            fetchCryptoPrices();

            // Optionally, refresh prices every minute
            setInterval(fetchCryptoPrices, 60000);
        </script>
        <script src="{{ asset('build/assets/app-BIKGneNk.js') }}"></script>
    </body>

    </html>
