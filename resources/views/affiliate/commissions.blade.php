{{-- resources/views/affiliate/commissions.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-semibold text-gray-900">Your Commissions</h1>
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

                <!-- Stats Overview -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
                    <div class="bg-indigo-50 rounded-lg shadow-sm p-4">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-sm font-medium text-indigo-500">Total Commissions</p>
                                <p class="mt-2 text-3xl font-bold text-indigo-800">{{ $commissions->total() }}</p>
                            </div>
                            <div class="rounded-full bg-indigo-100 p-2">
                                <svg class="w-6 h-6 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-green-50 rounded-lg shadow-sm p-4">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-sm font-medium text-green-500">Approved</p>
                                <p class="mt-2 text-3xl font-bold text-green-800">₹{{ number_format($commissions->where('status', 'approved')->sum('amount'), 2) }}</p>
                            </div>
                            <div class="rounded-full bg-green-100 p-2">
                                <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-yellow-50 rounded-lg shadow-sm p-4">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-sm font-medium text-yellow-500">Pending</p>
                                <p class="mt-2 text-3xl font-bold text-yellow-800">₹{{ number_format($commissions->where('status', 'pending')->sum('amount'), 2) }}</p>
                            </div>
                            <div class="rounded-full bg-yellow-100 p-2">
                                <svg class="w-6 h-6 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-blue-50 rounded-lg shadow-sm p-4">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-sm font-medium text-blue-500">Paid</p>
                                <p class="mt-2 text-3xl font-bold text-blue-800">₹{{ number_format($commissions->where('status', 'paid')->sum('amount'), 2) }}</p>
                            </div>
                            <div class="rounded-full bg-blue-100 p-2">
                                <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Filters -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-8">
                    <div class="p-4 border-b border-gray-200">
                        <h2 class="text-lg font-medium text-gray-900">Filter Commissions</h2>
                    </div>
                    <div class="p-4">
                        <form action="{{ route('affiliate.commissions') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                                <select id="status" name="status" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                    <option value="">All Statuses</option>
                                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
                                    <option value="paid" {{ request('status') === 'paid' ? 'selected' : '' }}>Paid</option>
                                    <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
                                </select>
                            </div>
                            <div>
                                <label for="date_from" class="block text-sm font-medium text-gray-700">Date From</label>
                                <input type="date" id="date_from" name="date_from" value="{{ request('date_from') }}" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                            </div>
                            <div>
                                <label for="date_to" class="block text-sm font-medium text-gray-700">Date To</label>
                                <input type="date" id="date_to" name="date_to" value="{{ request('date_to') }}" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                            </div>
                            <div class="flex items-end">
                                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <svg class="h-5 w-5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                                    </svg>
                                    Filter
                                </button>
                                <a href="{{ route('affiliate.commissions') }}" class="ml-2 inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <svg class="h-5 w-5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                    </svg>
                                    Reset
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Commissions Table -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Date
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Referred User
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Amount
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Details
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($commissions as $commission)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $commission->created_at->format('M j, Y') }}</div>
                                        <div class="text-sm text-gray-500">{{ $commission->created_at->format('g:i A') }}</div>
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
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $commission->status === 'approved' ? 'bg-green-100 text-green-800' : 
                                              ($commission->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                              ($commission->status === 'paid' ? 'bg-blue-100 text-blue-800' : 'bg-red-100 text-red-800')) }}">
                                            {{ ucfirst($commission->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        @if($commission->payout_id)
                                            <div class="text-xs">
                                                <span class="text-gray-600">Payout ID:</span> 
                                                <span class="font-medium">{{ $commission->payout_id }}</span>
                                            </div>
                                        @endif
                                        @if($commission->notes)
                                            <div class="text-xs mt-1">
                                                <span class="text-gray-600">Notes:</span> 
                                                <span>{{ $commission->notes }}</span>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                        No commissions found.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="px-4 py-3 border-t border-gray-200 sm:px-6">
                        {{ $commissions->withQueryString()->links() }}
                    </div>
                </div>

                <!-- Commission Process Explanation -->
                <div class="mt-8 bg-indigo-50 rounded-lg p-6 shadow-sm">
                    <h3 class="text-lg font-medium text-indigo-900 mb-4">How Commissions Work</h3>
                    <div class="space-y-6">
                        <div class="bg-white rounded-lg p-4 shadow-sm">
                            <h4 class="font-medium text-gray-900 mb-2">Commission Lifecycle</h4>
                            <ol class="list-decimal pl-5 space-y-2 text-sm text-gray-600">
                                <li>When someone registers using your referral link, a referral is created with <span class="font-medium text-yellow-600">pending</span> status.</li>
                                <li>After they make their first project purchase, the referral is marked as <span class="font-medium text-green-600">successful</span> and a commission is created.</li>
                                <li>Your commission starts as <span class="font-medium text-yellow-600">pending</span> while our team reviews it.</li>
                                <li>Once approved, the commission status changes to <span class="font-medium text-green-600">approved</span> and the amount is added to your available balance.</li>
                                <li>When you request a payout, the commission is included and marked as <span class="font-medium text-blue-600">paid</span> once processed.</li>
                            </ol>
                        </div>
                        <div class="bg-white rounded-lg p-4 shadow-sm">
                            <h4 class="font-medium text-gray-900 mb-2">Tier Bonuses</h4>
                            <p class="text-sm text-gray-600 mb-2">Your current tier level is <span class="font-medium text-indigo-600">Tier {{ auth()->user()->affiliateDetails->tier_level }}</span>.</p>
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tier</th>
                                            <th scope="col" class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Referrals Required</th>
                                            <th scope="col" class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bonus Per Referral</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @php
                                            $tierRequirements = \App\Models\AffiliateSetting::get('tier_requirements', [
                                                '1' => ['referrals' => 0, 'bonus' => 0],
                                                '2' => ['referrals' => 5, 'bonus' => 50],
                                                '3' => ['referrals' => 15, 'bonus' => 100],
                                                '4' => ['referrals' => 30, 'bonus' => 200],
                                                '5' => ['referrals' => 50, 'bonus' => 300]
                                            ]);
                                        @endphp

                                        @foreach($tierRequirements as $tier => $requirements)
                                        <tr class="{{ $tier == auth()->user()->affiliateDetails->tier_level ? 'bg-indigo-50' : '' }}">
                                            <td class="px-4 py-2 whitespace-nowrap text-sm font-medium {{ $tier == auth()->user()->affiliateDetails->tier_level ? 'text-indigo-700' : 'text-gray-900' }}">
                                                Tier {{ $tier }}
                                                @if($tier == auth()->user()->affiliateDetails->tier_level)
                                                    <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">Current</span>
                                                @endif
                                            </td>
                                            <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500">
                                                {{ $requirements['referrals'] }} successful referrals
                                            </td>
                                            <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500">
                                                ₹{{ $requirements['bonus'] }}
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection