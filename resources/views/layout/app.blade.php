<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Takers Pay</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <style>
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
                const apiUrl = 'https://api.coingecko.com/api/v3/simple/price?ids=bitcoin,ethereum,binancecoin,solana&vs_currencies=usd';

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
    </body>

    </html>
