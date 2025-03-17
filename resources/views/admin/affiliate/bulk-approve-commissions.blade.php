{{-- resources/views/admin/affiliate/bulk-approve-commissions.blade.php --}}
@extends('layouts.admin')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-semibold text-gray-900">Bulk Approve Commissions</h1>
                    <a href="{{ route('admin.affiliate.commissions') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <svg class="h-5 w-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z"></path>
                        </svg>
                        Back to Commissions
                    </a>
                </div>

                @if(session('success'))
                <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
                @endif

                @if(session('error'))
                <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
                @endif

                <div class="bg-gray-50 p-4 rounded-lg mb-6">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-blue-800">Bulk Approval Information</h3>
                            <div class="mt-2 text-sm text-blue-700">
                                <p>This page allows you to approve multiple pending commissions at once. Use the checkboxes to select which commissions you want to approve, then click the "Approve Selected" button.</p>
                                <p class="mt-1">Only pending commissions are shown. The system will automatically update affiliate balances for all approved commissions.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <form action="" method="POST" id="bulk-approve-form">
                    @csrf
                    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                        <div class="flex justify-between items-center p-4 border-b border-gray-200">
                            <div class="flex items-center">
                                <input id="select-all" type="checkbox" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                <label for="select-all" class="ml-2 text-sm text-gray-700">Select All</label>
                            </div>
                            
                            <button type="submit" id="approve-selected-btn" disabled class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Approve Selected (<span id="selected-count">0</span>)
                            </button>
                        </div>
                        
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Select
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Date
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
                                            Referral Date
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse($pendingCommissions as $commission)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <input id="commission-{{ $commission->id }}" name="commission_ids[]" value="{{ $commission->id }}" type="checkbox" class="commission-checkbox h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $commission->created_at->format('M j, Y') }}</div>
                                            <div class="text-sm text-gray-500">{{ $commission->created_at->format('g:i A') }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ $commission->user->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $commission->user->email }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ $commission->referral->referredUser->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $commission->referral->referredUser->email }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">₹{{ number_format($commission->amount, 2) }}</div>
                                            @if($commission->metadata && isset($commission->metadata['tier_bonus']) && $commission->metadata['tier_bonus'] > 0)
                                                <div class="text-xs text-green-600">Includes ₹{{ number_format($commission->metadata['tier_bonus'], 2) }} tier bonus</div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $commission->referral->created_at->format('M j, Y') }}</div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                            No pending commissions found.
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="px-4 py-3 border-t border-gray-200">
                            @if(count($pendingCommissions) > 0)
                            <div class="flex justify-between items-center">
                                <div class="text-sm text-gray-700">
                                    {{ $pendingCommissions->total() }} pending commissions
                                </div>
                                <button type="submit" id="approve-selected-bottom-btn" disabled class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Approve Selected (<span id="selected-count-bottom">0</span>)
                                </button>
                            </div>
                            @endif
                            
                            {{ $pendingCommissions->links() }}
                        </div>
                    </div>
                </form>
                
                <div class="mt-8 bg-white rounded-lg shadow-sm overflow-hidden p-6">
                    <h2 class="text-lg font-medium text-gray-900 mb-4">Bulk Approval Log</h2>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Date
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Admin
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Commissions Approved
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Total Amount
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($approvalLogs as $log)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $log->created_at->format('M j, Y') }}</div>
                                        <div class="text-sm text-gray-500">{{ $log->created_at->format('g:i A') }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $log->admin->name }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $log->commission_count }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">₹{{ number_format($log->total_amount, 2) }}</div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                        No approval logs found.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const selectAllCheckbox = document.getElementById('select-all');
        const commissionCheckboxes = document.querySelectorAll('.commission-checkbox');
        const approveSelectedBtn = document.getElementById('approve-selected-btn');
        const approveSelectedBottomBtn = document.getElementById('approve-selected-bottom-btn');
        const selectedCountElements = document.querySelectorAll('#selected-count, #selected-count-bottom');
        const bulkApproveForm = document.getElementById('bulk-approve-form');
        
        // Function to update the selected count and button state
        function updateSelectedCount() {
            const checkedCount = document.querySelectorAll('.commission-checkbox:checked').length;
            
            selectedCountElements.forEach(element => {
                element.textContent = checkedCount;
            });
            
            // Enable or disable the approve buttons
            const isDisabled = checkedCount === 0;
            approveSelectedBtn.disabled = isDisabled;
            approveSelectedBottomBtn.disabled = isDisabled;
            
            // Update select all checkbox
            selectAllCheckbox.checked = checkedCount === commissionCheckboxes.length && commissionCheckboxes.length > 0;
        }
        
        // Add event listener to each commission checkbox
        commissionCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', updateSelectedCount);
        });
        
        // Add event listener to select all checkbox
        selectAllCheckbox.addEventListener('change', function() {
            commissionCheckboxes.forEach(checkbox => {
                checkbox.checked = selectAllCheckbox.checked;
            });
            
            updateSelectedCount();
        });
        
        // Add submit confirmation
        bulkApproveForm.addEventListener('submit', function(event) {
            const checkedCount = document.querySelectorAll('.commission-checkbox:checked').length;
            
            if (checkedCount === 0) {
                event.preventDefault();
                alert('Please select at least one commission to approve.');
                return false;
            }
            
            if (!confirm(`Are you sure you want to approve ${checkedCount} commissions? This action cannot be undone.`)) {
                event.preventDefault();
                return false;
            }
        });
        
        // Initial update
        updateSelectedCount();
    });
</script>
@endpush
@endsection