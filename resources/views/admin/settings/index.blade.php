@extends('layouts.admin')

@section('title', 'System Settings')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden max-w-3xl mx-auto">
    <div class="p-6 border-b border-gray-100 bg-gray-50/50">
        <h2 class="text-lg font-semibold text-gray-800">General Settings</h2>
    </div>
    
    <div class="p-6">
        <form action="{{ route('admin.settings.update') }}" method="POST">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Site Name</label>
                    <input type="text" name="site_name" value="{{ old('site_name', $setting->site_name) }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Contact Email</label>
                    <input type="email" name="email" value="{{ old('email', $setting->email) }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Contact Phone</label>
                    <input type="text" name="phone" value="{{ old('phone', $setting->phone) }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Currency Symbol</label>
                    <input type="text" name="currency" value="{{ old('currency', $setting->currency) }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Store Address</label>
                    <textarea name="address" rows="3" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">{{ old('address', $setting->address) }}</textarea>
                </div>
                
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Logo URL</label>
                    <input type="url" name="logo" value="{{ old('logo', $setting->logo) }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                </div>
            </div>

            <div class="flex justify-end gap-3 mt-8">
                <button type="submit" class="px-5 py-2.5 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700 transition-colors shadow-sm shadow-green-200">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
