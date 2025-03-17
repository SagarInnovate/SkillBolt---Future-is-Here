{{-- resources/views/admin/affiliate/dashboard.blade.php --}}
@extends('layouts.admin')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="mb-6 flex justify-between items-center">
            <h1 class="text-2xl font-semibold text-gray-900">Affiliate Program Dashboard</h1>
            <a href="{{ route('admin.affiliate.settings') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                Program Settings
            </a>
        </div>

        <!-- Program Status -->
        <div class="bg-white shadow-sm rounded-lg p-6 mb-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-medium text-gray-900">Program Status</h2>
                <div class="flex items-center">
                    <span class="mr-3 text-sm font-medium text-gray-900">Affiliate Program Active</span>
                    <form action="{{ route('admin.affiliate.toggle-program') }}" method="POST">
                        @csrf
                        <button type="submit" class="relative inline-flex flex-shrink-0 h-6 w-11 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 {{ $settings['affiliate_program_active'] ? 'bg-indigo-600' : 'bg-gray-200' }}" role="switch" aria-checked="{{ $settings['affiliate_program_active'] ? 'true' : 'false' }}">
                            <span class="sr-only">Toggle affiliate program</span>
                            <span aria-hidden="true" class="pointer-events-none inline-block h-5 w-5 rounded-full bg-white shadow transform ring-0 transition ease-in-out duration-200 {{ $settings['affiliate_program_active'] ? 'translate-x-5' : 'translate-x-0' }}"></span>
                        </button>
                    </form>
                </div>
            </div>
            
            <dl class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
                <div class="bg-indigo-50 rounded-lg p-4">
                    <dt class="text-sm font-medium text-indigo-500 truncate">Commission Rate</dt>
                    <dd class="mt-1 text-3xl font-semibold text-indigo-900">₹{{ number_format($settings['commission_rate'], 2) }}</dd>
                    <dd class="mt-1 text-sm text-indigo-700">Per successful referral</dd>
                </div>
                
                <div class="bg-green-50 rounded-lg p-4">
                    <dt class="text-sm font-medium text-green-500 truncate">Minimum Payout</dt>
                    <dd class="mt-1 text-3xl font-semibold text-green-900">₹{{ number_format($settings['min_payout_threshold'], 2) }}</dd>
                    <dd class="mt-1 text-sm text-green-700">Withdrawal threshold</dd>
                </div>
                
                <div class="bg-purple-50 rounded-lg p-4">
                    <dt class="text-sm font-medium text-purple-500 truncate">Leaderboard Refresh</dt>
                    <dd class="mt-1 text-3xl font-semibold text-purple-900">{{ $settings['leaderboard_refresh_hours'] }}</dd>
                    <dd class="mt-1 text-sm text-purple-700">Hours between updates</dd>
                </div>
                
                <div class="bg-orange-50 rounded-lg p-4">
                    <dt class="text-sm font-medium text-orange-500 truncate">Tier Levels</dt>
                    <dd class="mt-1 text-3xl font-semibold text-orange-900">{{ count($settings['tier_requirements']) }}</dd>
                    <dd class="mt-1 text-sm text-orange-700">Different affiliate tiers</dd>
                </div>
            </dl>
        </div>

        <!-- Stats Overview -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <!-- Key Metrics -->
            <div class="bg-white shadow-sm rounded-lg">
                <div class="p-4 border-b border-gray-200">
                    <h2 class="text-lg font-medium text-gray-900">Key Metrics</h2>
                </div>
                <div class="p-6">
                    <dl class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                        <div class="bg-indigo-50 rounded-lg overflow-hidden shadow px-4 py-5 sm:p-6">
                            <dt class="text-sm font-medium text-indigo-500 truncate">Total Affiliates</dt>
                            <dd class="mt-1 text-3xl font-semibold text-indigo-900">{{ $totalAffiliates }}</dd>
                            <dd class="mt-1 text-sm text-indigo-700">
                                <span class="font-medium text-green-600">{{ $activeAffiliates }}</span> active
                            </dd>
                        </div>
                        
                        <div class="bg-green-50 rounded-lg overflow-hidden shadow px-4 py-5 sm:p-6">
                            <dt class="text-sm font-medium text-green-500 truncate">Total Referrals</dt>
                            <dd class="mt-1 text-3xl font-semibold text-green-900">{{ $totalReferrals }}</dd>
                            <dd class="mt-1 text-sm text-green-700">
                                <span class="font-medium text-green-600">{{ $successfulReferrals }}</span> successful 
                                ({{ $conversionRate }}%)
                            </dd>
                        </div>
                        
                        <div class="bg-purple-50 rounded-lg overflow-hidden shadow px-4 py-5 sm:p-6">
                            <dt class="text-sm font-medium text-purple-500 truncate">Total Commissions</dt>
                            <dd class="mt-1 text-3xl font-semibold text-purple-900">₹{{ number_format($totalCommissions, 2) }}</dd>
                            <dd class="mt-1 text-sm text-purple-700">
                                <span class="font-medium text-purple-600">₹{{ number_format($pendingCommissions, 2) }}</span> pending approval
                            </dd>
                        </div>
                        
                        <div class="bg-blue-50 rounded-lg overflow-hidden shadow px-4 py-5 sm:p-6">
                            <dt class="text-sm font-medium text-blue-500 truncate">Approved/Paid</dt>
                            <dd class="mt-1 text-3xl font-semibold text-blue-900">₹{{ number_format($approvedCommissions + $paidCommissions, 2) }}</dd>
                            <dd class="mt-1 text-sm text-blue-700">
                                <span class="font-medium text-blue-600">₹{{ number_format($paidCommissions, 2) }}</span> already paid out
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>
            
            <!-- Monthly Referrals Chart -->
            <div class="bg-white shadow-sm rounded-lg">
                <div class="p-4 border-b border-gray-200">
                    <h2 class="text-lg font-medium text-gray-900">Monthly Referrals</h2>
                </div>
                <div class="p-6">
                    <canvas id="monthlyReferralsChart" height="250"></canvas>
                </div>
            </div>
        </div>

        <!-- Top Affiliates and Recent Payouts -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <!-- Top Affiliates -->
            <div class="md:col-span-2 bg-white shadow-sm rounded-lg">
                <div class="p-4 border-b border-gray-200 flex justify-between items-center">
                    <h2 class="text-lg font-medium text-gray-900">Top Affiliates</h2>
                    <a href="{{ route('admin.affiliate.affiliates') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">View all</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Affiliate</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Referrals</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tier</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Earnings</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($topAffiliates as $affiliate)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center">
                                                <span class="text-sm font-medium text-indigo-800">{{ substr($affiliate->user->name, 0, 1) }}</span>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $affiliate->user->name }}</div>
                                                <div class="text-sm text-gray-500">{{ $affiliate->user->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $affiliate->successful_referrals }}</div>
                                        <div class="text-sm text-gray-500">Successful</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-indigo-100 text-indigo-800">
                                            Tier {{ $affiliate->tier_level }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">₹{{ number_format($affiliate->total_earnings, 2) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $affiliate->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ ucfirst($affiliate->status) }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">No affiliates found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            
            <!-- Recent Payouts -->
            <div class="bg-white shadow-sm rounded-lg">
                <div class="p-4 border-b border-gray-200 flex justify-between items-center">
                    <h2 class="text-lg font-medium text-gray-900">Recent Payouts</h2>
                    <a href="{{ route('admin.affiliate.payouts') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">View all</a>
                </div>
                <div class="overflow-y-auto" style="max-height: 314px;">
                    <div class="divide-y divide-gray-200">
                        @forelse($recentPayouts as $payout)
                            <div class="p-4">
                                <div class="flex items-start justify-between">
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">{{ $payout->user->name }}</p>
                                        <p class="text-xs text-gray-500">{{ $payout->created_at->format('M j, Y') }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm font-medium text-gray-900">₹{{ number_format($payout->amount, 2) }}</p>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ 
                                            $payout->status === 'completed' ? 'bg-green-100 text-green-800' : 
                                            ($payout->status === 'processing' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') 
                                        }}">
                                            {{ ucfirst($payout->status) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="p-4 text-center text-sm text-gray-500">No recent payouts</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Actions Required -->
        <div class="bg-white shadow-sm rounded-lg mb-6">
            <div class="p-4 border-b border-gray-200">
                <h2 class="text-lg font-medium text-gray-900">Actions Required</h2>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Pending Commissions -->
                    <div>
                        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-yellow-800">Pending Commissions</h3>
                                    <div class="mt-2 text-sm text-yellow-700">
                                        <p>{{ $pendingCommissionsCount ?? 0 }} commissions need approval.</p>
                                    </div>
                                    @if(($pendingCommissionsCount ?? 0) > 0)
                                        <div class="mt-3">
                                            <a href="{{ route('admin.affiliate.commissions', ['status' => 'pending']) }}" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-yellow-700 bg-yellow-100 hover:bg-yellow-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                                                Review Now
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Pending Payouts -->
                    <div>
                        <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-blue-800">Pending Payouts</h3>
                                    <div class="mt-2 text-sm text-blue-700">
                                        <p>{{ $pendingPayoutsCount ?? 0 }} payouts waiting for processing.</p>
                                    </div>
                                    @if(($pendingPayoutsCount ?? 0) > 0)
                                        <div class="mt-3">
                                            <a href="{{ route('admin.affiliate.payouts', ['status' => 'processing']) }}" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-blue-700 bg-blue-100 hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                                Process Now
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- New Applications -->
                    <div>
                        <div class="bg-green-50 border-l-4 border-green-400 p-4 mb-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-green-800">New Affiliates</h3>
                                    <div class="mt-2 text-sm text-green-700">
                                        <p>{{ $newAffiliatesCount ?? 0 }} new affiliate applications.</p>
                                    </div>
                                    @if(($newAffiliatesCount ?? 0) > 0)
                                        <div class="mt-3">
                                            <a href="{{ route('admin.affiliate.affiliates', ['status' => 'inactive']) }}" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-green-700 bg-green-100 hover:bg-green-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                                Review Applications
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Links -->
        <div class="bg-white shadow-sm rounded-lg">
            <div class="p-4 border-b border-gray-200">
                <h2 class="text-lg font-medium text-gray-900">Quick Links</h2>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <a href="{{ route('admin.affiliate.affiliates') }}" class="group rounded-lg border border-gray-200 bg-white p-4 transition-all hover:border-transparent hover:shadow-lg">
                        <div class="flex items-center">
                            <div class="rounded-full bg-indigo-100 p-3 group-hover:bg-indigo-200">
                                <svg class="h-6 w-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-sm font-medium text-gray-900">Manage Affiliates</h3>
                                <p class="mt-1 text-xs text-gray-500">View and manage affiliate accounts</p>
                            </div>
                        </div>
                    </a>
                    
                    <a href="{{ route('admin.affiliate.referrals') }}" class="group rounded-lg border border-gray-200 bg-white p-4 transition-all hover:border-transparent hover:shadow-lg">
                        <div class="flex items-center">
                            <div class="rounded-full bg-green-100 p-3 group-hover:bg-green-200">
                                <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-sm font-medium text-gray-900">Track Referrals</h3>
                                <p class="mt-1 text-xs text-gray-500">Monitor and approve referrals</p>
                            </div>
                        </div>
                    </a>
                    
                    <a href="{{ route('admin.affiliate.commissions') }}" class="group rounded-lg border border-gray-200 bg-white p-4 transition-all hover:border-transparent hover:shadow-lg">
                        <div class="flex items-center">
                            <div class="rounded-full bg-purple-100 p-3 group-hover:bg-purple-200">
                                <svg class="h-6 w-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-sm font-medium text-gray-900">Manage Commissions</h3>
                                <p class="mt-1 text-xs text-gray-500">Review and approve commissions</p>
                            </div>
                        </div>
                    </a>
                    
                    <a href="{{ route('admin.affiliate.payouts') }}" class="group rounded-lg border border-gray-200 bg-white p-4 transition-all hover:border-transparent hover:shadow-lg">
                        <div class="flex items-center">
                            <div class="rounded-full bg-blue-100 p-3 group-hover:bg-blue-200">
                                <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-sm font-medium text-gray-900">Process Payouts</h3>
                                <p class="mt-1 text-xs text-gray-500">Manage affiliate payments</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.0"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Monthly Referrals Chart
        const ctx = document.getElementById('monthlyReferralsChart').getContext('2d');
        const monthlyReferralsChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($monthlyReferrals->pluck('month')) !!},
                datasets: [{
                    label: 'Referrals',
                    data: {!! json_encode($monthlyReferrals->pluck('count')) !!},
                    backgroundColor: 'rgba(99, 102, 241, 0.5)',
                    borderColor: 'rgba(99, 102, 241, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });
    });
</script>
@endsection
@endsection