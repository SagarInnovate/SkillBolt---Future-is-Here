{{-- resources/views/affiliate/payouts.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-semibold text-gray-900">Payout Management</h1>
                    <a href="{{ route('affiliate.dashboard') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <svg class="h-5 w-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z"></path>
                        </svg>
                        Back to Dashboard
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

                <!-- Available Balance Section -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-8">
                    <div class="p-4 border-b border-gray-200">
                        <h2 class="text-lg font-medium text-gray-900">Available Balance</h2>
                    </div>
                    <div class="p-6">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
                            <div>
                                <p class="text-sm text-gray-500 mb-1">Current available balance:</p>
                                <p class="text-3xl font-bold text-gray-900">₹{{ number_format($availableBalance, 2) }}</p>
                            </div>
                            
                            @if($canRequestPayout)
                                <button type="button" onclick="showPayoutRequestForm()" class="mt-4 md:mt-0 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                    Request Payout
                                </button>
                            @else
                                <div class="mt-4 md:mt-0 text-sm font-medium text-gray-500">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full bg-yellow-100 text-yellow-800">
                                        Minimum payout threshold: ₹{{ number_format($minPayoutThreshold, 2) }}
                                    </span>
                                </div>
                            @endif
                        </div>
                        
                        <!-- Payout Request Form (Hidden by default) -->
                        <div id="payout-request-form" class="hidden mt-6 pt-6 border-t border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Request Payout</h3>
                            <form action="{{ route('affiliate.request-payout') }}" method="POST">
                                @csrf
                                <div class="grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-4">
                                    <div class="sm:col-span-2">
                                        <label for="payment_method" class="block text-sm font-medium text-gray-700">Payment Method</label>
                                        <select id="payment_method" name="payment_method" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                            <option value="bank_transfer">Bank Transfer</option>
                                            <option value="upi">UPI</option>
                                            <option value="wallet_credit">Wallet Credit</option>
                                        </select>
                                    </div>
                                    
                                    <div class="sm:col-span-2">
                                        <label for="payment_details" class="block text-sm font-medium text-gray-700">Payment Details</label>
                                        <textarea id="payment_details" name="payment_details" rows="3" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Enter your payment details (account number, UPI ID, etc.)"></textarea>
                                        <p class="mt-2 text-sm text-gray-500">Please provide detailed information for receiving your payment.</p>
                                    </div>
                                    
                                    <div class="sm:col-span-2">
                                        <div class="bg-yellow-50 p-4 rounded-md">
                                            <div class="flex">
                                                <div class="flex-shrink-0">
                                                    <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                    </svg>
                                                </div>
                                                <div class="ml-3">
                                                    <h3 class="text-sm font-medium text-yellow-800">Important Note</h3>
                                                    <div class="mt-2 text-sm text-yellow-700">
                                                        <p>Payouts are processed within 5-7 business days. Make sure your payment details are correct to avoid delays.</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="mt-6 flex justify-end space-x-3">
                                    <button type="button" onclick="hidePayoutRequestForm()" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Cancel
                                    </button>
                                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Submit Request
                                    </button>
                                </div>
                            </form>
                        </div>
                        
                        <!-- Pending Payout Section (if there's a pending payout) -->
                        @if($pendingPayout)
                        <div class="mt-6 pt-6 border-t border-gray-200">
                            <div class="rounded-md bg-blue-50 p-4">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="ml-3 flex-1 md:flex md:justify-between">
                                        <div>
                                            <h3 class="text-sm font-medium text-blue-800">Pending Payout Request</h3>
                                            <div class="mt-2 text-sm text-blue-700">
                                                <p>You have a pending payout request for ₹{{ number_format($pendingPayout->amount, 2) }} submitted on {{ $pendingPayout->created_at->format('M j, Y') }}.</p>
                                            </div>
                                        </div>
                                        <div class="mt-4 text-sm md:mt-0 md:ml-6">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-md bg-blue-100 text-blue-800">
                                                Processing
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Payout History -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                    <div class="p-4 border-b border-gray-200">
                        <h2 class="text-lg font-medium text-gray-900">Payout History</h2>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Date Requested
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Amount
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Payment Method
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Transaction Details
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($payouts as $payout)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $payout->created_at->format('M j, Y') }}</div>
                                        <div class="text-sm text-gray-500">{{ $payout->created_at->format('g:i A') }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        ₹{{ number_format($payout->amount, 2) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ ucfirst(str_replace('_', ' ', $payout->payment_method)) }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $payout->status === 'completed' ? 'bg-green-100 text-green-800' : 
                                              ($payout->status === 'processing' ? 'bg-blue-100 text-blue-800' : 'bg-red-100 text-red-800') }}">
                                            {{ ucfirst($payout->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        @if($payout->status === 'completed')
                                            <div class="text-xs">
                                                <span class="text-gray-600">Transaction ID:</span> 
                                                <span class="font-mono font-medium">{{ $payout->transaction_id ?? 'N/A' }}</span>
                                            </div>
                                            <div class="text-xs mt-1">
                                                <span class="text-gray-600">Processed:</span> 
                                                <span>{{ $payout->payout_date ? $payout->payout_date->format('M j, Y') : 'N/A' }}</span>
                                            </div>
                                        @elseif($payout->status === 'processing')
                                            <span class="text-xs text-blue-600">Processing since {{ $payout->created_at->diffForHumans() }}</span>
                                        @else
                                            <span class="text-xs text-red-600">{{ $payout->notes ?? 'Failed to process' }}</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                        No payout history found.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="px-4 py-3 border-t border-gray-200 sm:px-6">
                        {{ $payouts->links() }}
                    </div>
                </div>

                <!-- Payout FAQ -->
                <div class="mt-8 bg-indigo-50 rounded-lg p-6 shadow-sm">
                    <h3 class="text-lg font-medium text-indigo-900 mb-4">Payout FAQ</h3>
                    <div class="space-y-4">
                        <div>
                            <h4 class="font-medium text-gray-900">How often can I request payouts?</h4>
                            <p class="mt-1 text-sm text-gray-600">You can request a payout whenever your available balance reaches or exceeds the minimum threshold of ₹{{ number_format($minPayoutThreshold, 2) }}. There's no limit on how many payouts you can request.</p>
                        </div>
                        <div>
                            <h4 class="font-medium text-gray-900">How long does it take to process payouts?</h4>
                            <p class="mt-1 text-sm text-gray-600">Payouts are typically processed within 5-7 business days. You'll receive an email notification once your payout has been processed.</p>
                        </div>
                        <div>
                            <h4 class="font-medium text-gray-900">What payment methods are available?</h4>
                            <p class="mt-1 text-sm text-gray-600">We currently support bank transfers, UPI payments, and wallet credits. Bank transfers may take 1-3 additional business days to reflect in your account after processing.</p>
                        </div>
                        <div>
                            <h4 class="font-medium text-gray-900">Why was my payout request rejected?</h4>
                            <p class="mt-1 text-sm text-gray-600">Payout requests may be rejected if the payment details provided are incorrect or incomplete. If your payout is rejected, you'll be notified of the reason, and the amount will be returned to your available balance.</p>
                        </div>
                        <div>
                            <h4 class="font-medium text-gray-900">Is there a fee for processing payouts?</h4>
                            <p class="mt-1 text-sm text-gray-600">No, we don't charge any fees for processing payouts. You'll receive the full amount of your available balance.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function showPayoutRequestForm() {
        document.getElementById('payout-request-form').classList.remove('hidden');
    }
    
    function hidePayoutRequestForm() {
        document.getElementById('payout-request-form').classList.add('hidden');
    }
</script>
@endsection