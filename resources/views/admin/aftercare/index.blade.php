@extends('admin.layout')

@section('title', 'After Care Reservations')

@section('content')
<div class="px-4 py-6">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">After Care Reservations</h1>
        <p class="text-gray-600 mt-1">Manage shoe care service appointments</p>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 border-yellow-500 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-semibold text-yellow-600 uppercase tracking-wide">Pending</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $reservations->where('status', 'pending')->count() }}</p>
                </div>
                <div class="w-14 h-14 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-2xl flex items-center justify-center shadow-lg">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 border-blue-500 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-semibold text-blue-600 uppercase tracking-wide">Confirmed</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $reservations->where('status', 'confirmed')->count() }}</p>
                </div>
                <div class="w-14 h-14 bg-gradient-to-br from-blue-400 to-blue-600 rounded-2xl flex items-center justify-center shadow-lg">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 border-green-500 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-semibold text-green-600 uppercase tracking-wide">Completed</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $reservations->where('status', 'completed')->count() }}</p>
                </div>
                <div class="w-14 h-14 bg-gradient-to-br from-green-400 to-emerald-600 rounded-2xl flex items-center justify-center shadow-lg">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 border-red-500 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-semibold text-red-600 uppercase tracking-wide">Cancelled</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $reservations->where('status', 'cancelled')->count() }}</p>
                </div>
                <div class="w-14 h-14 bg-gradient-to-br from-red-400 to-rose-600 rounded-2xl flex items-center justify-center shadow-lg">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Customer</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Contact</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Service Type</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Date & Time</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse($reservations as $reservation)
                        <tr class="hover:bg-gradient-to-r hover:from-green-50 hover:to-transparent transition-all duration-200">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="font-bold text-purple-600">#{{ $reservation->id }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-gradient-to-br from-green-400 to-emerald-500 rounded-full flex items-center justify-center text-white font-bold text-sm mr-3">
                                        {{ strtoupper(substr($reservation->name, 0, 1)) }}
                                    </div>
                                    <div class="font-semibold text-gray-900">{{ $reservation->name }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900">{{ $reservation->email }}</div>
                                <div class="text-sm text-gray-500">{{ $reservation->phone }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-3 py-1 bg-gradient-to-r from-purple-100 to-purple-50 text-purple-700 text-sm font-semibold rounded-full border border-purple-200">
                                    ✨ {{ $reservation->service_type }}
                                </span>
                                @if($reservation->notes)
                                    <div class="text-xs text-gray-500 mt-1">{{ Str::limit($reservation->notes, 30) }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <div>
                                        <div class="font-medium text-gray-900">{{ \Carbon\Carbon::parse($reservation->reservation_date)->format('M d, Y') }}</div>
                                        <div class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($reservation->reservation_time)->format('g:i A') }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <form action="{{ route('admin.aftercare.updateStatus', $reservation->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status" 
                                            onchange="this.form.submit()"
                                            class="text-xs rounded-xl px-4 py-2 font-bold border-2 cursor-pointer transition-all
                                            {{ $reservation->status == 'pending' ? 'bg-yellow-50 text-yellow-700 border-yellow-300' : '' }}
                                            {{ $reservation->status == 'confirmed' ? 'bg-blue-50 text-blue-700 border-blue-300' : '' }}
                                            {{ $reservation->status == 'completed' ? 'bg-green-50 text-green-700 border-green-300' : '' }}
                                            {{ $reservation->status == 'cancelled' ? 'bg-red-50 text-red-700 border-red-300' : '' }}">
                                        <option value="pending" {{ $reservation->status == 'pending' ? 'selected' : '' }}>⏳ Pending</option>
                                        <option value="confirmed" {{ $reservation->status == 'confirmed' ? 'selected' : '' }}>✅ Confirmed</option>
                                        <option value="completed" {{ $reservation->status == 'completed' ? 'selected' : '' }}>🎉 Completed</option>
                                        <option value="cancelled" {{ $reservation->status == 'cancelled' ? 'selected' : '' }}>❌ Cancelled</option>
                                    </select>
                                </form>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center space-x-2">
                                    <button onclick="showDetails({{ $reservation->id }}, '{{ $reservation->name }}', '{{ $reservation->email }}', '{{ $reservation->phone }}', '{{ $reservation->service_type }}', '{{ \Carbon\Carbon::parse($reservation->reservation_date)->format('M d, Y') }}', '{{ \Carbon\Carbon::parse($reservation->reservation_time)->format('g:i A') }}', '{{ $reservation->notes ?? 'No notes' }}', '{{ $reservation->status }}')" 
                                            class="inline-flex items-center px-3 py-2 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition font-semibold">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        View
                                    </button>
                                    <form action="{{ route('admin.aftercare.destroy', $reservation->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this reservation?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center px-3 py-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition font-semibold">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <div class="text-6xl mb-4">📅</div>
                                <p class="text-gray-500 text-lg">No reservations found.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal for Viewing Details -->
<div id="detailsModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 overflow-y-auto h-full w-full z-50 backdrop-blur-sm">
    <div class="relative top-20 mx-auto p-8 border-0 w-11/12 md:w-2/3 lg:w-1/2 shadow-2xl rounded-3xl bg-white">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-2xl font-bold text-gray-900 flex items-center">
                <span class="w-10 h-10 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center mr-3">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </span>
                Reservation Details
            </h3>
            <button onclick="closeModal()" class="w-10 h-10 bg-gray-100 rounded-xl flex items-center justify-center text-gray-400 hover:text-gray-600 hover:bg-gray-200 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        
        <div id="modalContent" class="space-y-4">
            <!-- Content will be populated by JavaScript -->
        </div>
        
        <div class="mt-8 flex justify-end">
            <button onclick="closeModal()" 
                    class="px-6 py-3 bg-gray-100 text-gray-700 rounded-xl font-semibold hover:bg-gray-200 transition">
                Close
            </button>
        </div>
    </div>
</div>

<script>
function showDetails(id, name, email, phone, service, date, time, notes, status) {
    const statusStyles = {
        'pending': { bg: 'bg-gradient-to-r from-yellow-100 to-yellow-50', text: 'text-yellow-700', border: 'border-yellow-200', icon: '⏳' },
        'confirmed': { bg: 'bg-gradient-to-r from-blue-100 to-blue-50', text: 'text-blue-700', border: 'border-blue-200', icon: '✅' },
        'completed': { bg: 'bg-gradient-to-r from-green-100 to-green-50', text: 'text-green-700', border: 'border-green-200', icon: '🎉' },
        'cancelled': { bg: 'bg-gradient-to-r from-red-100 to-red-50', text: 'text-red-700', border: 'border-red-200', icon: '❌' }
    };
    
    const style = statusStyles[status] || { bg: 'bg-gray-100', text: 'text-gray-700', border: 'border-gray-200', icon: '📋' };
    
    const content = `
        <div class="grid grid-cols-2 gap-6">
            <div class="bg-gray-50 rounded-xl p-4">
                <p class="text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">Reservation ID</p>
                <p class="text-xl font-bold text-purple-600">#${id}</p>
            </div>
            <div class="bg-gray-50 rounded-xl p-4">
                <p class="text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">Status</p>
                <span class="inline-flex items-center px-4 py-2 text-sm font-bold rounded-xl ${style.bg} ${style.text} border ${style.border}">
                    ${style.icon} ${status.charAt(0).toUpperCase() + status.slice(1)}
                </span>
            </div>
            <div class="bg-gray-50 rounded-xl p-4">
                <p class="text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">Customer Name</p>
                <p class="text-lg font-semibold text-gray-900">${name}</p>
            </div>
            <div class="bg-gray-50 rounded-xl p-4">
                <p class="text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">Email</p>
                <p class="text-base text-gray-900">${email}</p>
            </div>
            <div class="bg-gray-50 rounded-xl p-4">
                <p class="text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">Phone</p>
                <p class="text-base text-gray-900">${phone}</p>
            </div>
            <div class="bg-gray-50 rounded-xl p-4">
                <p class="text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">Service Type</p>
                <p class="text-base font-semibold text-purple-600">✨ ${service}</p>
            </div>
            <div class="bg-gray-50 rounded-xl p-4">
                <p class="text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">Date</p>
                <p class="text-base text-gray-900">📅 ${date}</p>
            </div>
            <div class="bg-gray-50 rounded-xl p-4">
                <p class="text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">Time</p>
                <p class="text-base text-gray-900">🕐 ${time}</p>
            </div>
            <div class="col-span-2 bg-gradient-to-r from-purple-50 to-blue-50 rounded-xl p-4 border border-purple-100">
                <p class="text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">Additional Notes</p>
                <p class="text-base text-gray-900">${notes}</p>
            </div>
        </div>
    `;
    
    document.getElementById('modalContent').innerHTML = content;
    document.getElementById('detailsModal').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('detailsModal').classList.add('hidden');
}

// Close modal when clicking outside
document.getElementById('detailsModal')?.addEventListener('click', function(e) {
    if (e.target === this) {
        closeModal();
    }
});
</script>
@endsection
