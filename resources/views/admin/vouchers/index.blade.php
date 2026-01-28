@extends('admin.layout')

@section('title', 'Vouchers')

@section('content')
<div class="px-4 py-6">
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h1 class="text-4xl font-bold text-gray-900 mb-2">Vouchers</h1>
            <p class="text-gray-600">Manage all vouchers in your store</p>
        </div>
        <a href="{{ route('admin.vouchers.create') }}" class="bg-gradient-to-r from-blue-600 to-blue-700 text-white font-semibold py-3 px-6 rounded-lg hover:from-blue-700 hover:to-blue-800 transition-all shadow-lg hover:shadow-xl">
            + Add New Voucher
        </a>
    </div>

    @if(session('success'))
    <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg">
        {{ session('success') }}
    </div>
    @endif

    <!-- Filter Tabs -->
    <div class="mb-6 flex space-x-4">
        <a href="{{ route('admin.vouchers.index') }}" class="px-4 py-2 rounded-lg {{ !request('filter') ? 'bg-blue-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-50' }}">
            All Vouchers
        </a>
        <a href="{{ route('admin.vouchers.index', ['filter' => 'unused']) }}" class="px-4 py-2 rounded-lg {{ request('filter') === 'unused' ? 'bg-blue-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-50' }}">
            Unused
        </a>
        <a href="{{ route('admin.vouchers.index', ['filter' => 'used']) }}" class="px-4 py-2 rounded-lg {{ request('filter') === 'used' ? 'bg-blue-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-50' }}">
            Used
        </a>
        <a href="{{ route('admin.vouchers.index', ['filter' => 'expired']) }}" class="px-4 py-2 rounded-lg {{ request('filter') === 'expired' ? 'bg-blue-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-50' }}">
            Expired
        </a>
    </div>

    <div class="admin-card p-6">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Code</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Purchased By</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Expires</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($vouchers as $voucher)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="font-mono font-bold text-blue-600">{{ $voucher->code }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="font-semibold">${{ number_format($voucher->amount, 2) }}</span>
                        </td>
                        <td class="px-6 py-4">
                            {{ $voucher->description ?? 'N/A' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($voucher->purchaser)
                                {{ $voucher->purchaser->name }}
                            @else
                                <span class="text-gray-400">Not purchased</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($voucher->is_used)
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-200 text-gray-800">Used</span>
                            @elseif($voucher->expires_at && $voucher->expires_at < now())
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Expired</span>
                            @else
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Active</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            {{ $voucher->expires_at ? $voucher->expires_at->format('M d, Y') : 'No expiry' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <div class="flex space-x-2">
                                @if(!$voucher->is_used && (!$voucher->expires_at || $voucher->expires_at > now()))
                                <form action="{{ route('admin.vouchers.markAsUsed', $voucher->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="text-yellow-600 hover:text-yellow-900" onclick="return confirm('Mark this voucher as used?')">
                                        Mark Used
                                    </button>
                                </form>
                                @endif
                                <form action="{{ route('admin.vouchers.destroy', $voucher->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Delete this voucher?')">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                            <div class="flex flex-col items-center">
                                <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z"></path>
                                </svg>
                                <p class="text-lg font-medium">No vouchers found</p>
                                <p class="text-sm mt-1">Get started by creating your first voucher</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($vouchers->hasPages())
        <div class="mt-6">
            {{ $vouchers->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
