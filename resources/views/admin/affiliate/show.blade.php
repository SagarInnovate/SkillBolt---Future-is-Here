{{-- resources/views/admin/affiliate/show.blade.php --}}
@extends('layouts.admin')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-semibold text-gray-900">Affiliate Details</h1>
                    <div class="flex space-x-2">
                        <a href="{{ route('admin.affiliate.affiliates') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <svg class="h-5 w-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z"></path>
                            </svg>
                            Back to Affiliates
                        </a>
                    </div>
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

                <!-- Affiliate Profile Header -->
                <div class="bg-white rounded-lg shadow-sm overflow-hidden mb-8">
                    <div class="md:flex md:items-center md:justify-between md:space-x-5 p-6">
                        <div class="flex items-start space-x-5">
                            <div class="flex-shrink-0">
                                <div class="relative">
                                    @if($affiliateDetail->user->profile_image)
                                        <img class="h-16 w-16 rounded-full" src="{{ $affiliateDetail->user->profile_image }}" alt="{{ $affiliateDetail->user->name }}">
                                    @else
                                        <div class="h-16 w-16 rounded-full bg-indigo-100 flex items-center justify-center">
                                            <span class="text-2xl font-medium text-indigo-700">{{ substr($affiliateDetail->user->name, 0, 1) }}</span>
                                        </div>
                                    @endif
                                    <span class="absolute inset-0 shadow-inner rounded-full" aria-hidden="true"></span>
                                </div>
                            </div>
                            <div>
                                <h1 class="text-2xl font-bold text-gray-900">{{ $affiliateDetail->user->name }}</h1>
                                <p class="text-sm font-medium text-gray-500">{{ $affiliateDetail->user->email }}</p>
                                <div class="mt-2">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                        Tier {{ $affiliateDetail->tier_level }}
                                    </span>
                                    <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $affiliateDetail->status === 'active' ? 'bg-green-100 text-green-800' : ($affiliateDetail->status === 'inactive' ? 'bg-gray-100 text-gray-800' : 'bg-red-100 text-red-800') }}">
                                        {{ ucfirst($affiliateDetail->status) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="mt-6 flex flex-col-reverse justify-stretch space-y-4 space-y-reverse sm:flex-row-reverse sm:justify-end sm:space-x-reverse sm:space-y-0 sm:space-x-3 md:mt-0 md:flex-row md:space-x-3">
                            <form action="{{ route('admin.affiliate.update-affiliate-status', $affiliateDetail->id) }}" method="POST" class="inline-block">
                                @csrf
                                @method('PATCH')
                                <select name="status" onchange="this.form.submit()" class="mt-1 block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm">
                                    <option value="active" {{ $affiliateDetail->status === 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ $affiliateDetail->status === 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    <option value="suspended" {{ $affiliateDetail->status === 'suspended' ? 'selected' : '' }}>Suspended</option>
                                </select>
                            </form>
                            <a href="mailto:{{ $affiliateDetail->user->email }}" class="inline-flex items-center justify-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <svg class="h-5 w-5 mr-1.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                Contact
                            </a>
                        </div>
                    </div>
                    <div class="border-t border-gray-200 px-6 py-5 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
                        <div>
                            <h3 class="text-xs font-medium text-gray-500 uppercase tracking-wide">Affiliate Code</h3>
                            <p class="mt-1 text-sm font-mono text-gray-900">{{ $affiliateDetail->affiliate_code }}</p>
                        </div>
                        <div>
                            <h3 class="text-xs font-medium text-gray-500 uppercase tracking-wide">Joined</h3>
                            <p class="mt-1 text-sm text-gray-900">{{ $affiliateDetail->created_at->format('M j, Y') }}</p>
                        </div>
                        <div>
                            <h3 class="text-xs font-medium text-gray-500 uppercase tracking-wide">Total Referrals</h3>
                            <p class="mt-1 text-sm text-gray-900">{{ $affiliateDetail->total_referrals }}</p>
                        </div>
                        <div>
                            <h3 class="text-xs font-medium text-gray-500 uppercase tracking-wide">Successful Referrals</h3>
                            <p class="mt-1 text-sm text-gray-900">{{ $affiliateDetail->successful_referrals }}</p>
                        </div>
                        <div>
                            <h3 class="text-xs font-medium text-gray-500 uppercase tracking-wide">Total Earnings</h3>
                            <p class="mt-1 text-sm text-gray-900">₹{{ number_format($affiliateDetail->total_earnings, 2) }}</p>
                        </div>
                        <div>
                            <h3 class="text-xs font-medium text-gray-500 uppercase tracking-wide">Available Balance</h3>
                            <p class="mt-1 text-sm text-gray-900">₹{{ number_format($affiliateDetail->available_balance, 2) }}</p>
                        </div>
                        <div>
                            <h3 class="text-xs font-medium text-gray-500 uppercase tracking-wide">Conversion Rate</h3>
                            <p class="mt-1 text-sm text-gray-900">{{ $affiliateDetail->successful_referrals > 0 && $affiliateDetail->total_referrals > 0 ? number_format(($affiliateDetail->successful_referrals / $affiliateDetail->total_referrals) * 100, 2) : 0 }}%</p>
                        </div>
                        <div>
                            <h3 class="text-xs font-medium text-gray-500 uppercase tracking-wide">Referral Link</h3>
                            <p class="mt-1 text-sm font-mono text-gray-900 truncate">{{ url('/?ref=' . $affiliateDetail->affiliate_code) }}</p>
                        </div>
                    </div>
                </div>

                <!-- Tabs -->
                <div class="mb-8">
                    <div class="sm:hidden">
                        <label for="tabs" class="sr-only">Select a tab</label>
                        <select id="tabs" name="tabs" onchange="window.location.hash = this.value" class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                            <option value="#referrals">Referrals</option>
                            <option value="#commissions">Commissions</option>
                            <option value="#payouts">Payouts</option>
                            <option value="#referral-clicks">Referral Clicks</option>
                            <option value="#achievements">Achievements</option>
                        </select>
                    </div>
                    <div class="hidden sm:block">
                        <div class="border-b border-gray-200">
                            <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                                <a href="#referrals" onclick="showTab('referrals')" class="tab-link border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm active" aria-current="page">
                                    Referrals ({{ $referrals->total() }})
                                </a>
                                <a href="#commissions" onclick="showTab('commissions')" class="tab-link border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                                    Commissions ({{ $commissions->total() }})
                                </a>
                                <a href="#payouts" onclick="showTab('payouts')" class="tab-link border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                                    Payouts ({{ $payouts->total() }})
                                </a>
                                <a href="#referral-clicks" onclick="showTab('referral-clicks')" class="tab-link border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                                    Referral Clicks ({{ count($referralClicks) }})
                                </a>
                                <a href="#achievements" onclick="showTab('achievements')" class="tab-link border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                                    Achievements ({{ count($achievements) }})
                                </a>
                            </nav>
                        </div>
                    </div>
                </div>

                <!-- Tab Content -->
                <div>
                    <!-- Referrals Tab -->
                    <div id="referrals-tab" class="tab-content">
                        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
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
                                                Status
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Conversion Date
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Actions
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @forelse($referrals as $referral)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $referral->created_at->format('M j, Y') }}</div>
                                                <div class="text-sm text-gray-500">{{ $referral->created_at->format('g:i A') }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">{{ $referral->referredUser->name }}</div>
                                                <div class="text-sm text-gray-500">{{ $referral->referredUser->email }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                    {{ $referral->status === 'successful' ? 'bg-green-100 text-green-800' : 
                                                       ($referral->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                                    {{ ucfirst($referral->status) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">
                                                    {{ $referral->conversion_date ? $referral->conversion_date->format('M j, Y') : '-' }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <form action="{{ route('admin.affiliate.update-referral-status', $referral->id) }}" method="POST" class="inline-block">
                                                    @csrf
                                                    @method('PATCH')
                                                    <select name="status" onchange="this.form.submit()" class="text-sm border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                                        <option value="pending" {{ $referral->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                                        <option value="successful" {{ $referral->status === 'successful' ? 'selected' : '' }}>Successful</option>
                                                        <option value="failed" {{ $referral->status === 'failed' ? 'selected' : '' }}>Failed</option>
                                                    </select>
                                                </form>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                                No referrals found.
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="px-4 py-3 border-t border-gray-200 sm:px-6">
                                {{ $referrals->fragment('referrals')->links() }}
                            </div>
                        </div>
                    </div>

                    <!-- Commissions Tab -->
                    <div id="commissions-tab" class="tab-content hidden">
                        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
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
                                                Actions
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
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                @if($commission->status !== 'paid')
                                                <form action="{{ route('admin.affiliate.update-commission-status', $commission->id) }}" method="POST" class="inline-block">
                                                    @csrf
                                                    @method('PATCH')
                                                    <select name="status" onchange="this.form.submit()" class="text-sm border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                                        <option value="pending" {{ $commission->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                                        <option value="approved" {{ $commission->status === 'approved' ? 'selected' : '' }}>Approved</option>
                                                        <option value="rejected" {{ $commission->status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                                                    </select>
                                                </form>
                                                @else
                                                <span class="text-xs text-gray-500">Already paid</span>
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
                                {{ $commissions->fragment('commissions')->links() }}
                            </div>
                        </div>
                    </div>

                    <!-- Payouts Tab -->
                    <div id="payouts-tab" class="tab-content hidden">
                        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
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
                                                Actions
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
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <a href="{{ route('admin.affiliate.show-payout', $payout->id) }}" class="text-indigo-600 hover:text-indigo-900">View</a>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                                No payouts found.
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="px-4 py-3 border-t border-gray-200 sm:px-6">
                                {{ $payouts->fragment('payouts')->links() }}
                            </div>
                        </div>
                    </div>

                    <!-- Referral Clicks Tab -->
                    <div id="referral-clicks-tab" class="tab-content hidden">
                        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                            <div class="p-6">
                                <div class="mb-6">
                                    <h3 class="text-lg font-medium text-gray-900">Click Activity</h3>
                                    <p class="mt-1 text-sm text-gray-500">Last 30 days of click data for this affiliate's referral link.</p>
                                </div>
                                <div class="h-64">
                                    <canvas id="clickChart"></canvas>
                                </div>
                            </div>
                            <div class="border-t border-gray-200">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Date
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Clicks
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @forelse($referralClicks as $click)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $click->date }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $click->count }}</div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="2" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                                No click data found.
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Achievements Tab -->
                    <div id="achievements-tab" class="tab-content hidden">
                        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                            <div class="p-6">
                                <div class="mb-6">
                                    <h3 class="text-lg font-medium text-gray-900">Earned Achievements</h3>
                                    <p class="mt-1 text-sm text-gray-500">Badges and recognition earned by this affiliate.</p>
                                </div>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                    @forelse($achievements as $achievement)
                                        <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                                            <div class="flex items-center space-x-3">
                                                <div class="flex-shrink-0">
                                                    @if($achievement->badge_image)
                                                        <img src="{{ asset('storage/' . $achievement->badge_image) }}" alt="{{ $achievement->name }}" class="h-10 w-10">
                                                    @else
                                                        <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center">
                                                            <svg class="h-6 w-6 text-indigo-600" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                                <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                            </svg>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div>
                                                    <h4 class="text-sm font-medium text-gray-900">{{ $achievement->name }}</h4>
                                                    {{ \Carbon\Carbon::parse($achievement->pivot->earned_at)->format('M j, Y') }}                                                </div>
                                            </div>
                                            <p class="mt-2 text-sm text-gray-600">{{ $achievement->description }}</p>
                                            <div class="mt-2">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    +{{ $achievement->points_value }} Points
                                                </span>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="col-span-3 text-center py-8 bg-gray-50 rounded-lg">
                                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            <h3 class="mt-2 text-sm font-medium text-gray-900">No achievements yet</h3>
                                            <p class="mt-1 text-sm text-gray-500">This affiliate hasn't earned any achievements yet.</p>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Tab functionality
    function showTab(tabName) {
        // Hide all tab contents
        document.querySelectorAll('.tab-content').forEach(tab => {
            tab.classList.add('hidden');
        });
        
        // Show the selected tab content
        document.getElementById(tabName + '-tab').classList.remove('hidden');
        
        // Update active tab link
        document.querySelectorAll('.tab-link').forEach(link => {
            link.classList.remove('border-indigo-500', 'text-indigo-600');
            link.classList.add('border-transparent', 'text-gray-500');
        });
        
        // Set active tab link
        event.currentTarget.classList.remove('border-transparent', 'text-gray-500');
        event.currentTarget.classList.add('border-indigo-500', 'text-indigo-600');
    }
    
    // Load tab based on URL hash
    document.addEventListener('DOMContentLoaded', function() {
        const hash = window.location.hash.substring(1);
        if (hash && ['referrals', 'commissions', 'payouts', 'referral-clicks', 'achievements'].includes(hash)) {
            showTab(hash);
        }
        
        // Click chart
        const ctx = document.getElementById('clickChart');
        if (ctx) {
            const dates = @json($referralClicks->pluck('date'));
            const counts = @json($referralClicks->pluck('count'));
            
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: dates,
                    datasets: [{
                        label: 'Referral Clicks',
                        data: counts,
                        backgroundColor: 'rgba(79, 70, 229, 0.2)',
                        borderColor: 'rgba(79, 70, 229, 1)',
                        borderWidth: 2,
                        tension: 0.3,
                        pointBackgroundColor: 'rgba(79, 70, 229, 1)',
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            precision: 0
                        }
                    }
                }
            });
        }
    });
</script>
@endpush
@endsection