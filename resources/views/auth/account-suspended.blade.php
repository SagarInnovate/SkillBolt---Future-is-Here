@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4">
    <div class="bg-white p-8 rounded-lg shadow-lg max-w-lg w-full mx-auto text-center transform transition-all duration-500 ease-in-out opacity-0 animate-fade-in">
        
        <!-- Suspended Icon -->
        <div class="flex justify-center">
            <svg class="w-20 h-20 text-red-500 animate-pulse" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636a9 9 0 11-12.728 12.728 9 9 0 0112.728-12.728zM12 8v4m0 4h.01"></path>
            </svg>
        </div>
        
        <!-- Title -->
        <h1 class="text-3xl font-bold text-gray-900 mt-6">Your Account Has Been Suspended</h1>
        
        <!-- Description -->
        <p class="text-gray-600 mt-4 leading-relaxed">
            Your account has been suspended due to a violation of our terms or an issue that requires review.
            If you believe this is a mistake, please contact our support team.
        </p>

        <!-- Support Button -->
        <div class="mt-6">
            <a href="mailto:{{ config('app.support_email', 'support@yourwebsite.com') }}"
               class="bg-red-500 hover:bg-red-600 text-white font-semibold px-6 py-3 rounded-lg transition transform hover:scale-105 shadow-lg">
                Contact Support
            </a>
        </div>

        <!-- Back to Login -->
        <div class="mt-4">
            <a href="{{ route('login') }}"
               class="text-blue-500 hover:text-blue-600 font-medium text-sm transition">
                Go back to Login
            </a>
        </div>
    </div>
</div>

<!-- Smooth Fade-In Animation -->
<style>
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
.animate-fade-in {
    animation: fadeIn 0.8s ease-out forwards;
}
</style>
@endsection
