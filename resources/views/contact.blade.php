@extends('layouts.app')

@section('title', 'Contact E-Mart Nepal - Get in Touch | Dipesh Dhaurali')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Header Hero Block -->
    <div class="relative bg-gradient-to-br from-indigo-50/60 via-white to-emerald-50/40 border border-gray-100 rounded-3xl p-8 lg:p-12 mb-12 overflow-hidden">
        <div class="absolute top-[-20%] left-[-10%] w-[300px] h-[300px] rounded-full bg-indigo-200/10 blur-3xl pointer-events-none"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[400px] h-[400px] rounded-full bg-emerald-200/15 blur-3xl pointer-events-none"></div>
        
        <div class="relative z-10 max-w-3xl">
            <span class="text-indigo-600 text-xs font-bold uppercase tracking-wider bg-indigo-50 px-3 py-1 rounded-full border border-indigo-100/50">Get in Touch</span>
            <h1 class="text-4xl lg:text-5xl font-black text-gray-900 mt-4 tracking-tight leading-none">
                Contact <span class="bg-gradient-to-r from-indigo-600 to-emerald-600 bg-clip-text text-transparent">e-mart Support</span>
            </h1>
            <p class="text-lg text-gray-600 mt-6 leading-relaxed">
                Have a query about your order, shipping speeds, or custom corporate requests? Reach out and we will get back to you in record time.
            </p>
        </div>
    </div>

    <!-- Alert Message -->
    @if(session('success'))
    <div class="mb-8 p-4 bg-green-50 border-l-4 border-green-400 rounded-r-xl flex items-center gap-3">
        <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center text-green-700">
            <i class="fa-solid fa-circle-check"></i>
        </div>
        <div class="text-sm font-medium text-green-700">
            {{ session('success') }}
        </div>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">
        <!-- Contact Details Info Panel -->
        <div class="lg:col-span-5 space-y-6">
            <div class="bg-white border border-gray-100 rounded-2xl p-6 space-y-6 shadow-sm">
                <h3 class="text-xl font-bold text-gray-900 border-b border-gray-50 pb-4">Direct Contact</h3>
                
                <!-- Phone -->
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 bg-indigo-50 border border-indigo-100/50 rounded-xl flex items-center justify-center text-indigo-600 flex-shrink-0">
                        <i class="fa-solid fa-phone"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 font-medium uppercase tracking-wide">Call Support</p>
                        <p class="text-sm font-semibold text-gray-800">9800000000</p>
                    </div>
                </div>

                <!-- Email -->
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 bg-indigo-50 border border-indigo-100/50 rounded-xl flex items-center justify-center text-indigo-600 flex-shrink-0">
                        <i class="fa-solid fa-envelope"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 font-medium uppercase tracking-wide">Email Us</p>
                        <p class="text-sm font-semibold text-gray-800">hello@e-mart.test</p>
                    </div>
                </div>

                <!-- WhatsApp -->
                <a href="https://wa.me/9779800000000" target="_blank" class="flex items-center gap-4 group">
                    <div class="w-10 h-10 bg-emerald-50 border border-emerald-100/50 rounded-xl flex items-center justify-center text-emerald-600 flex-shrink-0 group-hover:bg-emerald-600 group-hover:text-white transition-all">
                        <i class="fa-brands fa-whatsapp text-lg"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 font-medium uppercase tracking-wide group-hover:text-emerald-600 transition-colors">WhatsApp Chat</p>
                        <p class="text-sm font-semibold text-gray-800 flex items-center gap-1.5">
                            +977 9800000000 
                            <span class="text-xs font-normal text-emerald-500 flex items-center gap-1">
                                <span class="h-1.5 w-1.5 rounded-full bg-emerald-500 animate-pulse"></span> Active
                            </span>
                        </p>
                    </div>
                </a>
            </div>

            <!-- Social accounts links -->
            <div class="bg-white border border-gray-100 rounded-2xl p-6 shadow-sm">
                <h3 class="text-lg font-bold text-gray-900 border-b border-gray-50 pb-4 mb-4">Social Media Channels</h3>
                <div class="grid grid-cols-3 gap-4">
                    <!-- Facebook -->
                    <a href="https://www.facebook.com/dipesh.dhaurali.1/" target="_blank" class="flex flex-col items-center justify-center p-4 border border-gray-100 rounded-xl hover:bg-blue-50/30 hover:border-blue-200 transition-all text-gray-500 hover:text-[#1877F2]">
                        <i class="fa-brands fa-facebook text-2xl mb-1"></i>
                        <span class="text-xs font-medium">Facebook</span>
                    </a>
                    
                    <!-- Instagram -->
                    <a href="https://www.instagram.com/dipesh1dip1/?hl=en" target="_blank" class="flex flex-col items-center justify-center p-4 border border-gray-100 rounded-xl hover:bg-pink-50/30 hover:border-pink-200 transition-all text-gray-500 hover:text-[#ee2a7b]">
                        <i class="fa-brands fa-instagram text-2xl mb-1"></i>
                        <span class="text-xs font-medium">Instagram</span>
                    </a>

                    <!-- GitHub -->
                    <a href="https://github.com/Dipesh-Dhaurali" target="_blank" class="flex flex-col items-center justify-center p-4 border border-gray-100 rounded-xl hover:bg-gray-50 hover:border-gray-300 transition-all text-gray-500 hover:text-gray-900">
                        <i class="fa-brands fa-github text-2xl mb-1"></i>
                        <span class="text-xs font-medium">GitHub</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Contact Us Form Column -->
        <div class="lg:col-span-7">
            <div class="bg-white border border-gray-100 rounded-2xl p-8 shadow-sm">
                <h3 class="text-xl font-bold text-gray-900 mb-6">Send us a Message</h3>
                
                <form action="{{ route('contact.submit') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Full Name</label>
                            <input type="text" id="name" name="name" required class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all text-sm" placeholder="Your name">
                        </div>
                        
                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email Address</label>
                            <input type="email" id="email" name="email" required class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all text-sm" placeholder="you@example.com">
                        </div>
                    </div>
                    
                    <!-- Subject -->
                    <div>
                        <label for="subject" class="block text-sm font-semibold text-gray-700 mb-2">Subject</label>
                        <input type="text" id="subject" name="subject" required class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all text-sm" placeholder="Topic of discussion">
                    </div>
                    
                    <!-- Message -->
                    <div>
                        <label for="message" class="block text-sm font-semibold text-gray-700 mb-2">Message</label>
                        <textarea id="message" name="message" rows="5" required class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all text-sm" placeholder="Tell us how we can help..."></textarea>
                    </div>
                    
                    <!-- Submit button -->
                    <div>
                        <button type="submit" class="w-full px-6 py-4 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-semibold rounded-xl shadow-lg shadow-indigo-155 hover:shadow-indigo-250 transition-all transform hover:-translate-y-0.5 text-center">
                            Send Message <i class="fa-solid fa-paper-plane ml-2 text-xs"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
