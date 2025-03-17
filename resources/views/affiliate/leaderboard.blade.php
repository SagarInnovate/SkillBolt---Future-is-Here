{{-- resources/views/affiliate/leaderboard.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-semibold text-gray-900">Affiliate Leaderboard</h1>
                    <a href="{{ route('affiliate.dashboard') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <svg class="h-5 w-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z"></path>
                        </svg>
                        Back to Dashboard
                    </a>
                </div>

                <!-- Your Ranking Section -->
                <div class="bg-indigo-50 rounded-lg p-4 shadow-sm border border-indigo-100 mb-8">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                        <div>
                            <h2 class="text-lg font-medium text-indigo-800">Your Current Ranking</h2>
                            <p class="text-indigo-600">Keep referring to improve your position!</p>
                        </div>
                        <div class="mt-4 md:mt-0">
                            <div class="bg-white shadow-md rounded-lg p-6 text-center">
                                <span class="text-5xl font-bold text-indigo-700">#{{ $userRank }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Top 3 Affiliates -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                    @if(isset($leaderboard[1]))
                    <!-- 2nd Place -->
                    <div class="bg-gray-50 rounded-lg shadow-sm border border-gray-200 p-4 text-center {{ $leaderboard[1]['is_current_user'] ? 'ring-2 ring-indigo-500' : '' }}">
                        <div class="inline-flex items-center justify-center h-16 w-16 rounded-full bg-gray-200 mb-4">
                            <svg class="h-8 w-8 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <div class="text-lg font-semibold">#2</div>
                        <div class="text-lg font-medium mb-2">{{ $leaderboard[1]['name'] }}</div>
                        <div class="text-sm text-gray-500">{{ $leaderboard[1]['referrals'] }} Referrals</div>
                        <div class="text-sm text-gray-500">₹{{ number_format($leaderboard[1]['earnings'], 2) }} Earned</div>
                        @if($leaderboard[1]['is_current_user'])
                            <span class="mt-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                That's You!
                            </span>
                        @endif
                    </div>
                    @endif

                    @if(isset($leaderboard[0]))
                    <!-- 1st Place -->
                    <div class="bg-amber-50 rounded-lg shadow-sm border border-amber-200 p-4 text-center transform md:-translate-y-4 {{ $leaderboard[0]['is_current_user'] ? 'ring-2 ring-indigo-500' : '' }}">
                        <div class="inline-flex items-center justify-center h-20 w-20 rounded-full bg-amber-200 mb-4 relative">
                            <svg class="h-10 w-10 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            <svg class="absolute -top-2 -right-2 h-8 w-8 text-amber-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="text-2xl font-bold text-amber-800">#1</div>
                        <div class="text-xl font-medium mb-2">{{ $leaderboard[0]['name'] }}</div>
                        <div class="text-amber-700 font-medium">{{ $leaderboard[0]['referrals'] }} Referrals</div>
                        <div class="text-amber-700 font-medium">₹{{ number_format($leaderboard[0]['earnings'], 2) }} Earned</div>
                        @if($leaderboard[0]['is_current_user'])
                            <span class="mt-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                That's You!
                            </span>
                        @endif
                    </div>
                    @endif

                    @if(isset($leaderboard[2]))
                    <!-- 3rd Place -->
                    <div class="bg-orange-50 rounded-lg shadow-sm border border-orange-200 p-4 text-center {{ $leaderboard[2]['is_current_user'] ? 'ring-2 ring-indigo-500' : '' }}">
                        <div class="inline-flex items-center justify-center h-16 w-16 rounded-full bg-orange-200 mb-4">
                            <svg class="h-8 w-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <div class="text-lg font-semibold">#3</div>
                        <div class="text-lg font-medium mb-2">{{ $leaderboard[2]['name'] }}</div>
                        <div class="text-sm text-gray-500">{{ $leaderboard[2]['referrals'] }} Referrals</div>
                        <div class="text-sm text-gray-500">₹{{ number_format($leaderboard[2]['earnings'], 2) }} Earned</div>
                        @if($leaderboard[2]['is_current_user'])
                            <span class="mt-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                That's You!
                            </span>
                        @endif
                    </div>
                    @endif
                </div>

                <!-- Full Leaderboard -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                    <div class="p-4 border-b border-gray-200">
                        <h2 class="text-lg font-medium text-gray-900">Full Leaderboard</h2>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Rank
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Name
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Tier
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Referrals
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Earnings
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($leaderboard as $item)
                                <tr class="{{ $item['is_current_user'] ? 'bg-indigo-50' : '' }}">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium {{ $item['rank'] <= 3 ? 'text-indigo-600' : 'text-gray-900' }}">
                                            #{{ $item['rank'] }}
                                            @if($item['rank'] == 1)
                                                <span class="ml-1 text-amber-500">🏆</span>
                                            @elseif($item['rank'] == 2)
                                                <span class="ml-1 text-gray-500">🥈</span>
                                            @elseif($item['rank'] == 3)
                                                <span class="ml-1 text-orange-500">🥉</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $item['name'] }}
                                            @if($item['is_current_user'])
                                                <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                                    You
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">Tier {{ $item['tier'] }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $item['referrals'] }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">₹{{ number_format($item['earnings'], 2) }}</div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Prizes and Benefits -->
                <div class="mt-8 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-lg shadow-lg text-white p-6">
                    <h2 class="text-xl font-bold mb-4">🏆 Leaderboard Rewards</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="bg-white bg-opacity-20 rounded-lg p-4">
                            <h3 class="font-semibold text-lg mb-2">🥇 1st Place</h3>
                            <ul class="space-y-2 text-sm">
                                <li class="flex items-center">
                                    <svg class="h-5 w-5 mr-1.5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    Extra ₹500 bonus per referral
                                </li>
                                <li class="flex items-center">
                                    <svg class="h-5 w-5 mr-1.5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    Free premium project access
                                </li>
                                <li class="flex items-center">
                                    <svg class="h-5 w-5 mr-1.5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    Exclusive badge on profile
                                </li>
                            </ul>
                        </div>
                        <div class="bg-white bg-opacity-20 rounded-lg p-4">
                            <h3 class="font-semibold text-lg mb-2">🥈 2nd Place</h3>
                            <ul class="space-y-2 text-sm">
                                <li class="flex items-center">
                                    <svg class="h-5 w-5 mr-1.5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    Extra ₹300 bonus per referral
                                </li>
                                <li class="flex items-center">
                                    <svg class="h-5 w-5 mr-1.5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    50% discount on premium projects
                                </li>
                                <li class="flex items-center">
                                    <svg class="h-5 w-5 mr-1.5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    Special badge on profile
                                </li>
                            </ul>
                        </div>
                        <div class="bg-white bg-opacity-20 rounded-lg p-4">
                            <h3 class="font-semibold text-lg mb-2">🥉 3rd Place</h3>
                            <ul class="space-y-2 text-sm">
                                <li class="flex items-center">
                                    <svg class="h-5 w-5 mr-1.5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    Extra ₹200 bonus per referral
                                </li>
                                <li class="flex items-center">
                                    <svg class="h-5 w-5 mr-1.5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    25% discount on premium projects
                                </li>
                                <li class="flex items-center">
                                    <svg class="h-5 w-5 mr-1.5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    Bronze badge on profile
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- How to Improve Ranking -->
                <div class="mt-8 bg-white rounded-lg shadow-sm border border-gray-200">
                    <div class="p-4 border-b border-gray-200">
                        <h2 class="text-lg font-medium text-gray-900">How to Improve Your Ranking</h2>
                    </div>
                    <div class="p-4">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="bg-gray-50 rounded-lg p-4">
                                <div class="flex items-start space-x-3">
                                    <div class="flex-shrink-0">
                                        <svg class="h-6 w-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="font-medium text-gray-900">Share on Social Media</h3>
                                        <p class="mt-1 text-sm text-gray-500">
                                            Share your referral link on social media platforms to reach more potential users.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-gray-50 rounded-lg p-4">
                                <div class="flex items-start space-x-3">
                                    <div class="flex-shrink-0">
                                        <svg class="h-6 w-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="font-medium text-gray-900">Explain the Benefits</h3>
                                        <p class="mt-1 text-sm text-gray-500">
                                            Tell friends about the benefits they'll get when signing up through your link.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-gray-50 rounded-lg p-4">
                                <div class="flex items-start space-x-3">
                                    <div class="flex-shrink-0">
                                        <svg class="h-6 w-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="font-medium text-gray-900">Share Success Stories</h3>
                                        <p class="mt-1 text-sm text-gray-500">
                                            Share your positive experiences with SkillBolt to encourage others to join.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection