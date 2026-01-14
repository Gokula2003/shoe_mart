@extends('admin.layout')

@section('title', 'After Care Reservations')

@section('content')
<div class="px-4 py-6">
    <h1 class="text-3xl font-bold text-gray-900 mb-6">After Care Reservations</h1>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4 rounded">
            <p class="text-sm text-yellow-700">Pending</p>
            <p class="text-2xl font-bold text-yellow-900">{{ $reservations->where('status', 'pending')->count() }}</p>
        </div>
        <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded">
            <p class="text-sm text-blue-700">Confirmed</p>
            <p class="text-2xl font-bold text-blue-900">{{ $reservations->where('status', 'confirmed')->count() }}</p>
        </div>
        <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded">
            <p class="text-sm text-green-700">Completed</p>
            <p class="text-2xl font-bold text-green-900">{{ $reservations->where('status', 'completed')->count() }}</p>
        </div>
        <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded">
            <p class="text-sm text-red-700">Cancelled</p>
            <p class="text-2xl font-bold text-red-900">{{ $reservations->where('status', 'cancelled')->count() }}</p>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contact</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Service Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date & Time</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($reservations as $reservation)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                #{{ $reservation->id }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $reservation->name }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900">{{ $reservation->email }}</div>
                                <div class="text-sm text-gray-500">{{ $reservation->phone }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900">{{ $reservation->service_type }}</div>
                                @if($reservation->notes)
                                    <div class="text-xs text-gray-500 mt-1">{{ Str::limit($reservation->notes, 30) }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ \Carbon\Carbon::parse($reservation->reservation_date)->format('M d, Y') }}</div>
                                <div class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($reservation->reservation_time)->format('g:i A') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <form action="{{ route('admin.aftercare.updateStatus', $reservation->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status" 
                                            onchange="this.form.submit()"
                                            class="text-xs rounded-full px-3 py-1 font-semibold
                                            {{ $reservation->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                            {{ $reservation->status == 'confirmed' ? 'bg-blue-100 text-blue-800' : '' }}
                                            {{ $reservation->status == 'completed' ? 'bg-green-100 text-green-800' : '' }}
                                            {{ $reservation->status == 'cancelled' ? 'bg-red-100 text-red-800' : '' }}">
                                        <option value="pending" {{ $reservation->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="confirmed" {{ $reservation->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                        <option value="completed" {{ $reservation->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                        <option value="cancelled" {{ $reservation->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    </select>
                                </form>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <button onclick="showDetails({{ $reservation->id }}, '{{ $reservation->name }}', '{{ $reservation->email }}', '{{ $reservation->phone }}', '{{ $reservation->service_type }}', '{{ \Carbon\Carbon::parse($reservation->reservation_date)->format('M d, Y') }}', '{{ \Carbon\Carbon::parse($reservation->reservation_time)->format('g:i A') }}', '{{ $reservation->notes ?? 'No notes' }}', '{{ $reservation->status }}')" 
                                        class="text-blue-600 hover:text-blue-900 mr-3">
                                    View
                                </button>
                                <form action="{{ route('admin.aftercare.destroy', $reservation->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this reservation?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                                No reservations found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal for Viewing Details -->
<div id="detailsModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-2/3 lg:w-1/2 shadow-lg rounded-md bg-white">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-2xl font-bold text-gray-900">Reservation Details</h3>
            <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        
        <div id="modalContent" class="space-y-4">
            <!-- Content will be populated by JavaScript -->
        </div>
        
        <div class="mt-6">
            <button onclick="closeModal()" 
                    style="background-color: #6b7280 !important; color: white !important; padding: 10px 20px; border-radius: 6px; font-weight: 600;">
                Close
            </button>
        </div>
    </div>
</div>

<script>
function showDetails(id, name, email, phone, service, date, time, notes, status) {
    const statusColors = {
        'pending': 'bg-yellow-100 text-yellow-800',
        'confirmed': 'bg-blue-100 text-blue-800',
        'completed': 'bg-green-100 text-green-800',
        'cancelled': 'bg-red-100 text-red-800'
    };
    
    const statusColor = statusColors[status] || 'bg-gray-100 text-gray-800';
    
    const content = `
        <div class="grid grid-cols-2 gap-4">
            <div>
                <p class="text-sm font-medium text-gray-500">Reservation ID</p>
                <p class="text-lg font-semibold text-gray-900">#${id}</p>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Status</p>
                <span class="inline-block px-3 py-1 text-sm font-semibold rounded-full ${statusColor}">
                    ${status.charAt(0).toUpperCase() + status.slice(1)}
                </span>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Customer Name</p>
                <p class="text-base text-gray-900">${name}</p>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Email</p>
                <p class="text-base text-gray-900">${email}</p>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Phone</p>
                <p class="text-base text-gray-900">${phone}</p>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Service Type</p>
                <p class="text-base text-gray-900">${service}</p>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Date</p>
                <p class="text-base text-gray-900">${date}</p>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Time</p>
                <p class="text-base text-gray-900">${time}</p>
            </div>
            <div class="col-span-2">
                <p class="text-sm font-medium text-gray-500">Additional Notes</p>
                <p class="text-base text-gray-900 bg-gray-50 p-3 rounded mt-1">${notes}</p>
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
