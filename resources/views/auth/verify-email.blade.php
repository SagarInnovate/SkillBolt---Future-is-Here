<!-- resources/views/auth/verify-email.blade.php -->
@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div>
            <img class="mx-auto h-12 w-auto" src="{{ asset('images/skillbolt-logo.svg') }}" alt="SkillBolt.dev">
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                Verify your email
            </h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                Please check your email for verification link
            </p>
        </div>

        @if(session('resent'))
        <div class="rounded-md bg-green-50 p-4 mb-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-green-800">
                        A fresh verification link has been sent to your email address.
                    </p>
                </div>
            </div>
        </div>
        @endif

        @if(session('error'))
        <div class="rounded-md bg-red-50 p-4 mb-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-red-800">
                        {{ session('error') }}
                    </p>
                </div>
            </div>
        </div>
        @endif

        <div class="rounded-md bg-yellow-50 p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-yellow-800">
                        Verification Required
                    </h3>
                    <div class="mt-2 text-sm text-yellow-700">
                        <p>
                            Before proceeding, please check your email for a verification link. The link is valid for 10 minutes.
                            @if(isset($attemptsLeft) && $attemptsLeft < 5)
                                <br><br><strong>Note:</strong> You have {{ $attemptsLeft }} verification attempts remaining.
                                Too many attempts may result in your account being temporarily suspended.
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <form class="mt-8 space-y-6" method="POST" action="{{ route('verification.resend') }}">
            @csrf
            <div>
             
                @if($cooldownActive)
                    <button type="button" disabled class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-gray-400 cursor-not-allowed">
                        Resend Verification Email ({{ (int)$remainingTime }}s)
                    </button>
                    
                    <script>
                        // Countdown timer
                        document.addEventListener('DOMContentLoaded', function() {
                            let timerButton = document.querySelector('button[disabled]');
                            let remainingTime = {{ (int)$remainingTime }};
                            
                            const countdownInterval = setInterval(function() {
                                remainingTime--;
                                timerButton.innerText = `Resend Verification Email (${remainingTime}s)`;
                                
                                if (remainingTime <= 0) {
                                    clearInterval(countdownInterval);
                                    window.location.reload();
                                }
                            }, 1000);
                        });
                    </script>
                @else
                    <button type="submit" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Resend Verification Email
                    </button>
                @endif
            </div>
        </form>
    </div>
</div>
@endsection