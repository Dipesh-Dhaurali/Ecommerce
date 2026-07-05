@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="min-h-[calc(100vh-16rem)] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full bg-white rounded-2xl shadow-xl border border-gray-100 p-8">
        <div>
            <div class="text-center">
                <i class="fa-solid fa-user-plus text-4xl text-green-600 mb-4"></i>
                <h2 class="text-3xl font-extrabold text-gray-900">Create an account</h2>
            </div>
        </div>
        <form class="mt-8 space-y-6" action="{{ route('register') }}" method="POST">
            @csrf
            
            @if($errors->any())
            <div class="bg-red-50 text-red-600 p-4 rounded-lg text-sm">
                {{ $errors->first() }}
            </div>
            @endif
            
            <div class="space-y-4">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                    <input id="name" name="name" type="text" required value="{{ old('name') }}" class="mt-1 appearance-none block w-full px-3 py-2 border border-gray-300 rounded-xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm">
                </div>
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email address</label>
                    <input id="email" name="email" type="email" required value="{{ old('email') }}" class="mt-1 appearance-none block w-full px-3 py-2 border border-gray-300 rounded-xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm">
                </div>
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input id="password" name="password" type="password" required class="mt-1 appearance-none block w-full px-3 py-2 border border-gray-300 rounded-xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm">
                </div>
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" required class="mt-1 appearance-none block w-full px-3 py-2 border border-gray-300 rounded-xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm">
                </div>
            </div>

            <div>
                <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors">
                    Sign up
                </button>
            </div>
        </form>
        
        <div class="mt-6 text-center text-sm text-gray-600">
            Already have an account? <a href="{{ route('login') }}" class="font-medium text-green-600 hover:text-green-500">Sign in</a>
        </div>
    </div>
</div>
@endsection
