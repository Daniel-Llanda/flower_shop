<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>EveryDhay Flower Shop</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        *{
            scroll-behavior: smooth;
        }
    </style>


    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
</head>
<body class="font-inter bg-gradient-to-br from-emerald-50 via-white to-rose-50 text-gray-800">

    <!-- ================= HEADER ================= -->
    <header class="fixed top-0 inset-x-0 z-50 bg-white/70 backdrop-blur border-b"> 
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center"> 
            <a href="#hero"><img src="{{ asset('images/logo.png') }}" class="h-10 md:h-14"></a> 
            <nav class="flex items-center gap-2 text-xs font-medium md:gap-6 md:text-sm"> 
                <a href="#products" class="hover:text-emerald-600">Shop</a>
                <a href="#about" class="hover:text-emerald-600">About</a> 
                <a href="#contact" class="hover:text-emerald-600">Contact</a> 
                <a href="{{ route('login') }}" class="px-5 py-2 bg-emerald-600 text-white rounded-full hover:bg-emerald-700 transition"> Login </a> 
            </nav> 
        </div> 
    </header>

    <!-- ================= HERO ================= -->
    <section id="hero" class="relative pt-40 pb-32 overflow-hidden">
        <!-- Animated blobs -->
        <div class="absolute w-72 h-72 bg-emerald-100 rounded-full top-20 left-10 opacity-30 animate-pulse-slow mix-blend-multiply"></div>
        <div class="absolute w-72 h-72 bg-pink-100 rounded-full top-40 right-10 opacity-30 animate-pulse-slower mix-blend-multiply"></div>
        <div class="absolute w-72 h-72 bg-yellow-100 rounded-full bottom-20 left-1/2 opacity-30 animate-pulse-slow mix-blend-multiply"></div>

        <div class="relative max-w-7xl mx-auto px-6 grid lg:grid-cols-2 gap-16 items-center">
            <!-- Hero Text -->
            <div class="space-y-6">
                <span class="inline-flex items-center gap-2 bg-emerald-100 text-emerald-700 px-4 py-1 rounded-full text-sm font-medium">
                    Fresh • Handcrafted • Local
                </span>

                <h1 class="text-4xl lg:text-6xl font-extrabold leading-tight">
                    Fresh Flowers for <span class="bg-clip-text text-transparent bg-gradient-to-tr from-emerald-500 to-emerald-400">EveryDhay</span> Moments
                </h1>

                <p class="text-gray-600 max-w-xl text-lg">
                    Premium flowers arranged with heart — for love, celebration, and everyday joy. Every bouquet tells a story.
                </p>

                <div class="flex flex-wrap gap-4 mt-6">
                    <a href="#products" class="px-8 py-4 bg-emerald-600 text-white rounded-xl shadow-lg hover:bg-emerald-700 transition">
                        Shop Collection
                    </a>
                    <a href="#about" class="px-8 py-4 border border-emerald-600 rounded-xl hover:bg-emerald-50 transition">
                        Our Story
                    </a>
                </div>
            </div>

            <!-- Hero Image -->
            <div class="relative">
                <div class="absolute -inset-4 bg-gradient-to-tr from-emerald-400 to-emerald-200 rounded-3xl blur-3xl opacity-20 animate-pulse"></div>
                <img src="https://scontent.fmnl9-5.fna.fbcdn.net/v/t39.30808-6/568862733_122186624216919255_2404972823176600009_n.jpg?_nc_cat=109&ccb=1-7&_nc_sid=833d8c&_nc_eui2=AeHEv7qhL-3bbDiguduuHoxkwWLYyVXNzqfBYtjJVc3Op8LfgdZDSpFda4R4y27xxID4vaeHk74_lgF8mvQteg_J&_nc_ohc=Bqd7IV_f_dAQ7kNvwFlFAVc&_nc_oc=AdlBowaHbuYows75DAi5jckxS5Ve566n7UYkPuMZG9zrMBDI-DYL7wzs57SehVUUobk&_nc_zt=23&_nc_ht=scontent.fmnl9-5.fna&_nc_gid=Gf3jVUd6BQQftQYvUS5PNA&oh=00_Aft4vvT9yb3lEd6R9U0VT2BHPMNm262v6LgYkzQOspkloA&oe=69865744" 
                    alt="Beautiful flower arrangements" 
                    class="relative rounded-3xl shadow-2xl w-full h-96 object-cover">

            
            </div>
        </div>
    </section>

<!-- ================= PRODUCTS ================= -->
<section id="products" class="py-20">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-extrabold">
                Best Selling <span class="bg-clip-text text-transparent bg-gradient-to-tr from-emerald-500 to-emerald-400">Bouquets</span>
            </h2>
            <p class="text-gray-600 mt-2">Carefully selected favorites loved by our customers</p>
        </div>

        <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
            @forelse($flowers as $flower)
                <div class="bg-emerald-50 rounded-3xl overflow-hidden shadow-lg hover:shadow-2xl transition transform hover:-translate-y-2">
                    <div class="relative">
                       <img src="{{ asset('storage/' . $flower->image) }}" alt="{{ $flower->name }}" class="w-full h-64 object-cover transition-transform duration-500 hover:scale-110">

                        <span class="absolute top-3 right-3 bg-white/90 text-emerald-600 px-3 py-1 rounded-full text-sm font-semibold">
                            {{ $flower->name }}
                        </span>
                    </div>
                    <div class="p-4">
                        <h3 class="text-lg font-bold mb-2">{{ $flower->name }}</h3>
                        <p class="text-gray-500 mb-4 text-sm line-clamp-2">{{ $flower->description }}</p>
                        <div class="flex justify-between items-center">
                            <span class="text-emerald-600 font-extrabold text-lg">₱{{ number_format($flower->price, 2) }}</span>
                            <a href="" class="px-4 py-2 rounded-full bg-emerald-600 text-white hover:bg-emerald-700 transition">
                                View
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-20 text-gray-500 text-xl font-semibold">
                    No flowers available yet.
                </div>
            @endforelse
        </div>
    </div>
</section>


<!-- ================= ABOUT ================= -->
<section id="about" class="py-20 bg-gradient-to-tr from-emerald-50 via-white to-emerald-100">
    <div class="max-w-7xl mx-auto px-6 grid lg:grid-cols-2 gap-16 items-center">
        <div>
            <h2 class="text-4xl font-extrabold mb-6">Crafted With <span class="bg-clip-text text-transparent bg-gradient-to-tr from-emerald-500 to-emerald-400">Passion</span></h2>
            <p class="text-gray-600 mb-4">EveryDhay Flower Shop was founded with a simple mission — to turn emotions into beautiful floral experiences. From sourcing to arrangement, every detail matters.</p>
            <p class="text-gray-600">We believe that flowers have the power to brighten any day, celebrate special moments, and express feelings that words cannot capture.</p>
        </div>

        <div class="space-y-6">
            <div class="bg-white/80 backdrop-blur-xl p-6 rounded-3xl shadow-lg">
                <h3 class="font-bold text-xl mb-4">Fresh Locally Sourced</h3>
                <p class="text-gray-500">We partner with local growers for the freshest blooms.</p>
            </div>
            <div class="bg-white/80 backdrop-blur-xl p-6 rounded-3xl shadow-lg">
                <h3 class="font-bold text-xl mb-4">Artist-Crafted Arrangements</h3>
                <p class="text-gray-500">Each bouquet is a unique work of floral art.</p>
            </div>
            <div class="bg-white/80 backdrop-blur-xl p-6 rounded-3xl shadow-lg">
                <h3 class="font-bold text-xl mb-4">Customer-Loved Designs</h3>
                <p class="text-gray-500">Trusted by thousands for their special moments.</p>
            </div>
        </div>
    </div>
</section>

<!-- ================= CONTACT ================= -->
<section id="contact" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-6">
        <!-- Section Header -->
        <div class="mb-12 text-center">
            <h2 class="text-4xl font-extrabold mb-4">
                Visit or 
                <span class="bg-clip-text text-transparent bg-gradient-to-tr from-emerald-500 to-emerald-400">
                    Contact Us
                </span>
            </h2>
            <p class="text-gray-600 text-lg">
                We'd love to help you create the perfect floral moment
            </p>
        </div>

        <!-- Contact Grid -->
        <div class="grid lg:grid-cols-2 gap-12">
            <!-- Contact Info -->
            <div class="flex flex-col gap-8">
                <!-- Contact Card -->
                <div class="bg-gradient-to-tr from-emerald-100 to-emerald-50 rounded-3xl p-8 flex flex-col gap-6 shadow-lg">
                    <!-- Location -->
                    <div class="flex items-start gap-4">
                        <div class="bg-emerald-600 text-white p-3 rounded-xl flex-shrink-0">
                            <svg class="w-6 h-6" fill="white" viewBox="0 0 24 24">
                                <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-800 mb-1">Location</h4>
                            <p class="text-gray-500">Dinalupihan Plaza, Dinalupihan, Bataan</p>
                        </div>
                    </div>

                    <!-- Phone -->
                    <div class="flex items-start gap-4">
                        <div class="bg-emerald-600 text-white p-3 rounded-xl flex-shrink-0">
                            <svg class="w-6 h-6" fill="white" viewBox="0 0 24 24">
                                <path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-800 mb-1">Phone</h4>
                            <p class="text-gray-500">+63 929 560 9327</p>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="flex items-start gap-4">
                        <div class="bg-emerald-600 text-white p-3 rounded-xl flex-shrink-0">
                            <svg class="w-6 h-6" fill="white" viewBox="0 0 24 24">
                                <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-800 mb-1">Email</h4>
                            <p class="text-gray-500">everydhay@gmail.com</p>
                        </div>
                    </div>
                </div>

                <!-- Store Hours Card -->
                <div class="bg-emerald-600 text-white rounded-3xl p-6 flex flex-col gap-3 shadow-lg">
                    <h3 class="font-bold text-xl mb-2">Store Hours</h3>
                    <div class="flex justify-between">
                        <span>Monday - Sunday</span>
                        <span class="font-semibold">8:00 AM - 6:00 PM</span>
                    </div>
                    
                </div>
            </div>

            <!-- Map -->
            <div class="rounded-3xl overflow-hidden shadow-2xl h-[420px]">
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d573.2301210903894!2d120.46745046240451!3d14.86912659414784!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x339667000878533b%3A0x96e7ec6ec13fcd9d!2sEveryDhay%20Flower%20Shop!5e0!3m2!1sen!2sph!4v1767524342712!5m2!1sen!2sph" 
                    class="w-full h-full border-0" 
                    allowfullscreen="" 
                    loading="lazy" 
                    referrerpolicy="no-referrer-when-downgrade"
                    title="EveryDhay Flower Shop Location">
                </iframe>
            </div>
        </div>
    </div>
</section>


<!-- ================= FOOTER ================= -->
<footer class="bg-gradient-to-tr from-emerald-800 to-emerald-500 text-white py-12 px-6">
    <div class="max-w-7xl mx-auto">
        <!-- Footer Content -->
        <div class="flex flex-wrap justify-between items-center gap-6 mb-8">
            <!-- Logo & Description -->
            <div class="flex flex-col gap-3">
                <div class="flex items-center gap-3">
                    <span class="text-xl font-extrabold">EveryDhay</span>
                </div>
                <p class="text-white/80 text-sm">A community FLOWER BOUTIQUE in Dinalupihan — for nearly 40 years </p>
            </div>

            <!-- Footer Links -->
            <div class="flex flex-wrap gap-6">
                <a href="#products" class="text-white/80 text-sm hover:text-white transition-colors">Shop</a>
                <a href="#about" class="text-white/80 text-sm hover:text-white transition-colors">About</a>
                <a href="#contact" class="text-white/80 text-sm hover:text-white transition-colors">Contact</a>
                <a href="#" class="text-white/80 text-sm hover:text-white transition-colors">Privacy Policy</a>
                <a href="#" class="text-white/80 text-sm hover:text-white transition-colors">Terms of Service</a>
            </div>
        </div>

        <!-- Footer Bottom / Copyright -->
        <div class="pt-6 border-t border-white/20 text-center text-white/80 text-sm">
            © 2026 EveryDhay Flower Shop. All rights reserved.
        </div>
    </div>
</footer>

</body>
</html>
