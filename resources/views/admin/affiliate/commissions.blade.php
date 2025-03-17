{{-- resources/views/admin/affiliate/commissions.blade.php --}}
@extends('layouts.admin')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-semibold text-gray-900">Affiliate Commissions</h1>
            <a href="{{ route('admin.affiliate.dashboard') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <svg class="h-5 w-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z"></path>
                </svg>
                Back to Dashboard
            </a>
        </div>

        <!-- Filters -->
        <div class="bg-white shadow rounded-lg mt-6">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Filter Commissions</h3>
                <div class="mt-4">
                    <form action="{{ route('admin.affiliate.commissions') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-6 gap-4">
                        <div class="sm:col-span-1">
                            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                            <select id="status" name="status" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                <option value="">All Statuses</option>
                                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
                                <option value="paid" {{ request('status') === 'paid' ? 'selected' : '' }}>Paid</option>
                                <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
                            </select>
                        </div>
                        
                        <div class="sm:col-span-1">
                            <label for="date_from" class="block text-sm font-medium text-gray-700">Date From</label>
                            <input type="date" id="date_from" name="date_from" value="{{ request('date_from') }}" class="mt-1 block w-full border border-gray-300 py-2 px-3 shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                        </div>
                        
                        <div class="sm:col-span-1">
                            <label for="date_to" class="block text-sm font-medium text-gray-700">Date To</label>
                            <input type="date" id="date_to" name="date_to" value="{{ request('date_to') }}" class="mt-1 block w-full border border-gray-300 py-2 px-3 shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                        </div>
                        
                        <div class="sm:col-span-1">
                            <label for="min_amount" class="block text-sm font-medium text-gray-700">Min Amount</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm">₹</span>
                                </div>
                                <input type="number" id="min_amount" name="min_amount" value="{{ request('min_amount') }}" min="0" step="1" class="mt-1 block w-full pl-7 border border-gray-300 py-2 px-3 shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                            </div>
                        </div>
                        
                        <div class="sm:col-span-1">
                            <label for="max_amount" class="block text-sm font-medium text-gray-700">Max Amount</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm">₹</span>
                                </div>
                                <input type="number" id="max_amount" name="max_amount" value="{{ request('max_amount') }}" min="0" step="1" class="mt-1 block w-full pl-7 border border-gray-300 py-2 px-3 shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                            </div>
                        </div>
                        
                        <div class="sm:col-span-1 flex items-end">
                            <div class="flex space-x-2">
                                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <svg class="h-4 w-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                                    </svg>
                                    Filter
                                </button>
                                <a href="{{ route('admin.affiliate.commissions') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <svg class="h-4 w-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                    </svg>
                                    Reset
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Stats Overview -->
        <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <div class="px-4 py-5 sm:p-6">
                    <dt class="text-sm font-medium text-gray-500 truncate">Total Commissions</dt>
                    <dd class="mt-1 text-3xl font-semibold text-gray-900">₹{{ number_format($stats['total'] ?? 0, 2) }}</dd>
                </div>
                <div class="bg-gray-50 px-4 py-3">
                    <div class="text-sm text-gray-500">
                        <span class="font-medium text-gray-900">{{ $stats['count'] ?? 0 }}</span> commissions
                    </div>
                </div>
            </div>
            
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <div class="px-4 py-5 sm:p-6">
                    <dt class="text-sm font-medium text-gray-500 truncate">Pending</dt>
                    <dd class="mt-1 text-3xl font-semibold text-yellow-600">₹{{ number_format($stats['pending'] ?? 0, 2) }}</dd>
                </div>
                <div class="bg-gray-50 px-4 py-3">
                    <div class="text-sm text-gray-500">
                        <span class="font-medium text-gray-900">{{ $stats['pending_count'] ?? 0 }}</span> pending approvals
                    </div>
                </div>
            </div>
            
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <div class="px-4 py-5 sm:p-6">
                    <dt class="text-sm font-medium text-gray-500 truncate">Approved</dt>
                    <dd class="mt-1 text-3xl font-semibold text-green-600">₹{{ number_format($stats['approved'] ?? 0, 2) }}</dd>
                </div>
                <div class="bg-gray-50 px-4 py-3">
                    <div class="text-sm text-gray-500">
                        <span class="font-medium text-gray-900">{{ $stats['approved_count'] ?? 0 }}</span> approved
                    </div>
                </div>
            </div>
            
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <div class="px-4 py-5 sm:p-6">
                    <dt class="text-sm font-medium text-gray-500 truncate">Paid</dt>
                    <dd class="mt-1 text-3xl font-semibold text-blue-600">₹{{ number_format($stats['paid'] ?? 0, 2) }}</dd>
                </div>
                <div class="bg-gray-50 px-4 py-3">
                    <div class="text-sm text-gray-500">
                        <span class="font-medium text-gray-900">{{ $stats['paid_count'] ?? 0 }}</span> paid out
                    </div>
                </div>
            </div>
        </div>

        <!-- Commissions Table -->
        @if(session('success'))
        <div class="mt-6 bg-green-50 border-l-4 border-green-400 p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-green-700">{{ session('success') }}</p>
                </div>
            </div>
        </div>
        @endif

        <div class="mt-6 bg-white shadow overflow-hidden sm:rounded-md">
            <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
                <div>
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Commissions</h3>
                    <p class="mt-1 max-w-2xl text-sm text-gray-500">A list of all affiliate commissions in the system.</p>
                </div>
                <div>
                    <span class="inline-flex rounded-md shadow-sm">
                        <button type="button" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-green-600 bg-green-100 hover:bg-green-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500" onclick="document.getElementById('bulk-actions').classList.toggle('hidden')">
                            <svg class="h-4 w-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                            </svg>
                            Bulk Actions
                        </button>
                    </span>
                </div>
            </div>
            
            <!-- Bulk Actions Panel (Hidden by default) -->
            <div id="bulk-actions" class="hidden px-4 py-3 bg-gray-50 border-t border-b border-gray-200">
                <form id="bulk-commission-form" action="{{ route('admin.affiliate.bulk-approve-commissions') }}" method="POST" class="flex items-center space-x-4">
                    @csrf
                    <div class="flex-1">
                        <label for="bulk_action" class="block text-sm font-medium text-gray-700">Action</label>
                        <select id="bulk_action" name="bulk_action" onchange="updateBulkForm()" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                            <option value="">Select action...</option>
                            <option value="approve">Approve Commissions</option>
                            <option value="reject">Reject Commissions</option>
                        </select>
                    </div>
                    <div class="flex-1">
                        <label for="bulk_notes" class="block text-sm font-medium text-gray-700">Notes (Optional)</label>
                        <input type="text" id="bulk_notes" name="notes" class="mt-1 block w-full border-gray-300 py-2 px-3 shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md" placeholder="Add notes for this action">
                    </div>
                    <div class="flex-shrink-0 mt-4">
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Apply to Selected
                        </button>
                    </div>
                </form>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <div class="flex items-center">
                                    <input id="select-all" type="checkbox" class="h-4 w-4 text-indigo-600 border-gray-300 rounded">
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Affiliate
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Referred User
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Amount
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Date
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($commissions as $commission)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($commission->status === 'pending')
                                <input id="commission-{{ $commission->id }}" name="commission_ids[]" form="bulk-commission-form" type="checkbox" value="{{ $commission->id }}" class="h-4 w-4 text-indigo-600 border-gray-300 rounded">
                                @else
                                <div class="h-4 w-4"></div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center">
                                            <span class="text-sm font-medium text-indigo-800">{{ substr($commission->user->name, 0, 1) }}</span>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $commission->user->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $commission->user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="ml-0">
                                        <div class="text-sm font-medium text-gray-900">{{ $commission->referral->referredUser->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $commission->referral->referredUser->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">₹{{ number_format($commission->amount, 2) }}</div>
                                @if(isset($commission->metadata['tier_bonus']) && $commission->metadata['tier_bonus'] > 0)
                                <div class="text-xs text-green-600">Includes ₹{{ number_format($commission->metadata['tier_bonus'], 2) }} tier bonus</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $commission->created_at->format('M j, Y') }}</div>
                                <div class="text-sm text-gray-500">{{ $commission->created_at->format('g:i A') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $commission->status === 'approved' ? 'bg-green-100 text-green-800' : 
                                       ($commission->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                       ($commission->status === 'paid' ? 'bg-blue-100 text-blue-800' : 'bg-red-100 text-red-800')) }}">
                                    {{ ucfirst($commission->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex space-x-2 justify-end">
                                    @if($commission->status === 'pending')
                                    <form action="{{ route('admin.affiliate.update-commission-status', $commission->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="approved">
                                        <button type="submit" class="text-green-600 hover:text-green-900 bg-green-100 hover:bg-green-200 p-1.5 rounded-md">
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        </button>
                                    </form>
                                    
                                    <form action="{{ route('admin.affiliate.update-commission-status', $commission->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="rejected">
                                        <button type="submit" class="text-red-600 hover:text-red-900 bg-red-100 hover:bg-red-200 p-1.5 rounded-md">
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </button>
                                    </form>
                                    @endif
                                    
                                    <a href="{{ route('admin.affiliate.show-commission', $commission->id) }}" class="text-indigo-600 hover:text-indigo-900 bg-indigo-100 hover:bg-indigo-200 p-1.5 rounded-md">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                No commissions found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                {{ $commissions->withQueryString()->links() }}
            </div>
        </div>
    </div>
</div>

<script>
    // Select all checkboxes
    document.getElementById('select-all').addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('input[name="commission_ids[]"]');
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
    });
    
    // Update form action based on selected bulk action
    function updateBulkForm() {
        const bulkAction = document.getElementById('bulk_action').value;
        const form = document.getElementById('bulk-commission-form');
        
        if (bulkAction === 'approve') {
            form.action = "{{ route('admin.affiliate.bulk-approve-commissions') }}";
        } else if (bulkAction === 'reject') {
            form.action = "{{ route('admin.affiliate.bulk-reject-commissions') }}";
        }
    }
</script>
@endsection