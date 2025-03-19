@extends('layouts.app')

@section('content')
<div class="py-12 bg-gray-50">
    <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm rounded-lg">
            <div class="p-6 border-b border-gray-200">
                <h1 class="text-2xl font-bold text-gray-900">Join the SkillBolt Affiliate Program</h1>
                <p class="mt-2 text-gray-600">Earn rewards by referring friends and fellow students to SkillBolt.</p>
            </div>
            
            <div class="p-6">
                <!-- Program Benefits -->
                <div class="mb-10">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Why Join Our Affiliate Program?</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Benefit 1 -->
                        <div class="bg-indigo-50 rounded-lg p-6">
                            <div class="flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white mb-4">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Earn Real Money</h3>
                            <p class="text-gray-600">Earn ₹{{ number_format($commissionRate) }} for every friend who joins SkillBolt through your referral link.</p>
                        </div>
                        
                        <!-- Benefit 2 -->
                        <div class="bg-green-50 rounded-lg p-6">
                            <div class="flex items-center justify-center h-12 w-12 rounded-md bg-green-500 text-white mb-4">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Tier System</h3>
                            <p class="text-gray-600">Unlock higher commission rates and exclusive benefits as you climb our tier system.</p>
                        </div>
                        
                        <!-- Benefit 3 -->
                        <div class="bg-purple-50 rounded-lg p-6">
                            <div class="flex items-center justify-center h-12 w-12 rounded-md bg-purple-500 text-white mb-4">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Earn Achievements</h3>
                            <p class="text-gray-600">Collect special badges and achievements as you refer more friends to showcase your success.</p>
                        </div>
                    </div>
                </div>
                
                <!-- How It Works -->
                <div class="mb-10">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">How It Works</h2>
                    
                    <div class="relative">
                        <div class="absolute inset-0 flex items-center" aria-hidden="true">
                            <div class="w-full border-t border-gray-300"></div>
                        </div>
                        <div class="relative flex justify-between">
                            <!-- Step 1 -->
                            <div class="text-center">
                                <span class="relative flex items-center justify-center h-10 w-10 rounded-full bg-indigo-600 text-white">1</span>
                                <div class="mt-2 text-sm font-medium">Join the program</div>
                            </div>
                            
                            <!-- Step 2 -->
                            <div class="text-center">
                                <span class="relative flex items-center justify-center h-10 w-10 rounded-full bg-indigo-600 text-white">2</span>
                                <div class="mt-2 text-sm font-medium">Share your link</div>
                            </div>
                            
                            <!-- Step 3 -->
                            <div class="text-center">
                                <span class="relative flex items-center justify-center h-10 w-10 rounded-full bg-indigo-600 text-white">3</span>
                                <div class="mt-2 text-sm font-medium">Friends sign up</div>
                            </div>
                            
                            <!-- Step 4 -->
                            <div class="text-center">
                                <span class="relative flex items-center justify-center h-10 w-10 rounded-full bg-indigo-600 text-white">4</span>
                                <div class="mt-2 text-sm font-medium">Earn commissions</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-6 bg-indigo-50 rounded-lg p-6">
                        <p class="text-gray-700">
                            When you join our affiliate program, you'll get a unique referral link to share with friends, classmates, and on social media. For each new user who signs up through your link, you'll earn ₹{{ number_format($commissionRate) }} once they make their first purchase. As you refer more people, you'll climb our tier system, earning bigger bonuses and unlocking exclusive benefits.
                        </p>
                    </div>
                </div>
                
                <!-- Tier System -->
                <div class="mb-10">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Tier System & Benefits</h2>
                    
                    <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-300">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Tier Level</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Referrals Needed</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Bonus Per Referral</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Special Benefits</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                                @foreach($tierRequirements as $tier => $info)
                                    <tr>
                                        <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                                            Tier {{ $tier }} {{ isset($info['name']) ? '- ' . $info['name'] : '' }}
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $info['referrals'] ?? 0 }}</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                            ₹{{ number_format($info['bonus'] ?? 0) }}
                                        </td>
                                        <td class="px-3 py-4 text-sm text-gray-500">
                                            @if(isset($info['benefits']) && is_array($info['benefits']))
                                                <ul class="list-disc pl-5">
                                                    @foreach($info['benefits'] as $benefit)
                                                        <li>{{ $benefit }}</li>
                                                    @endforeach
                                                </ul>
                                            @else
                                                -
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <!-- Join Now -->
                <div class="mt-10 sm:mt-12 bg-gray-50 p-6 rounded-lg">
                    <div class="md:flex md:items-center md:justify-between">
                        <div>
                            <h3 class="text-xl font-medium leading-6 text-gray-900">Ready to start earning?</h3>
                            <p class="mt-2 max-w-xl text-sm text-gray-500">Join our affiliate program today and start earning rewards for sharing SkillBolt with your network.</p>
                        </div>
                        <div class="mt-4 md:mt-0">
                            <form action="{{ route('affiliate.process-join') }}" method="POST">
                                @csrf
                                <button type="submit" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Join Affiliate Program
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                
                <!-- FAQ Section -->
                <div class="mt-10">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Frequently Asked Questions</h2>
                    
                    <div class="space-y-4">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">How do I get paid?</h3>
                            <p class="mt-1 text-gray-600">Once your balance reaches ₹{{ number_format($minPayoutThreshold ?? 1000) }}, you can request a payout through bank transfer, UPI, or wallet credit.</p>
                        </div>
                        
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">When do I earn my commission?</h3>
                            <p class="mt-1 text-gray-600">You earn commission when your referred user signs up and makes their first purchase on SkillBolt.</p>
                        </div>
                        
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">How do I track my referrals?</h3>
                            <p class="mt-1 text-gray-600">Once you join the affiliate program, you'll get access to a comprehensive dashboard where you can track all your referrals, commissions, and achievements.</p>
                        </div>
                        
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Is there a limit to how much I can earn?</h3>
                            <p class="mt-1 text-gray-600">No! There's no cap on your earnings. The more people you refer, the more you earn.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection