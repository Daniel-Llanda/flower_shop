<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>EveryDhay Flower Shop</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600&display=swap" rel="stylesheet">

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] min-h-screen flex flex-col">

    <!-- ================= HEADER ================= -->
    <header class="w-full border-b border-gray-200 dark:border-gray-800">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
            <img src="{{ asset('images/logo.png') }}" alt="EveryDhay Logo" class="h-10">

            @if (Route::has('login'))
                <nav class="flex items-center gap-4 text-sm">
                    @auth
                        <a href="{{ url('/dashboard') }}"
                        class="px-4 py-2 border rounded-md hover:bg-gray-100 dark:hover:bg-gray-800">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="hover:underline">
                            Login
                        </a>
<!-- 
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                            class="px-4 py-2 bg-rose-500 text-white rounded-md hover:bg-rose-600 transition">
                                Register
                            </a>
                        @endif -->
                    @endauth
                </nav>
            @endif
        </div>
    </header>

        <!-- ================= HERO ================= -->
    <main class="flex-grow">
        <section class="max-w-7xl mx-auto px-6 py-20 grid lg:grid-cols-2 gap-12 items-center">
            
            <!-- TEXT -->
            <div>
                <h1 class="text-4xl lg:text-5xl font-serif font-bold mb-6">
                    Fresh Flowers for <br class="hidden lg:block">EveryDhay Moments
                </h1>

                <p class="text-gray-600 dark:text-gray-300 mb-8 leading-relaxed max-w-lg">
                    EveryDhay Flower Shop delivers premium, handpicked blooms crafted with love.
                    Perfect for celebrations, milestones, and everyday happiness.
                </p>

                <div class="flex gap-4">
                    <a href="{{ route('login') }}"
                    class="px-6 py-3 bg-rose-500 text-white rounded-md hover:bg-rose-600 transition">
                        Shop Now
                    </a>

                    <a href="#about"
                    class="px-6 py-3 border rounded-md hover:border-rose-500 transition">
                        Learn More
                    </a>
                </div>
            </div>

            <!-- IMAGE -->
            <div class="relative rounded-xl overflow-hidden shadow-lg">
                <img src="https://cdn.pixabay.com/photo/2021/11/02/19/13/flower-shop-6763936_1280.jpg"
                    alt="Flower Bouquet"
                    class="w-full h-full object-cover">
            </div>
        </section>
            <!-- ================= SAMPLE PRODUCTS ================= -->
        <section id="products" class="py-20 bg-white dark:bg-[#161615]">
            <div class="max-w-7xl mx-auto px-6">

                <!-- Section Title -->
                <div class="text-center mb-14">
                    <h2 class="text-3xl font-serif font-bold mb-4">
                        Our Best Sellers
                    </h2>
                    <p class="text-gray-600 dark:text-gray-300 max-w-2xl mx-auto">
                        Beautifully handcrafted bouquets made from fresh, premium flowers —
                        perfect for every occasion.
                    </p>
                </div>

                <!-- Product Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">

                    <!-- Product Card -->
                    <div class="group bg-rose-50 dark:bg-[#1f1f1f] rounded-xl overflow-hidden shadow hover:shadow-lg transition">
                        <img src="https://cdn.pixabay.com/photo/2016/11/29/06/20/red-1867767_1280.jpg"
                            alt="Rose Elegance"
                            class="h-56 w-full object-cover group-hover:scale-105 transition">

                        <div class="p-5">
                            <h3 class="font-semibold text-lg mb-1">
                                Rose Elegance
                            </h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">
                                Classic red roses with elegant wrapping
                            </p>

                            <div class="flex items-center justify-between">
                                <span class="font-semibold text-rose-600">
                                    ₱1,200
                                </span>
                                <button
                                    class="text-sm px-4 py-2 bg-rose-500 text-white rounded-md hover:bg-rose-600 transition">
                                    View
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Product Card -->
                    <div class="group bg-rose-50 dark:bg-[#1f1f1f] rounded-xl overflow-hidden shadow hover:shadow-lg transition">
                        <img src="https://cdn.pixabay.com/photo/2023/07/15/12/58/sunflower-8128779_1280.jpg"
                            alt="Sunshine Bloom"
                            class="h-56 w-full object-cover group-hover:scale-105 transition">

                        <div class="p-5">
                            <h3 class="font-semibold text-lg mb-1">
                                Sunshine Bloom
                            </h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">
                                Bright sunflowers for joyful moments
                            </p>

                            <div class="flex items-center justify-between">
                                <span class="font-semibold text-rose-600">
                                    ₱950
                                </span>
                                <button
                                    class="text-sm px-4 py-2 bg-rose-500 text-white rounded-md hover:bg-rose-600 transition">
                                    View
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Product Card -->
                    <div class="group bg-rose-50 dark:bg-[#1f1f1f] rounded-xl overflow-hidden shadow hover:shadow-lg transition">
                        <img src="https://cdn.pixabay.com/photo/2014/04/10/18/50/daisy-321217_1280.jpg"
                            alt="Pure Love"
                            class="h-56 w-full object-cover group-hover:scale-105 transition">

                        <div class="p-5">
                            <h3 class="font-semibold text-lg mb-1">
                                Pure Love
                            </h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">
                                Soft pastel flowers for romantic occasions
                            </p>

                            <div class="flex items-center justify-between">
                                <span class="font-semibold text-rose-600">
                                    ₱1,500
                                </span>
                                <button
                                    class="text-sm px-4 py-2 bg-rose-500 text-white rounded-md hover:bg-rose-600 transition">
                                    View
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Product Card -->
                    <div class="group bg-rose-50 dark:bg-[#1f1f1f] rounded-xl overflow-hidden shadow hover:shadow-lg transition">
                        <img src="https://cdn.pixabay.com/photo/2024/02/27/14/00/chrysanthemum-8600210_1280.jpg"
                            alt="Elegant White"
                            class="h-56 w-full object-cover group-hover:scale-105 transition">

                        <div class="p-5">
                            <h3 class="font-semibold text-lg mb-1">
                                Elegant White
                            </h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">
                                White roses and lilies for timeless beauty
                            </p>

                            <div class="flex items-center justify-between">
                                <span class="font-semibold text-rose-600">
                                    ₱1,350
                                </span>
                                <button
                                    class="text-sm px-4 py-2 bg-rose-500 text-white rounded-md hover:bg-rose-600 transition">
                                    View
                                </button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>


        <!-- ================= ABOUT ================= -->
        <section id="about" class="bg-rose-50 dark:bg-[#161615] py-20">
            <div class="max-w-4xl mx-auto px-6 text-center">
                <h2 class="text-3xl font-serif font-bold mb-6">
                    About EveryDhay
                </h2>

                <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                    Founded with passion and creativity, EveryDhay Flower Shop is dedicated
                    to bringing beauty and emotion through flowers. Each bouquet is thoughtfully
                    designed to create lasting memories.
                </p>
            </div>
        </section>

        <!-- ================= CONTACT ================= -->
        <section class="py-20">
            <div class="max-w-6xl mx-auto px-6 grid md:grid-cols-2 gap-12">

                <!-- LEFT: CONTACT INFO + MAP -->
                <div>
                    <h2 class="text-3xl font-serif font-bold mb-6">Contact Us</h2>

                    <!-- Contact Info -->
                    <div class="space-y-4 text-sm text-gray-700 dark:text-gray-300 mb-6">

                        <!-- Address -->
                        <div class="flex items-center gap-3">
                        
                            <span>Philippines</span>
                        </div>

                        <!-- Phone -->
                        <div class="flex items-center gap-3">
                        
                            <span>+63 900 000 0000</span>
                        </div>

                        <!-- Email -->
                        <div class="flex items-center gap-3">
                        
                            <span>everydhay@gmail.com</span>
                        </div>
                    </div>

                
                </div>

                <!-- RIGHT: CONTACT FORM -->
                <!-- Google Map Embed -->
                    <div class="w-full h-64 rounded-lg overflow-hidden shadow">
                        <iframe class="w-full h-full border-0" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d573.2301210903894!2d120.46745046240451!3d14.86912659414784!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x339667000878533b%3A0x96e7ec6ec13fcd9d!2sEveryDhay%20Flower%20Shop!5e0!3m2!1sen!2sph!4v1767524342712!5m2!1sen!2sph" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>

            </div>
        </section>

    </main>

    <!-- ================= FOOTER ================= -->
    <footer class="bg-rose-600 text-white py-6">
        <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row justify-between items-center text-sm">
            <p>© {{ date('Y') }} EveryDhay Flower Shop. All rights reserved.</p>

            <div class="flex gap-4 mt-4 md:mt-0">
                <a href="#" class="hover:underline">Privacy Policy</a>
                <a href="#" class="hover:underline">Terms</a>
            </div>
        </div>
    </footer>

</body>
</html>
