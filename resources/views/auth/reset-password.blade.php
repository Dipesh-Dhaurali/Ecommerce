@extends('layouts.app')

@section('title', 'Reset Password')

@section('content')
<div class="min-h-[calc(100vh-16rem)] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full bg-white rounded-2xl shadow-xl border border-gray-100 p-8">
        <div>
            <div class="text-center">
                <i class="fa-solid fa-lock text-4xl text-green-600 mb-4"></i>
                <h2 class="text-3xl font-extrabold text-gray-900">Reset Password</h2>
                <p class="mt-2 text-sm text-gray-600">Enter your new password below</p>
            </div>
        </div>
        <form class="mt-8 space-y-6" action="{{ route('password.update') }}" method="POST">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            
            @if($errors->any())
            <div class="bg-red-50 text-red-600 p-4 rounded-lg text-sm">
                {{ $errors->first() }}
            </div>
            @endif
            
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email address</label>
                <input id="email" name="email" type="email" required value="{{ request('email') }}" class="mt-1 appearance-none block w-full px-3 py-2 border border-gray-300 rounded-xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm">
            </div>
            
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <div class="mt-1 relative">
                    <input id="password" name="password" type="password" required class="block w-full px-3 py-2 pr-10 border border-gray-300 rounded-xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm">
                    <button type="button" onclick="togglePassword('password')" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600">
                        <i class="fa-solid fa-eye" id="password-eye"></i>
                    </button>
                </div>
            </div>
            
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                <div class="mt-1 relative">
                    <input id="password_confirmation" name="password_confirmation" type="password" required class="block w-full px-3 py-2 pr-10 border border-gray-300 rounded-xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm">
                    <button type="button" onclick="togglePassword('password_confirmation')" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600">
                        <i class="fa-solid fa-eye" id="password_confirmation-eye"></i>
                    </button>
                </div>
            </div>

            <div>
                <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors">
                    Reset Password
                </button>
            </div>
        </form>
        
        <div class="mt-6 text-center text-sm text-gray-600">
            Remember your password? <a href="{{ route('login') }}" class="font-medium text-green-600 hover:text-green-500">Sign in</a>
        </div>
    </div>
</div>

<script>
function togglePassword(fieldId) {
    const input = document.getElementById(fieldId);
    const eye = document.getElementById(fieldId + '-eye');
    if (input.type === 'password') {
        input.type = 'text';
        eye.classList.remove('fa-eye');
        eye.classList.add('fa-eye-slash');
    } else {
        input.type = 'password';
        eye.classList.remove('fa-eye-slash');
        eye.classList.add('fa-eye');
    }
}
</script>
@endsection
