{{-- resources/views/admin/affiliate/settings.blade.php --}}
@extends('layouts.admin')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-semibold text-gray-900">Affiliate Program Settings</h1>
            <a href="{{ route('admin.affiliate.dashboard') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
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

        <form action="{{ route('admin.affiliate.update-settings') }}" method="POST">
            @csrf
            <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                <!-- Basic Settings -->
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-lg font-medium text-gray-900 mb-4">Basic Settings</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="commission_rate" class="block text-sm font-medium text-gray-700">Base Commission Rate (₹)</label>
                            <div class="mt-1">
                                <input type="number" min="0" step="1" name="commission_rate" id="commission_rate" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" value="{{ $settings['commission_rate'] ?? 300 }}">
                            </div>
                            <p class="mt-2 text-sm text-gray-500">The base amount earned per successful referral.</p>
                        </div>
                        
                        <div>
                            <label for="min_payout_threshold" class="block text-sm font-medium text-gray-700">Minimum Payout Threshold (₹)</label>
                            <div class="mt-1">
                                <input type="number" min="0" step="1" name="min_payout_threshold" id="min_payout_threshold" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" value="{{ $settings['min_payout_threshold'] ?? 1000 }}">
                            </div>
                            <p class="mt-2 text-sm text-gray-500">Minimum balance required to request a payout.</p>
                        </div>
                        
                        <div>
                            <label for="leaderboard_refresh_hours" class="block text-sm font-medium text-gray-700">Leaderboard Refresh Interval (Hours)</label>
                            <div class="mt-1">
                                <input type="number" min="1" max="168" step="1" name="leaderboard_refresh_hours" id="leaderboard_refresh_hours" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" value="{{ $settings['leaderboard_refresh_hours'] ?? 24 }}">
                            </div>
                            <p class="mt-2 text-sm text-gray-500">How often the leaderboard is refreshed.</p>
                        </div>
                        
                        <div>
                            <label for="affiliate_program_active" class="block text-sm font-medium text-gray-700">Affiliate Program Status</label>
                            <div class="mt-1">
                                <select name="affiliate_program_active" id="affiliate_program_active" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                    <option value="1" {{ $settings['affiliate_program_active'] ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ !$settings['affiliate_program_active'] ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>
                            <p class="mt-2 text-sm text-gray-500">Enable or disable the entire affiliate program.</p>
                        </div>
                    </div>
                </div>
                
                <!-- Tier Settings -->
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-lg font-medium text-gray-900 mb-4">Tier Settings</h2>
                    
                    <div class="bg-gray-50 p-4 rounded-md mb-6">
                        <p class="text-sm text-gray-700">Configure the requirements for each tier level and the bonus amount per referral for that tier.</p>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tier</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Required Referrals</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bonus Per Referral (₹)</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($tierRequirements as $tier => $requirements)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">Tier {{ $tier }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <input type="number" min="0" step="1" name="tier_requirements[{{ $tier }}][referrals]" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" value="{{ $requirements['referrals'] }}">
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <input type="number" min="0" step="1" name="tier_requirements[{{ $tier }}][bonus]" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" value="{{ $requirements['bonus'] }}">
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <!-- Payout Settings -->
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-lg font-medium text-gray-900 mb-4">Payout Settings</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="payout_methods" class="block text-sm font-medium text-gray-700">Available Payout Methods</label>
                            <div class="mt-2 space-y-2">
                                <div class="flex items-start">
                                    <div class="flex items-center h-5">
                                        <input id="payout_methods_bank" name="payout_methods[]" type="checkbox" value="bank_transfer" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded" {{ in_array('bank_transfer', $settings['payout_methods'] ?? []) ? 'checked' : '' }}>
                                    </div>
                                    <div class="ml-3 text-sm">
                                        <label for="payout_methods_bank" class="font-medium text-gray-700">Bank Transfer</label>
                                    </div>
                                </div>
                                
                                <div class="flex items-start">
                                    <div class="flex items-center h-5">
                                        <input id="payout_methods_upi" name="payout_methods[]" type="checkbox" value="upi" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded" {{ in_array('upi', $settings['payout_methods'] ?? []) ? 'checked' : '' }}>
                                    </div>
                                    <div class="ml-3 text-sm">
                                        <label for="payout_methods_upi" class="font-medium text-gray-700">UPI</label>
                                    </div>
                                </div>
                                
                                <div class="flex items-start">
                                    <div class="flex items-center h-5">
                                        <input id="payout_methods_wallet" name="payout_methods[]" type="checkbox" value="wallet_credit" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded" {{ in_array('wallet_credit', $settings['payout_methods'] ?? []) ? 'checked' : '' }}>
                                    </div>
                                    <div class="ml-3 text-sm">
                                        <label for="payout_methods_wallet" class="font-medium text-gray-700">Wallet Credit</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div>
                            <label for="payout_schedule" class="block text-sm font-medium text-gray-700">Payout Schedule</label>
                            <div class="mt-1">
                                <select name="payout_schedule" id="payout_schedule" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                    <option value="on_request" {{ ($settings['payout_schedule'] ?? '') === 'on_request' ? 'selected' : '' }}>On Request</option>
                                    <option value="weekly" {{ ($settings['payout_schedule'] ?? '') === 'weekly' ? 'selected' : '' }}>Weekly</option>
                                    <option value="biweekly" {{ ($settings['payout_schedule'] ?? '') === 'biweekly' ? 'selected' : '' }}>Bi-weekly</option>
                                    <option value="monthly" {{ ($settings['payout_schedule'] ?? '') === 'monthly' ? 'selected' : '' }}>Monthly</option>
                                </select>
                            </div>
                            <p class="mt-2 text-sm text-gray-500">How often payouts are processed.</p>
                        </div>
                    </div>
                </div>
                
                <!-- Leaderboard Settings -->
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-lg font-medium text-gray-900 mb-4">Leaderboard Settings</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="top_leaderboard_count" class="block text-sm font-medium text-gray-700">Number of Top Affiliates</label>
                            <div class="mt-1">
                                <input type="number" min="3" max="100" step="1" name="top_leaderboard_count" id="top_leaderboard_count" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" value="{{ $settings['top_leaderboard_count'] ?? 10 }}">
                            </div>
                            <p class="mt-2 text-sm text-gray-500">Number of affiliates shown on the leaderboard.</p>
                        </div>
                        
                        <div>
                            <label for="leaderboard_calculation" class="block text-sm font-medium text-gray-700">Leaderboard Ranking By</label>
                            <div class="mt-1">
                                <select name="leaderboard_calculation" id="leaderboard_calculation" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                    <option value="referrals" {{ ($settings['leaderboard_calculation'] ?? '') === 'referrals' ? 'selected' : '' }}>Number of Referrals</option>
                                    <option value="earnings" {{ ($settings['leaderboard_calculation'] ?? '') === 'earnings' ? 'selected' : '' }}>Total Earnings</option>
                                </select>
                            </div>
                            <p class="mt-2 text-sm text-gray-500">How the leaderboard ranks are calculated.</p>
                        </div>
                    </div>
                </div>
                
                <!-- Save Button -->
                <div class="px-6 py-3 bg-gray-50 text-right">
                    <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Save Settings
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection