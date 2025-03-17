<!-- resources/views/auth/verification-success.blade.php -->
@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div>
            <img class="mx-auto h-12 w-auto" src="{{ asset('images/skillbolt-logo.svg') }}" alt="SkillBolt.dev">
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                {{ $alreadyVerified ? 'Email Already Verified' : 'Email Verified Successfully' }}
            </h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                {{ $alreadyVerified ? 'Your email address has already been verified.' : 'Thank you for verifying your email address.' }}
            </p>
        </div>

        <div class="rounded-md bg-green-50 p-4 mb-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-green-800">
                        {{ $alreadyVerified ? 'Your account is already active and your email is verified.' : 'Your email has been successfully verified. Your account is now active.' }}
                    </p>
                </div>
            </div>
        </div>

        <div class="mt-8 text-center">
            <p class="text-sm text-gray-600 mb-4">
                You are currently not logged in. Please login to access your account.
            </p>
            
            <a href="{{ route('login', ['email' => $email]) }}" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                    <svg class="h-5 w-5 text-indigo-500 group-hover:text-indigo-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                    </svg>
                </span>
                Log In to Your Account
            </a>
        </div>
        
        <div class="mt-6 text-center">
            <a href="{{ route('home') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">
                Return to Home Page
            </a>
        </div>
    </div>
</div>
@endsection