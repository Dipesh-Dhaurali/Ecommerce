@extends('layouts.admin')

@section('title', 'Show SMS')

@section('content')
<div class="space-y-6">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
            <h2 class="text-lg font-semibold text-gray-800">Contact Messages (SMS)</h2>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/80 text-gray-500 text-xs uppercase tracking-wider border-b border-gray-100">
                        <th class="px-6 py-4 font-medium">Name</th>
                        <th class="px-6 py-4 font-medium">Email</th>
                        <th class="px-6 py-4 font-medium">Subject</th>
                        <th class="px-6 py-4 font-medium">Message</th>
                        <th class="px-6 py-4 font-medium">Date</th>
                        <th class="px-6 py-4 font-medium text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-gray-700 divide-y divide-gray-100">
                    @forelse($messages as $msg)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-4 font-medium text-gray-900">
                            {{ $msg->name }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $msg->email }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-50 text-indigo-700">
                                {{ $msg->subject }}
                            </span>
                        </td>
                        <td class="px-6 py-4 max-w-xs truncate">
                            <span class="cursor-pointer text-gray-600 hover:text-indigo-600 font-medium" onclick="openSmsModal({{ $msg->id }})">
                                {{ Str::limit($msg->message, 65) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-gray-500">
                            {{ $msg->created_at->format('M d, Y h:i A') }}
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-3">
                                <button onclick="openSmsModal({{ $msg->id }})" class="text-indigo-600 hover:text-indigo-800 transition-colors" title="View Details">
                                    <i class="fa-solid fa-eye text-base"></i>
                                </button>
                                <form action="{{ route('admin.sms.destroy', $msg) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this message?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 transition-colors" title="Delete">
                                        <i class="fa-solid fa-trash-can text-base"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>

                    <!-- Detail Modal -->
                    <div id="smsModal-{{ $msg->id }}" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm hidden" x-cloak>
                        <div class="bg-gradient-to-br from-white to-gray-50 rounded-2xl p-8 max-w-lg w-full mx-4 shadow-2xl border border-gray-100 transform transition-all text-left">
                            <div class="flex items-center justify-between border-b border-gray-100 pb-4 mb-6">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-indigo-50 rounded-xl flex items-center justify-center text-indigo-600">
                                        <i class="fa-solid fa-envelope-open text-lg"></i>
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-gray-900">Message Detail</h3>
                                        <p class="text-xs text-gray-500">From: {{ $msg->name }}</p>
                                    </div>
                                </div>
                                <button onclick="closeSmsModal({{ $msg->id }})" class="text-gray-400 hover:text-gray-600 focus:outline-none">
                                    <i class="fa-solid fa-xmark text-lg"></i>
                                </button>
                            </div>
                            <div class="space-y-4 text-sm text-gray-700">
                                <div>
                                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Sender Info</p>
                                    <p class="mt-1 font-semibold text-gray-900">{{ $msg->name }} (<a href="mailto:{{ $msg->email }}" class="text-indigo-600 hover:underline">{{ $msg->email }}</a>)</p>
                                </div>
                                <div>
                                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Subject</p>
                                    <p class="mt-1 font-medium bg-indigo-50/50 text-indigo-800 px-3 py-1.5 rounded-lg inline-block">{{ $msg->subject }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Message</p>
                                    <div class="mt-1 bg-white border border-gray-150 rounded-xl p-4 text-gray-600 whitespace-pre-wrap leading-relaxed shadow-inner max-h-60 overflow-y-auto">
                                        {{ $msg->message }}
                                    </div>
                                </div>
                                <div>
                                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Received At</p>
                                    <p class="mt-1 text-gray-500">{{ $msg->created_at->format('M d, Y \a\t h:i A') }}</p>
                                </div>
                            </div>
                            <div class="mt-8 flex justify-end">
                                <button onclick="closeSmsModal({{ $msg->id }})" class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-xl transition-all">Close</button>
                            </div>
                        </div>
                    </div>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                            <i class="fa-solid fa-envelope-open text-4xl mb-3 text-gray-300"></i>
                            <p>No messages received yet.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($messages->hasPages())
        <div class="p-6 border-t border-gray-100 bg-gray-50/50">
            {{ $messages->links() }}
        </div>
        @endif
    </div>
</div>

<script>
function openSmsModal(id) {
    document.getElementById('smsModal-' + id).classList.remove('hidden');
}
function closeSmsModal(id) {
    document.getElementById('smsModal-' + id).classList.add('hidden');
}
</script>
@endsection
