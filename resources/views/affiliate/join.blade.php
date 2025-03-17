{{-- resources/views/affiliate/join.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="mb-8">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                        <div>
                            <h1 class="text-2xl font-semibold text-gray-900">Join Affiliate Program</h1>
                            <p class="mt-1 text-sm text-gray-500">Earn rewards by referring friends to SkillBolt.dev</p>
                        </div>
                        <div class="mt-4 md:mt-0">
                            <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <svg class="h-5 w-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z"></path>
                                </svg>
                                Back to Dashboard
                            </a>
                        </div>
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

                <!-- Program Overview -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-8">
                    <div class="p-4 border-b border-gray-200">
                        <h2 class="text-lg font-medium text-gray-900">Affiliate Program Overview</h2>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                            <div class="bg-indigo-50 rounded-lg p-4 shadow-sm">
                                <div class="flex items-start space-x-3">
                                    <div class="flex-shrink-0">
                                        <svg class="h-6 w-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="font-medium text-gray-900">Earn Per Referral</h3>
                                        <p class="mt-1 text-sm text-gray-500">
                                            Earn ₹{{ number_format($commissionRate, 2) }} for each friend who joins and makes their first purchase.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-indigo-50 rounded-lg p-4 shadow-sm">
                                <div class="flex items-start space-x-3">
                                    <div class="flex-shrink-0">
                                        <svg class="h-6 w-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="font-medium text-gray-900">Tier Bonuses</h3>
                                        <p class="mt-1 text-sm text-gray-500">
                                            Earn higher commissions as you reach higher tier levels based on your performance.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-indigo-50 rounded-lg p-4 shadow-sm">
                                <div class="flex items-start space-x-3">
                                    <div class="flex-shrink-0">
                                        <svg class="h-6 w-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="font-medium text-gray-900">Easy Payments</h3>
                                        <p class="mt-1 text-sm text-gray-500">
                                            Request payouts via bank transfer, UPI, or wallet credit once you reach the minimum threshold.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gradient-to-r from-indigo-500 to-purple-600 rounded-lg p-6 text-white">
                            <h3 class="text-xl font-bold mb-4">How It Works</h3>
                            <ol class="space-y-4">
                                <li class="flex">
                                    <div class="flex-shrink-0 flex h-6 w-6 rounded-full bg-white text-indigo-600 items-center justify-center mr-3">
                                        <span class="font-bold text-sm">1</span>
                                    </div>
                                    <span>Join the affiliate program and get your unique referral link</span>
                                </li>
                                <li class="flex">
                                    <div class="flex-shrink-0 flex h-6 w-6 rounded-full bg-white text-indigo-600 items-center justify-center mr-3">
                                        <span class="font-bold text-sm">2</span>
                                    </div>
                                    <span>Share your link with friends, classmates, and social media</span>
                                </li>
                                <li class="flex">
                                    <div class="flex-shrink-0 flex h-6 w-6 rounded-full bg-white text-indigo-600 items-center justify-center mr-3">
                                        <span class="font-bold text-sm">3</span>
                                    </div>
                                    <span>Earn commissions when they join and make their first purchase</span>
                                </li>
                                <li class="flex">
                                    <div class="flex-shrink-0 flex h-6 w-6 rounded-full bg-white text-indigo-600 items-center justify-center mr-3">
                                        <span class="font-bold text-sm">4</span>
                                    </div>
                                    <span>Request a payout when your balance reaches the minimum threshold</span>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>

                <!-- Tier System -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-8">
                    <div class="p-4 border-b border-gray-200">
                        <h2 class="text-lg font-medium text-gray-900">Tier System</h2>
                    </div>
                    <div class="p-6">
                        <p class="mb-4 text-sm text-gray-600">
                            Our tier system rewards top performers with higher commission rates. As you refer more users, you'll automatically move up to higher tiers.
                        </p>
                        
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Tier
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Successful Referrals Required
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Bonus Per Referral
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Total Commission Per Referral
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($tierRequirements as $tier => $requirements)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">Tier {{ $tier }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-500">{{ $requirements['referrals'] }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">₹{{ number_format($requirements['bonus'], 2) }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-green-600">₹{{ number_format($commissionRate + $requirements['bonus'], 2) }}</div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Terms & Join Button -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                    <div class="p-4 border-b border-gray-200">
                        <h2 class="text-lg font-medium text-gray-900">Join Now</h2>
                    </div>
                    <div class="p-6">
                        <form action="{{ route('affiliate.process-join') }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <div class="relative flex items-start">
                                    <div class="flex items-center h-5">
                                        <input id="terms" name="terms" type="checkbox" required class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                                    </div>
                                    <div class="ml-3 text-sm">
                                        <label for="terms" class="font-medium text-gray-700">I agree to the affiliate program terms and conditions</label>
                                        <p class="text-gray-500">I understand that I must comply with all program rules and guidelines. SkillBolt.dev reserves the right to terminate my affiliate account if I violate these terms.</p>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Join Affiliate Program
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection