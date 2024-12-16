<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Takers Pay</title>
    {{-- <link rel="stylesheet" href="{{ asset('build/assets/app-BG5qsGv8.css') }}"> --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
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
            animation: marquee 10s linear infinite;
        }

        @keyframes marquee {
            0% {
                transform: translateX(100%);
            }

            100% {
                transform: translateX(-100%);
            }
        }
    </style>
</head>

<body>
    @yield('content')
    @livewireScripts
    @push('script')
        <script>
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
        {{-- <script src="{{ asset('build/assets/app-BxSjXaiU.js') }}"></script> --}}
    </body>

    </html>
