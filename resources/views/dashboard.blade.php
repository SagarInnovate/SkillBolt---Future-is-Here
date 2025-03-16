<!-- resources/views/dashboard.blade.php -->
@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h1 class="text-2xl font-semibold text-gray-900 mb-6">Dashboard</h1>
                
                @if(session('status'))
                <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('status') }}</span>
                </div>
                @endif
                
                <!-- Pre-launch message -->
                <div class="mb-8 bg-indigo-50 border-l-4 border-indigo-500 p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-indigo-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-indigo-700">
                                SkillBolt.dev is currently in pre-launch phase. We'll notify you when we're ready to launch!
                            </p>
                        </div>
                    </div>
                </div>
                
                <!-- User profile summary -->
                <div class="mb-8">
                    <h2 class="text-lg font-medium text-gray-900 mb-4">Your Profile</h2>
                    <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">Name</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ Auth::user()->name }}</dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">Email</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ Auth::user()->email }}</dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">Account Type</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                @if(Auth::user()->isStudent())
                                    Student
                                @elseif(Auth::user()->isCompany())
                                    Company
                                @elseif(Auth::user()->isAdmin())
                                    Administrator
                                @else
                                    User
                                @endif
                            </dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">Joined</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ Auth::user()->created_at->format('F j, Y') }}</dd>
                        </div>
                    </dl>
                </div>
                
                <!-- Referral program section (for students) -->
                @if(Auth::user()->isStudent())
                <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-8">
                    <div class="px-4 py-5 sm:px-6 bg-gray-50">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Referral Program</h3>
                        <p class="mt-1 max-w-2xl text-sm text-gray-500">Share SkillBolt.dev with friends and earn rewards!</p>
                    </div>
                    <div class="border-t border-gray-200 px-4 py-5 sm:p-6">
                        @if(Auth::user()->canAffiliate())
                            <div id="referral-details-loading" class="text-center py-4">
                                <svg class="animate-spin h-5 w-5 text-indigo-500 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <p class="mt-2 text-sm text-gray-500">Loading your referral details...</p>
                            </div>
                            
                            <div id="referral-details" class="hidden">
                                <div class="mb-4">
                                    <label for="referral-link" class="block text-sm font-medium text-gray-700">Your Referral Link</label>
                                    <div class="mt-1 flex rounded-md shadow-sm">
                                        <input type="text" id="referral-link" class="flex-1 min-w-0 block w-full px-3 py-2 rounded-l-md border border-gray-300 bg-gray-50 text-gray-500 sm:text-sm" readonly>
                                        <button type="button" onclick="copyReferralLink()" class="inline-flex items-center px-4 py-2 border border-l-0 border-gray-300 rounded-r-md bg-indigo-50 text-indigo-600 hover:bg-indigo-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:text-sm">
                                            Copy
                                        </button>
                                    </div>
                                </div>
                                
                                <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                                    <div class="bg-indigo-50 rounded-lg overflow-hidden shadow px-4 py-5 sm:p-6">
                                        <dt class="text-sm font-medium text-gray-500 truncate">Your Referrals</dt>
                                        <dd class="mt-1 text-3xl font-semibold text-indigo-600" id="referral-count">0</dd>
                                    </div>
                                    
                                    <div class="bg-green-50 rounded-lg overflow-hidden shadow px-4 py-5 sm:p-6">
                                        <dt class="text-sm font-medium text-gray-500 truncate">Referral Code</dt>
                                        <dd class="mt-1 text-xl font-semibold text-green-600" id="referral-code">-</dd>
                                    </div>
                                    
                                    <div class="bg-purple-50 rounded-lg overflow-hidden shadow px-4 py-5 sm:p-6">
                                        <dt class="text-sm font-medium text-gray-500 truncate">Potential Earnings</dt>
                                        <dd class="mt-1 text-2xl font-semibold text-purple-600">₹<span id="referral-earnings">0</span></dd>
                                    </div>
                                </div>
                            </div>
                            
                            <script>
                                // Fetch referral details on page load
                                document.addEventListener('DOMContentLoaded', function() {
                                    fetchReferralDetails();
                                });
                                
                                // Function to fetch referral details
                                function fetchReferralDetails() {
                                    fetch('{{ route("referral.link") }}')
                                        .then(response => response.json())
                                        .then(data => {
                                            document.getElementById('referral-link').value = data.referral_link;
                                            document.getElementById('referral-code').textContent = data.referral_code;
                                            document.getElementById('referral-count').textContent = data.total_referrals;
                                            document.getElementById('referral-earnings').textContent = data.total_referrals * 100;
                                            
                                            // Show details and hide loading
                                            document.getElementById('referral-details-loading').classList.add('hidden');
                                            document.getElementById('referral-details').classList.remove('hidden');
                                        })
                                        .catch(error => {
                                            console.error('Error fetching referral details:', error);
                                            document.getElementById('referral-details-loading').innerHTML = '<p class="text-red-500">Error loading referral details. Please try again later.</p>';
                                        });
                                }
                                
                                // Function to copy referral link
                                function copyReferralLink() {
                                    const referralLink = document.getElementById('referral-link');
                                    referralLink.select();
                                    document.execCommand('copy');
                                    
                                    // Show copied notification
                                    const button = document.querySelector('[onclick="copyReferralLink()"]');
                                    const originalText = button.textContent;
                                    button.textContent = 'Copied!';
                                    setTimeout(() => {
                                        button.textContent = originalText;
                                    }, 2000);
                                }
                            </script>
                        @else
                            <div class="rounded-md bg-yellow-50 p-4">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium text-yellow-800">Referral Program Not Active</h3>
                                        <div class="mt-2 text-sm text-yellow-700">
                                            <p>You do not have access to the referral program yet. After launch, you'll be able to activate this feature from your dashboard.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                @endif
                
                <!-- Launch reminder -->
                <div class="rounded-md bg-indigo-50 p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-indigo-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3 flex-1 md:flex md:justify-between">
                            <p class="text-sm text-indigo-700">
                                SkillBolt.dev is launching soon! We'll notify you via email when we're live.
                            </p>
                            <p class="mt-3 text-sm md:mt-0 md:ml-6">
                                <a href="#" class="whitespace-nowrap font-medium text-indigo-700 hover:text-indigo-600">Learn more <span aria-hidden="true">&rarr;</span></a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection