@extends('layouts.app')

@section('content')
<div class="py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Header Section with Stats Summary -->
        <div class="mb-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Affiliate Dashboard</h1>
                    <p class="mt-1 text-sm text-gray-500">Welcome to your affiliate dashboard, {{ auth()->user()->name }}</p>
                </div>
                <div class="mt-4 md:mt-0">
                    <button id="generate-qr-code-btn" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path>
                        </svg>
                        Generate QR Code
                    </button>
                </div>
            </div>
            
            <!-- Stats Cards -->
            <div class="mt-6 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
                <!-- Total Referrals -->
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-indigo-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Total Referrals</dt>
                                    <dd class="flex items-baseline">
                                        <div class="text-2xl font-semibold text-gray-900">{{ $referrals }}</div>
                                        <div class="ml-2 flex items-baseline text-sm font-semibold text-green-600">
                                            <span class="sr-only">Includes</span>
                                            <span>{{ $successfulReferrals }} successful</span>
                                        </div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Available Balance -->
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Available Balance</dt>
                                    <dd class="flex items-baseline">
                                        <div class="text-2xl font-semibold text-gray-900">₹{{ number_format($availableBalance, 2) }}</div>
                                        @if($canRequestPayout)
                                            <div class="ml-2">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    Ready for payout
                                                </span>
                                            </div>
                                        @endif
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Total Earnings -->
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-purple-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Total Earnings</dt>
                                    <dd class="flex items-baseline">
                                        <div class="text-2xl font-semibold text-gray-900">₹{{ number_format($totalEarnings, 2) }}</div>
                                        @if($pendingCommissions > 0)
                                            <div class="ml-2 flex items-baseline text-sm font-semibold text-yellow-600">
                                                <span class="sr-only">Plus</span>
                                                <span>₹{{ number_format($pendingCommissions, 2) }} pending</span>
                                            </div>
                                        @endif
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Tier Level -->
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-yellow-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Current Tier</dt>
                                    <dd class="flex items-baseline">
                                        <div class="text-2xl font-semibold text-gray-900">Tier {{ $currentTier }}</div>
                                        @if($nextTierInfo)
                                            <div class="ml-2">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                    {{ $nextTierProgress }}% to Tier {{ $nextTier }}
                                                </span>
                                            </div>
                                        @endif
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Left Column - Referral Link & Stats -->
            <div class="md:col-span-2">
                <!-- Referral Link -->
                <div class="bg-white shadow-sm rounded-lg mb-6">
                    <div class="p-4 border-b border-gray-200">
                        <h2 class="text-lg font-medium text-gray-900">Your Referral Link</h2>
                    </div>
                    <div class="p-6">
                        <label for="referral-link" class="block text-sm font-medium text-gray-700">Share this link with friends to earn rewards</label>
                        <div class="mt-1 flex rounded-md shadow-sm">
                            <input type="text" name="referral-link" id="referral-link" class="flex-1 min-w-0 block w-full px-3 py-2 rounded-md border border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" value="{{ $referralLink }}" readonly>
                            <button type="button" onclick="copyReferralLink()" class="inline-flex items-center px-4 py-2 border border-transparent rounded-r-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-12a2 2 0 00-2-2h-2M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                                Copy
                            </button>
                        </div>

                        <div class="mt-4">
                            <div class="p-4 bg-gray-50 rounded-lg">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium text-gray-800">Your commission for each successful referral</h3>
                                        <div class="mt-2 text-sm text-gray-700">
                                            <ul class="list-disc space-y-1 pl-5">
                                                <li>Base commission: ₹{{ number_format($commissionRate) }} per referral</li>
                                                @if(isset($currentTierInfo['bonus']) && $currentTierInfo['bonus'] > 0)
                                                    <li>Tier {{ $currentTier }} bonus: ₹{{ number_format($currentTierInfo['bonus']) }} extra per referral</li>
                                                    <li>Your total commission per referral: ₹{{ number_format($commissionRate + $currentTierInfo['bonus']) }}</li>
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if($qrCodeUrl)
                        <div class="mt-4 flex flex-col items-center" id="qr-code-container">
                            <img src="{{ $qrCodeUrl }}" alt="Referral QR Code" class="h-48 w-48" id="referral-qr-code">
                            
                            <div class="mt-3 flex space-x-2">
                                <button type="button" onclick="downloadQRCode()" class="inline-flex items-center px-3 py-1.5 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                    </svg>
                                    Download QR
                                </button>
                                
                                <button type="button" onclick="copyQRCodeImage()" class="inline-flex items-center px-3 py-1.5 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-12a2 2 0 00-2-2h-2M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                    </svg>
                                    Copy QR
                                </button>
                            </div>
                        </div>
                    @else
                        <div class="mt-4 flex justify-center hidden" id="qr-code-container">
                            <div class="h-48 w-48 flex items-center justify-center border border-gray-200 rounded-lg">
                                <p class="text-sm text-gray-500">QR Code will appear here</p>
                            </div>
                        </div>
                    @endif
                    </div>
                </div>
                
                <!-- Tier Progress -->
                @if($nextTierInfo)
                    <div class="bg-white shadow-sm rounded-lg mb-6">
                        <div class="p-4 border-b border-gray-200">
                            <h2 class="text-lg font-medium text-gray-900">Tier Progress</h2>
                        </div>
                        <div class="p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <span class="text-sm font-medium text-gray-900">Current Tier {{ $currentTier }}</span>
                                    {{-- <span class="ml-1 text-sm text-gray-500">({{ $currentTierInfo['name'] ?? '' }})</span> --}}
                                </div>
                                <div>
                                    <span class="text-sm font-medium text-gray-900">Next Tier {{ $nextTier }}</span>
                                    {{-- <span class="ml-1 text-sm text-gray-500">({{ $nextTierInfo['name'] ?? '' }})</span> --}}
                                </div>
                            </div>
                            <div class="mt-4">
                                <div class="relative pt-1">
                                    <div class="overflow-hidden h-2 text-xs flex rounded bg-gray-200">
                                        <div style="width: {{ $nextTierProgress }}%" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-indigo-500"></div>
                                    </div>
                                </div>
                                <div class="mt-2 text-xs text-gray-600">
                                    <span>{{ $affiliateDetail->successful_referrals }} of {{ $nextTierInfo['referrals'] }} referrals needed for next tier</span>
                                </div>
                                <div class="mt-4 text-sm">
                                    <p class="text-gray-700">Tier {{ $nextTier }} benefits:</p>
                                    <ul class="list-disc space-y-1 pl-5 mt-2 text-gray-600">
                                        <li>₹{{ number_format($nextTierInfo['bonus']) }} extra commission per referral</li>
                                        @if(isset($nextTierInfo['benefits']))
                                            @foreach($nextTierInfo['benefits'] as $benefit)
                                                <li>{{ $benefit }}</li>
                                            @endforeach
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                
                <!-- Recent Referrals -->
                <div class="bg-white shadow-sm rounded-lg mb-6">
                    <div class="p-4 border-b border-gray-200 flex justify-between items-center">
                        <h2 class="text-lg font-medium text-gray-900">Recent Referrals</h2>
                        <a href="{{ route('affiliate.referrals') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">View all</a>
                    </div>
                    <div class="overflow-hidden">
                        @if(count($recentReferrals) > 0)
                            <ul class="divide-y divide-gray-200">
                                @foreach($recentReferrals as $referral)
                                    <li class="p-4">
                                        <div class="flex items-center space-x-4">
                                            <div class="flex-shrink-0">
                                                @if($referral->referredUser->profile_image)
                                                    <img class="h-10 w-10 rounded-full" src="{{ $referral->referredUser->profile_image }}" alt="">
                                                @else
                                                    <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center">
                                                        <span class="text-lg font-medium text-indigo-800">{{ substr($referral->referredUser->name, 0, 1) }}</span>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-medium text-gray-900 truncate">
                                                    {{ $referral->referredUser->name }}
                                                </p>
                                                <p class="text-sm text-gray-500 truncate">
                                                    Joined {{ $referral->created_at->diffForHumans() }}
                                                </p>
                                            </div>
                                            <div>
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $referral->status === 'successful' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                                    {{ ucfirst($referral->status) }}
                                                </span>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <div class="p-4 text-center text-gray-500">
                                <p>No referrals found. Share your referral link to start earning!</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- Right Column - Leaderboard & Achievements -->
            <div>
                <!-- Leaderboard -->
                <div class="bg-white shadow-sm rounded-lg mb-6">
                    <div class="p-4 border-b border-gray-200 flex justify-between items-center">
                        <h2 class="text-lg font-medium text-gray-900">Leaderboard</h2>
                        <a href="{{ route('affiliate.leaderboard') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">View all</a>
                    </div>
                    <div class="overflow-hidden">
                        @if(count($leaderboard) > 0)
                            <ul class="divide-y divide-gray-200">
                                @foreach($leaderboard as $leader)
                                    <li class="p-4 {{ $leader['is_current_user'] ? 'bg-indigo-50' : '' }}">
                                        <div class="flex items-center space-x-4">
                                            <div class="flex-shrink-0 w-6 text-center">
                                                <span class="font-bold text-gray-700">{{ $leader['rank'] }}</span>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-medium {{ $leader['is_current_user'] ? 'text-indigo-700' : 'text-gray-900' }} truncate">
                                                    {{ $leader['name'] }}
                                                    @if($leader['is_current_user'])
                                                        <span class="ml-1 font-normal text-indigo-600">(You)</span>
                                                    @endif
                                                </p>
                                                <p class="text-xs text-gray-500">
                                                    Tier {{ $leader['tier'] }} • {{ $leader['referrals'] }} referrals
                                                </p>
                                            </div>
                                            <div>
                                                <span class="text-sm font-medium text-gray-900">₹{{ number_format($leader['earnings']) }}</span>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <div class="p-4 text-center text-gray-500">
                                <p>No leaderboard data available yet.</p>
                            </div>
                        @endif
                    </div>
                </div>
                
                <!-- Your Rank -->
                <div class="bg-white shadow-sm rounded-lg mb-6">
                    <div class="p-4 border-b border-gray-200">
                        <h2 class="text-lg font-medium text-gray-900">Your Rank</h2>
                    </div>
                    <div class="p-6 text-center">
                        @if($userRank)
                            <div class="inline-flex items-center justify-center h-20 w-20 rounded-full bg-indigo-100 text-indigo-800 mb-4">
                                <span class="text-3xl font-bold">{{ $userRank }}</span>
                            </div>
                            <p class="text-gray-700">
                                @if($userRank == 1)
                                    You're at the top of the leaderboard! Keep it up!
                                @elseif($userRank <= 3)
                                    You're in the top 3! Amazing work!
                                @elseif($userRank <= 10)
                                    You're in the top 10! Great job!
                                @else
                                    Keep referring to climb the ranks!
                                @endif
                            </p>
                        @else
                            <div class="inline-flex items-center justify-center h-20 w-20 rounded-full bg-gray-100 text-gray-400 mb-4">
                                <span class="text-3xl font-bold">-</span>
                            </div>
                            <p class="text-gray-500">Get your first successful referral to earn a rank!</p>
                        @endif
                    </div>
                </div>
                
                <!-- Achievements -->
                <div class="bg-white shadow-sm rounded-lg">
                    <div class="p-4 border-b border-gray-200">
                        <h2 class="text-lg font-medium text-gray-900">Your Achievements</h2>
                    </div>
                    <div class="p-4">
                        @if(count($achievements) > 0)
                            <div class="grid grid-cols-2 gap-4">
                                @foreach($achievements as $achievement)
                                    <div class="border border-gray-200 rounded-lg p-3 text-center">
                                        @if($achievement->badge_image)
                                            <img src="{{ asset('storage/' . $achievement->badge_image) }}" alt="{{ $achievement->name }}" class="h-12 w-12 mx-auto mb-2">
                                        @else
                                            <div class="h-12 w-12 mx-auto mb-2 rounded-full bg-indigo-100 flex items-center justify-center">
                                                <svg class="h-6 w-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                                </svg>
                                            </div>
                                        @endif
                                        <h3 class="text-sm font-medium text-gray-900">{{ $achievement->name }}</h3>
                                        <p class="text-xs text-gray-500">{{ $achievement->description }}</p>
                                        <p class="text-xs text-indigo-600 mt-1">{{ $achievement->pivot->earned_at->format('M j, Y') }}</p>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center p-4">
                                <div class="mx-auto h-12 w-12 text-gray-400">
                                    <svg class="h-12 w-12" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                                    </svg>
                                </div>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">No achievements yet</h3>
                                <p class="mt-1 text-sm text-gray-500">Keep referring to earn achievements!</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Recent Commissions -->
        <div class="mt-6">
            <div class="bg-white shadow-sm rounded-lg">
                <div class="p-4 border-b border-gray-200 flex justify-between items-center">
                    <h2 class="text-lg font-medium text-gray-900">Recent Commissions</h2>
                    <a href="{{ route('affiliate.commissions') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">View all</a>
                </div>
                <div class="overflow-x-auto">
                    @if(count($recentCommissions) > 0)
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Referral</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($recentCommissions as $commission)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $commission->created_at->format('M j, Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-8 w-8">
                                                    @if($commission->referral->referredUser->profile_image)
                                                        <img class="h-8 w-8 rounded-full" src="{{ $commission->referral->referredUser->profile_image }}" alt="">
                                                    @else
                                                        <div class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center">
                                                            <span class="text-xs font-medium text-indigo-800">{{ substr($commission->referral->referredUser->name, 0, 1) }}</span>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">
                                                        {{ $commission->referral->referredUser->name }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            ₹{{ number_format($commission->amount, 2) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $commission->status === 'approved' ? 'bg-green-100 text-green-800' : ($commission->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800') }}">
                                                {{ ucfirst($commission->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="p-4 text-center text-gray-500">
                            <p>No commissions found. Get referrals to earn commissions!</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Request Payout Section -->
        @if($canRequestPayout)
            <div class="mt-6">
                <div class="bg-white shadow-sm rounded-lg">
                    <div class="p-4 border-b border-gray-200">
                        <h2 class="text-lg font-medium text-gray-900">Request Payout</h2>
                    </div>
                    <div class="p-6">
                        <div class="bg-green-50 border-l-4 border-green-400 p-4 mb-6">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-green-700">
                                        You have ₹{{ number_format($availableBalance, 2) }} available for payout. The minimum threshold is ₹{{ number_format($minPayoutThreshold, 2) }}.
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                        <form action="{{ route('affiliate.request-payout') }}" method="POST">
                            @csrf
                            <div class="space-y-4">
                                <div>
                                    <label for="payment_method" class="block text-sm font-medium text-gray-700">Payment Method</label>
                                    <select id="payment_method" name="payment_method" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                        <option value="bank_transfer">Bank Transfer</option>
                                        <option value="upi">UPI</option>
                                        <option value="wallet_credit">Wallet Credit</option>
                                    </select>
                                </div>
                                
                                <div>
                                    <label for="payment_details" class="block text-sm font-medium text-gray-700">Payment Details</label>
                                    <textarea id="payment_details" name="payment_details" rows="3" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Enter your payment details (account number, UPI ID, etc.)"></textarea>
                                    <p class="mt-2 text-sm text-gray-500">Please provide accurate payment details to ensure smooth processing.</p>
                                </div>
                                
                                <div>
                                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Request Payout of ₹{{ number_format($availableBalance, 2) }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

<!-- JavaScript for Clipboard and QR Code Generation -->
<script>
function copyReferralLink() {
    const copyText = document.getElementById('referral-link');
    copyText.select();
    copyText.setSelectionRange(0, 99999); // For mobile devices
    
    navigator.clipboard.writeText(copyText.value);
    
    // Show a temporary "copied" tooltip
    alert('Referral link copied to clipboard!');
}

document.getElementById('generate-qr-code-btn').addEventListener('click', function() {
    fetch('{{ route("affiliate.generate-qr-code") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        credentials: 'same-origin'
    })
    .then(response => response.json())
    .then(data => {
        const qrContainer = document.getElementById('qr-code-container');
        qrContainer.innerHTML = `<img src="${data.qr_code_url}" alt="Referral QR Code" class="h-48 w-48">`;
        qrContainer.classList.remove('hidden');
    })
    .catch(error => {
        console.error('Error generating QR code:', error);
        alert('Failed to generate QR code. Please try again.');
    });
});
</script>



<script>
    // Download QR code function
    function downloadQRCode() {
        const qrCodeImg = document.getElementById('referral-qr-code');
        
        // Create a canvas element
        const canvas = document.createElement('canvas');
        const context = canvas.getContext('2d');
        
        // Set canvas dimensions to match QR code
        canvas.width = qrCodeImg.width;
        canvas.height = qrCodeImg.height;
        
        // Draw image to canvas
        context.drawImage(qrCodeImg, 0, 0);
        
        // Create download link
        const downloadLink = document.createElement('a');
        downloadLink.download = 'skillbolt-referral-qr.png';
        
        // Convert canvas to data URL
        downloadLink.href = canvas.toDataURL('image/png');
        
        // Trigger download
        downloadLink.click();
    }
    
    // Copy QR code to clipboard
    function copyQRCodeImage() {
        const qrCodeImg = document.getElementById('referral-qr-code');
        
        // Create a canvas element
        const canvas = document.createElement('canvas');
        const ctx = canvas.getContext('2d');
        
        // Set canvas dimensions
        canvas.width = qrCodeImg.width;
        canvas.height = qrCodeImg.height;
        
        // Draw image to canvas
        ctx.drawImage(qrCodeImg, 0, 0);
        
        // Convert canvas to blob
        canvas.toBlob(function(blob) {
            // Create a ClipboardItem
            const item = new ClipboardItem({ "image/png": blob });
            
            // Copy to clipboard
            navigator.clipboard.write([item]).then(function() {
                alert('QR code copied to clipboard!');
            }, function(err) {
                console.error('Could not copy QR code: ', err);
                alert('Could not copy QR code. Your browser may not support this feature.');
            });
        });
    }
    
    // Fallback for older browsers that don't support the Clipboard API
    function copyQRCodeImageFallback() {
        alert('To copy the QR code, right-click on the image and select "Copy Image"');
    }
    
    // Check if Clipboard API is supported
    if (!navigator.clipboard || !navigator.clipboard.write) {
        // Replace the function with the fallback
        copyQRCodeImage = copyQRCodeImageFallback;
    }
</script>

@endsection