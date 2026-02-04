@extends('admin.layout')

@section('content')
<div class="py-6">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-6">
            <a href="{{ route('admin.contact-messages.index') }}" class="inline-flex items-center text-blue-600 hover:text-blue-700 font-semibold">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Back to Messages
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <!-- Header -->
            <div class="bg-gradient-to-r from-purple-600 to-blue-600 px-8 py-6">
                <div class="flex items-center justify-between">
                    <h1 class="text-2xl font-bold text-white">Contact Message</h1>
                    @if(!$message->is_read)
                        <span class="px-3 py-1 bg-white text-purple-600 rounded-full text-sm font-semibold">New</span>
                    @endif
                </div>
                <p class="text-purple-100 text-sm mt-1">Received on {{ $message->created_at->format('F d, Y \a\t H:i') }}</p>
            </div>

            <!-- Message Details -->
            <div class="p-8">
                <!-- Sender Info -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div class="bg-gray-50 rounded-lg p-4">
                        <label class="block text-sm font-semibold text-gray-600 mb-2">From</label>
                        <p class="text-lg font-bold text-gray-900">{{ $message->name }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <label class="block text-sm font-semibold text-gray-600 mb-2">Email</label>
                        <a href="mailto:{{ $message->email }}" class="text-lg font-bold text-blue-600 hover:text-blue-700">
                            {{ $message->email }}
                        </a>
                    </div>
                </div>

                <!-- Subject -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-600 mb-2">Subject</label>
                    <p class="text-xl font-bold text-gray-900">{{ $message->subject }}</p>
                </div>

                <!-- Message -->
                <div class="mb-8">
                    <label class="block text-sm font-semibold text-gray-600 mb-3">Message</label>
                    <div class="bg-gray-50 rounded-lg p-6 border-l-4 border-purple-600">
                        <p class="text-gray-800 whitespace-pre-wrap leading-relaxed">{{ $message->message }}</p>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex items-center space-x-4 pt-6 border-t">
                    <a href="mailto:{{ $message->email }}?subject=Re: {{ $message->subject }}" 
                       class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-semibold shadow-lg">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        Reply via Email
                    </a>
                    <form action="{{ route('admin.contact-messages.destroy', $message->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="inline-flex items-center px-6 py-3 bg-red-500 text-white rounded-lg hover:bg-red-600 transition font-semibold shadow-lg" 
                                onclick="return confirm('Delete this message?')">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Delete Message
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
