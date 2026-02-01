<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>EveryDhay Flower Shop</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
            scroll-behavior: smooth;
        }
    </style>

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#FDFDFC] text-[#1b1b18] min-h-screen flex flex-col">

<!-- ================= HEADER ================= -->
<header class="fixed top-0 inset-x-0 z-50 bg-white/70 backdrop-blur border-b">
    <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
        <a href="#hero"><img src="{{ asset('images/logo.png') }}" class="h-10 md:h-14"></a>


        <nav class="flex items-center gap-2 text-xs font-medium md:gap-6 md:text-sm">
            <a href="#products" class="hover:text-emerald-600">Shop</a>
            <a href="#about" class="hover:text-emerald-600">About</a>
            <a href="#contact" class="hover:text-emerald-600">Contact</a>

            <a href="{{ route('login') }}"
               class="px-5 py-2 bg-emerald-600 text-white rounded-full hover:bg-emerald-700 transition">
                Login
            </a>
        </nav>
    </div>
</header>

<!-- ================= HERO ================= -->
<section class="relative pt-40 pb-32 overflow-hidden" id="hero">
    <div class="absolute inset-0 bg-gradient-to-br from-emerald-50 via-white to-emerald-100"></div>

    <div class="relative max-w-7xl mx-auto px-6 grid lg:grid-cols-2 gap-16 items-center">

        <!-- TEXT -->
        <div>
            <h1 class="text-3xl lg:text-5xl font-serif font-bold leading-tight mb-6">
                Fresh Flowers for <br class="hidden lg:block">EveryDhay Moments
            </h1>

            <p class="text-gray-600 max-w-xl mb-3">
                Premium flowers arranged with heart — for love, celebration, and everyday joy.
                Every bouquet tells a story.
            </p>
            <span class="inline-block mb-10 px-4 py-1 rounded-full bg-emerald-100 text-emerald-700 text-sm">
                Fresh • Handcrafted • Local
            </span>


            <div class="flex gap-4">
                <a href="#products"
                    class="px-8 py-4 bg-emerald-600 text-white rounded-xl hover:bg-emerald-700 transition shadow-lg">
                    Shop Collection
                </a>

                <a href="#about"
                    class="px-8 py-4 border border-emerald-600 rounded-xl hover:bg-emerald-50 transition">
                    Our Story
                </a>
            </div>
        </div>

        <!-- IMAGE -->
        <div class="relative">
            <div class="absolute -top-10 -left-10 w-full h-full bg-emerald-200 rounded-3xl rotate-3"></div>
            <img
                src="https://cdn.pixabay.com/photo/2021/11/02/19/13/flower-shop-6763936_1280.jpg"
                class="relative rounded-3xl shadow-2xl object-cover">
        </div>

    </div>
</section>

<!-- ================= PRODUCTS ================= -->
<section id="products" class="py-32 bg-white">
    <div class="max-w-7xl mx-auto px-6">

        <div class="text-center mb-20">
            <h2 class="text-4xl font-serif font-bold mb-4">Best Selling Bouquets</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">
                Carefully selected favorites loved by our customers.
            </p>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-10">

            @forelse($flowers as $flower)
                <div class="group bg-emerald-50 rounded-3xl p-4 shadow-sm hover:shadow-xl transition transform hover:-translate-y-2">

                    <div class="overflow-hidden rounded-2xl mb-4">
                        <img
                            src="{{ $flower->image ? asset('storage/'.$flower->image) : 'https://via.placeholder.com/400x300' }}"
                            class="h-64 w-full object-cover group-hover:scale-105 transition">
                    </div>

                    <h3 class="text-lg font-semibold mb-1">{{ $flower->name }}</h3>

                    <p class="text-sm text-gray-600 mb-4 line-clamp-2">
                        {{ $flower->description }}
                    </p>

                    <div class="flex justify-between items-center">
                        <span class="text-lg font-bold text-emerald-600">
                            ₱{{ number_format($flower->price, 2) }}
                        </span>

                        <button
                            class="px-5 py-2 bg-emerald-600 text-white rounded-full hover:bg-emerald-700">
                            View
                        </button>
                    </div>
                </div>
            @empty
                <p class="col-span-3 text-center text-gray-500">No flowers yet 🌷</p>
            @endforelse

        </div>
    </div>
</section>

<!-- ================= ABOUT ================= -->
<section id="about" class="py-32 bg-gradient-to-br from-emerald-50 to-white">
    <div class="max-w-5xl mx-auto px-6 grid md:grid-cols-2 gap-16 items-center">

        <div>
            <h2 class="text-4xl font-serif font-bold mb-6">
                Crafted With Passion
            </h2>

            <p class="text-gray-600 leading-relaxed">
                EveryDhay Flower Shop was founded with a simple mission —
                to turn emotions into beautiful floral experiences.
                From sourcing to arrangement, every detail matters.
            </p>
        </div>

        <div class="bg-white rounded-3xl p-10 shadow-lg">
            <ul class="space-y-4 text-gray-700">
                <li>Fresh locally sourced flowers</li>
                <li>Artist-crafted arrangements</li>
                <li>Customer-loved designs</li>
            </ul>
        </div>
    </div>
</section>

<!-- ================= CONTACT ================= -->
<section id="contact" class="py-32">
    <div class="max-w-6xl mx-auto px-6 grid md:grid-cols-2 gap-16">

        <div>
            <h2 class="text-4xl font-serif font-bold mb-6">Visit or Contact Us</h2>
            <p class="text-gray-600 mb-6">
                We’d love to help you create the perfect floral moment.
            </p>

            <div class="space-y-3 text-gray-700">
                <p>Philippines</p>
                <p>+63 900 000 0000</p>
                <p>everydhay@gmail.com</p>
            </div>
        </div>

        <div class="rounded-3xl overflow-hidden shadow-xl">
            <iframe class="w-full h-full border-0" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d573.2301210903894!2d120.46745046240451!3d14.86912659414784!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x339667000878533b%3A0x96e7ec6ec13fcd9d!2sEveryDhay%20Flower%20Shop!5e0!3m2!1sen!2sph!4v1767524342712!5m2!1sen!2sph" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>

    </div>
</section>

<!-- ================= FOOTER ================= -->
<footer class="bg-emerald-700 text-white py-10">
    <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row justify-between items-center gap-4 text-sm">
        <p>© {{ date('Y') }} EveryDhay Flower Shop</p>
        <div class="flex gap-6">
            <a href="#" class="hover:underline">Privacy</a>
            <a href="#" class="hover:underline">Terms</a>
        </div>
    </div>
</footer>

</body>
</html>
