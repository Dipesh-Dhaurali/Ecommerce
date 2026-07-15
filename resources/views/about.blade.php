@extends('layouts.app')

@section('title', 'About E-Mart Nepal - Our Story | Dipesh Dhaurali')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Header Hero Block -->
    <div class="relative bg-gradient-to-br from-indigo-50/60 via-white to-purple-50/40 border border-gray-100 rounded-3xl p-8 lg:p-12 mb-12 overflow-hidden">
        <div class="absolute top-[-20%] left-[-10%] w-[300px] h-[300px] rounded-full bg-indigo-200/10 blur-3xl pointer-events-none"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[400px] h-[400px] rounded-full bg-purple-200/15 blur-3xl pointer-events-none"></div>
        
        <div class="relative z-10 max-w-3xl">
            <span class="text-indigo-600 text-xs font-bold uppercase tracking-wider bg-indigo-50 px-3 py-1 rounded-full border border-indigo-100/50">Our Story</span>
            <h1 class="text-4xl lg:text-5xl font-black text-gray-900 mt-4 tracking-tight leading-none">
                About <span class="bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">e-mart</span>
            </h1>
            <p class="text-lg text-gray-600 mt-6 leading-relaxed">
                e-mart is a premier digital marketplace built to bridge the gap between premium brand technology and everyday convenience. From elite smartphones to your favorite local snacks, we deliver quality straight to your door.
            </p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-16">
        <!-- Feature 1: Quality -->
        <div class="bg-white border border-gray-100 rounded-2xl p-6 shadow-sm hover:shadow-md transition-shadow">
            <div class="w-12 h-12 bg-indigo-50 border border-indigo-100/60 rounded-xl flex items-center justify-center text-indigo-600 mb-4">
                <i class="fa-solid fa-shield-halved text-xl"></i>
            </div>
            <h3 class="text-lg font-bold text-gray-900 mb-2">100% Genuine Products</h3>
            <p class="text-sm text-gray-500 leading-relaxed">We source directly from official distributors of top brands like Apple and Samsung, assuring absolute authenticity.</p>
        </div>

        <!-- Feature 2: Speed -->
        <div class="bg-white border border-gray-100 rounded-2xl p-6 shadow-sm hover:shadow-md transition-shadow">
            <div class="w-12 h-12 bg-emerald-50 border border-emerald-100/60 rounded-xl flex items-center justify-center text-emerald-600 mb-4">
                <i class="fa-solid fa-truck-fast text-xl"></i>
            </div>
            <h3 class="text-lg font-bold text-gray-900 mb-2">Same-Day Delivery</h3>
            <p class="text-sm text-gray-500 leading-relaxed">Our local shipping network ensures that snacks and accessories reach your doorstep within hours of placing your order.</p>
        </div>

        <!-- Feature 3: Support -->
        <div class="bg-white border border-gray-100 rounded-2xl p-6 shadow-sm hover:shadow-md transition-shadow">
            <div class="w-12 h-12 bg-purple-50 border border-purple-100/60 rounded-xl flex items-center justify-center text-purple-600 mb-4">
                <i class="fa-solid fa-headset text-xl"></i>
            </div>
            <h3 class="text-lg font-bold text-gray-900 mb-2">Dedicated Customer Support</h3>
            <p class="text-sm text-gray-500 leading-relaxed">Have a question? Our support team is active and ready to help via WhatsApp, email, or direct contact.</p>
        </div>
    </div>

    <!-- Developer Bio Segment -->
    <div class="bg-gradient-to-r from-gray-900 to-slate-800 rounded-3xl p-8 lg:p-12 text-white shadow-2xl relative overflow-hidden">
        <div class="absolute -right-10 -bottom-10 w-96 h-96 bg-indigo-500/10 rounded-full blur-3xl pointer-events-none"></div>
        
        <div class="lg:grid lg:grid-cols-12 lg:gap-8 items-center relative z-10">
            <div class="lg:col-span-8 space-y-6">
                <span class="text-indigo-400 text-xs font-bold uppercase tracking-wider bg-indigo-500/10 px-3 py-1 rounded-full border border-indigo-400/20">The Developer</span>
                <h2 class="text-3xl lg:text-4xl font-black tracking-tight leading-none">Meet Dipesh Dhaurali</h2>
                <p class="text-gray-300 text-base leading-relaxed">
                    Hello! I'm Dipesh Dhaurali, the designer and developer behind e-mart. I specialize in building highly responsive, premium web applications with clean architecture and modern user experiences.
                </p>
                
                <div class="flex flex-wrap gap-4 pt-4">
                    <a href="https://dipeshdhaurali.com.np/?i=1" target="_blank" class="px-5 py-3 bg-white text-gray-900 font-semibold rounded-xl hover:bg-gray-100 transition-all flex items-center gap-2">
                        <i class="fa-solid fa-globe text-sm"></i> Visit My Portfolio
                    </a>
                    <a href="https://dipeshjobportal.pythonanywhere.com/" target="_blank" class="px-5 py-3 bg-slate-800 border border-slate-700 text-white font-semibold rounded-xl hover:bg-slate-700 transition-all flex items-center gap-2">
                        <i class="fa-solid fa-folder-open text-sm"></i> Other Projects
                    </a>
                </div>
            </div>
            
            <div class="mt-8 lg:mt-0 lg:col-span-4 flex justify-center lg:justify-end gap-6 text-2xl">
                <a href="https://github.com/Dipesh-Dhaurali" target="_blank" class="w-14 h-14 rounded-2xl bg-white/5 border border-white/10 flex items-center justify-center hover:bg-white hover:text-gray-900 transition-all" title="GitHub">
                    <i class="fa-brands fa-github"></i>
                </a>
                <a href="https://www.facebook.com/dipesh.dhaurali.1/" target="_blank" class="w-14 h-14 rounded-2xl bg-white/5 border border-white/10 flex items-center justify-center hover:bg-[#1877F2] hover:border-[#1877F2] transition-all" title="Facebook">
                    <i class="fa-brands fa-facebook-f"></i>
                </a>
                <a href="https://www.instagram.com/dipesh1dip1/?hl=en" target="_blank" class="w-14 h-14 rounded-2xl bg-white/5 border border-white/10 flex items-center justify-center hover:bg-gradient-to-tr hover:from-[#f9ce34] hover:via-[#ee2a7b] hover:to-[#6228d7] hover:border-transparent transition-all" title="Instagram">
                    <i class="fa-brands fa-instagram"></i>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
