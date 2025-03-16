<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SkillBolt.dev - AI-Powered Final Year Project Marketplace</title>
    <meta name="description" content="India's first AI-powered final-year project marketplace with student-to-student sales, AI-generated reports, and job opportunities">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .hero-gradient {
            background: linear-gradient(135deg, #4f46e5 0%, #7e3af2 100%);
        }
        .feature-card {
            transition: all 0.3s ease;
        }
        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }
        .countdown-item {
            background: rgba(79, 70, 229, 0.1);
            border-radius: 8px;
            padding: 12px 16px;
            min-width: 80px;
            text-align: center;
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-900 antialiased">
    <!-- Nav -->
    @if(session('error'))
    <div class="rounded-md bg-red-50 p-4 mb-6">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
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
    
    <nav class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <img src="{{ asset('images/skillbolt-logo.svg') }}" alt="SkillBolt.dev" class="h-8 w-auto">
                    <span class="ml-2 font-bold text-indigo-600 text-xl">SkillBolt.dev</span>
                </div>
                <div class="flex items-center">
                    <a href="#waitlist" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Join Waitlist
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero -->
    <div class="hero-gradient">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-24">
            <div class="lg:grid lg:grid-cols-12 lg:gap-8">
                <div class="sm:text-center md:max-w-2xl md:mx-auto lg:col-span-6 lg:text-left">
                    <h1 class="text-4xl tracking-tight font-extrabold text-white sm:text-5xl md:text-6xl lg:leading-tight">
                        <span class="block">Final Year Projects</span>
                        <span class="block text-indigo-200">Supercharged With AI</span>
                    </h1>
                    <p class="mt-4 text-lg text-indigo-100 sm:mt-5 lg:mt-6">
                        India's first AI-powered marketplace where engineering students can buy, sell, and learn from final-year software projects, with built-in tools for customization and documentation.
                    </p>
                    
                    <div class="mt-8 sm:mt-12">
                        <p class="text-base font-medium text-indigo-200">Launching Soon</p>
                        <div class="flex flex-wrap gap-3 mt-3 sm:justify-center lg:justify-start">
                            <div class="countdown-item">
                                <span class="block text-2xl font-bold text-indigo-600">30</span>
                                <span class="block text-xs text-indigo-500">DAYS</span>
                            </div>
                            <div class="countdown-item">
                                <span class="block text-2xl font-bold text-indigo-600">12</span>
                                <span class="block text-xs text-indigo-500">HOURS</span>
                            </div>
                            <div class="countdown-item">
                                <span class="block text-2xl font-bold text-indigo-600">45</span>
                                <span class="block text-xs text-indigo-500">MINUTES</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-8 sm:mt-12 sm:flex sm:justify-center lg:justify-start">
                        <div class="rounded-md shadow">
                            <a href="#waitlist" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-indigo-600 bg-white hover:bg-gray-50 md:py-4 md:text-lg md:px-10">
                                Get Early Access
                            </a>
                        </div>
                        <div class="mt-3 sm:mt-0 sm:ml-3">
                            <a href="#features" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-500 bg-opacity-60 hover:bg-opacity-70 md:py-4 md:text-lg md:px-10">
                                Explore Features
                            </a>
                        </div>
                    </div>
                </div>
                <div class="mt-12 relative sm:max-w-lg sm:mx-auto lg:mt-0 lg:max-w-none lg:mx-0 lg:col-span-6 lg:flex lg:items-center">
                    <div class="relative mx-auto w-full rounded-lg shadow-lg lg:max-w-md">
                        <div class="relative block w-full bg-white rounded-lg overflow-hidden">
                            <img class="w-full" src="{{ asset('images/hero-dashboard.png') }}" alt="SkillBolt Dashboard Preview">
                            <div class="absolute inset-0 flex items-center justify-center">
                                <svg class="h-20 w-20 text-indigo-500" fill="currentColor" viewBox="0 0 84 84">
                                    <circle opacity="0.9" cx="42" cy="42" r="42" fill="white"/>
                                    <path d="M55 41.5L36 29v25l19-12.5z" fill="currentColor"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats -->
    <div class="bg-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-4">
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <dt class="text-sm font-medium text-gray-500 truncate">
                            Projects Available
                        </dt>
                        <dd class="mt-1 text-3xl font-semibold text-indigo-600">
                            1,000+
                        </dd>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <dt class="text-sm font-medium text-gray-500 truncate">
                            Students Registered
                        </dt>
                        <dd class="mt-1 text-3xl font-semibold text-indigo-600">
                            10,000+
                        </dd>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <dt class="text-sm font-medium text-gray-500 truncate">
                            Partner Universities
                        </dt>
                        <dd class="mt-1 text-3xl font-semibold text-indigo-600">
                            50+
                        </dd>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <dt class="text-sm font-medium text-gray-500 truncate">
                            Companies Hiring
                        </dt>
                        <dd class="mt-1 text-3xl font-semibold text-indigo-600">
                            120+
                        </dd>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Features -->
    <div id="features" class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:text-center">
                <h2 class="text-base text-indigo-600 font-semibold tracking-wide uppercase">Features</h2>
                <p class="mt-2 text-3xl font-extrabold text-gray-900 sm:text-4xl">
                    Everything you need to succeed
                </p>
                <p class="mt-4 max-w-2xl text-xl text-gray-500 lg:mx-auto">
                    Our AI-powered platform helps students create, customize, and learn from final year projects.
                </p>
            </div>

            <div class="mt-16">
                <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                    <!-- Feature 1 -->
                    <div class="feature-card pt-6">
                        <div class="flow-root bg-white rounded-lg px-6 pb-8 h-full shadow">
                            <div class="-mt-6">
                                <div>
                                    <span class="inline-flex items-center justify-center p-3 bg-indigo-500 rounded-md shadow-lg">
                                        <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                                        </svg>
                                    </span>
                                </div>
                                <h3 class="mt-8 text-lg font-medium text-gray-900 tracking-tight">AI Project Customization</h3>
                                <p class="mt-5 text-base text-gray-500">
                                    Our AI suggests code modifications to make projects unique, helping you understand the logic while ensuring originality.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Feature 2 -->
                    <div class="feature-card pt-6">
                        <div class="flow-root bg-white rounded-lg px-6 pb-8 h-full shadow">
                            <div class="-mt-6">
                                <div>
                                    <span class="inline-flex items-center justify-center p-3 bg-indigo-500 rounded-md shadow-lg">
                                        <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 19 7.5 19s3.332-.477 4.5-1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13c-1.168-.776-2.754-1.253-4.5-1.253-1.746 0-3.332.477-4.5 1.253" />
                                        </svg>
                                    </span>
                                </div>
                                <h3 class="mt-8 text-lg font-medium text-gray-900 tracking-tight">Auto-Generated Documentation</h3>
                                <p class="mt-5 text-base text-gray-500">
                                    Our AI generates professional reports, presentations, and documentation with explanations of code logic.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Feature 3 -->
                    <div class="feature-card pt-6">
                        <div class="flow-root bg-white rounded-lg px-6 pb-8 h-full shadow">
                            <div class="-mt-6">
                                <div>
                                    <span class="inline-flex items-center justify-center p-3 bg-indigo-500 rounded-md shadow-lg">
                                        <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                        </svg>
                                    </span>
                                </div>
                                <h3 class="mt-8 text-lg font-medium text-gray-900 tracking-tight">Project Marketplace</h3>
                                <p class="mt-5 text-base text-gray-500">
                                    Browse, buy, and sell projects with personalized recommendations based on your academic interests.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Feature 4 -->
                    <div class="feature-card pt-6">
                        <div class="flow-root bg-white rounded-lg px-6 pb-8 h-full shadow">
                            <div class="-mt-6">
                                <div>
                                    <span class="inline-flex items-center justify-center p-3 bg-indigo-500 rounded-md shadow-lg">
                                        <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                    </span>
                                </div>
                                <h3 class="mt-8 text-lg font-medium text-gray-900 tracking-tight">Job & Internship Connect</h3>
                                <p class="mt-5 text-base text-gray-500">
                                    Companies can view your projects and offer internships or jobs based on your demonstrated skills.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Feature 5 -->
                    <div class="feature-card pt-6">
                        <div class="flow-root bg-white rounded-lg px-6 pb-8 h-full shadow">
                            <div class="-mt-6">
                                <div>
                                    <span class="inline-flex items-center justify-center p-3 bg-indigo-500 rounded-md shadow-lg">
                                        <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                        </svg>
                                    </span>
                                </div>
                                <h3 class="mt-8 text-lg font-medium text-gray-900 tracking-tight">Live Demo & Code Preview</h3>
                                <p class="mt-5 text-base text-gray-500">
                                    Preview projects in real-time before purchasing, with screenshots, videos, and live demos for web projects.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Feature 6 -->
                    <div class="feature-card pt-6">
                        <div class="flow-root bg-white rounded-lg px-6 pb-8 h-full shadow">
                            <div class="-mt-6">
                                <div>
                                    <span class="inline-flex items-center justify-center p-3 bg-indigo-500 rounded-md shadow-lg">
                                        <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </span>
                                </div>
                                <h3 class="mt-8 text-lg font-medium text-gray-900 tracking-tight">Student-to-Student Selling</h3>
                                <p class="mt-5 text-base text-gray-500">
                                    Sell your completed projects to other students with commission-free initial sales and our affiliate program.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- How It Works -->
    <div class="bg-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:text-center">
                <h2 class="text-base text-indigo-600 font-semibold tracking-wide uppercase">How It Works</h2>
                <p class="mt-2 text-3xl font-extrabold text-gray-900 sm:text-4xl">
                    Simple process, powerful results
                </p>
                <p class="mt-4 max-w-2xl text-xl text-gray-500 lg:mx-auto">
                    Whether you're buying, selling, or learning - we've streamlined the experience for you.
                </p>
            </div>

            <div class="mt-16">
                <div class="relative">
                    <!-- Steps connector line -->
                    <div class="absolute inset-0 flex items-center" aria-hidden="true">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    
                    <!-- Steps -->
                    <div class="relative flex justify-between">
                        <!-- Step 1 -->
                        <div class="relative">
                            <div class="h-12 w-12 rounded-full bg-indigo-600 flex items-center justify-center">
                                <span class="text-white font-medium">1</span>
                            </div>
                            <div class="mt-4">
                                <h3 class="text-lg font-medium text-gray-900">Browse Projects</h3>
                                <p class="mt-2 text-sm text-gray-500 max-w-xs">
                                    Explore our marketplace of student projects filterable by technology, complexity, and more.
                                </p>
                            </div>
                        </div>

                        <!-- Step 2 -->
                        <div class="relative">
                            <div class="h-12 w-12 rounded-full bg-indigo-600 flex items-center justify-center">
                                <span class="text-white font-medium">2</span>
                            </div>
                            <div class="mt-4">
                                <h3 class="text-lg font-medium text-gray-900">Customize with AI</h3>
                                <p class="mt-2 text-sm text-gray-500 max-w-xs">
                                    Personalize the project with our AI tools to ensure uniqueness and understanding.
                                </p>
                            </div>
                        </div>

                        <!-- Step 3 -->
                        <div class="relative">
                            <div class="h-12 w-12 rounded-full bg-indigo-600 flex items-center justify-center">
                                <span class="text-white font-medium">3</span>
                            </div>
                            <div class="mt-4">
                                <h3 class="text-lg font-medium text-gray-900">Generate Documentation</h3>
                                <p class="mt-2 text-sm text-gray-500 max-w-xs">
                                    Create professional reports and presentations with our AI documentation tools.
                                </p>
                            </div>
                        </div>

                        <!-- Step 4 -->
                        <div class="relative">
                            <div class="h-12 w-12 rounded-full bg-indigo-600 flex items-center justify-center">
                                <span class="text-white font-medium">4</span>
                            </div>
                            <div class="mt-4">
                                <h3 class="text-lg font-medium text-gray-900">Present & Connect</h3>
                                <p class="mt-2 text-sm text-gray-500 max-w-xs">
                                    Submit your project and connect with companies looking for talent.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Testimonials -->
    <div class="bg-gray-50 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:text-center">
                <h2 class="text-base text-indigo-600 font-semibold tracking-wide uppercase">Testimonials</h2>
                <p class="mt-2 text-3xl font-extrabold text-gray-900 sm:text-4xl">
                    What students are saying
                </p>
            </div>

            <div class="mt-16 grid gap-8 lg:grid-cols-3">
                <!-- Testimonial 1 -->
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <div class="px-6 py-8">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10 rounded-full bg-indigo-500 flex items-center justify-center">
                                <span class="text-white font-medium">RS</span>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-medium text-gray-900">Rahul Singh</h3>
                                <p class="text-sm text-gray-500">Computer Science, Delhi University</p>
                            </div>
                        </div>
                        <div class="mt-4">
                            <p class="text-gray-600">"The AI customization feature helped me understand complex algorithms and adapt the project to my specific requirements. Saved me weeks of work!"</p>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 2 -->
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <div class="px-6 py-8">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10 rounded-full bg-indigo-500 flex items-center justify-center">
                                <span class="text-white font-medium">AP</span>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-medium text-gray-900">Ankita Patel</h3>
                                <p class="text-sm text-gray-500">Electronics Engineering, IIT Bombay</p>
                            </div>
                        </div>
                        <div class="mt-4">
                            <p class="text-gray-600">"The documentation generator created a professional report and presentation that impressed my professors. I also got an internship through the job connect feature!"</p>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 3 -->
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <div class="px-6 py-8">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10 rounded-full bg-indigo-500 flex items-center justify-center">
                                <span class="text-white font-medium">VK</span>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-medium text-gray-900">Vijay Kumar</h3>
                                <p class="text-sm text-gray-500">Information Technology, VIT</p>
                            </div>
                        </div>
                        <div class="mt-4">
                            <p class="text-gray-600">"I sold my blockchain project to 12 students and earned ₹18,000! The platform made it easy to showcase my work and connect with buyers."</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Waitlist Section -->
    <div id="waitlist" class="bg-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:text-center">
                <h2 class="text-base text-indigo-600 font-semibold tracking-wide uppercase">Join Waitlist</h2>
                <p class="mt-2 text-3xl font-extrabold text-gray-900 sm:text-4xl">
                    Be the first to access SkillBolt.dev
                </p>
                <p class="mt-4 max-w-2xl text-xl text-gray-500 lg:mx-auto">
                    Join our waitlist to get early access and exclusive perks when we launch.
                </p>
            </div>

            <div class="mt-12 max-w-lg mx-auto">
                <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                    <div class="px-6 py-8">
                        @if(session('success'))
                        <div class="rounded-md bg-green-50 p-4 mb-6">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-green-800">
                                        {{ session('success') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        @endif
                        
                        <form action="{{ route('waitlist.store') }}" method="POST" class="space-y-6">
                            @csrf
                            
                            <!-- Hidden referral code field -->
                            @if(request()->has('ref'))
                                <input type="hidden" name="referral_code" value="{{ request('ref') }}">
                            @endif
                            
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                                <div class="mt-1">
                                    <input type="text" name="name" id="name" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="Your name" value="{{ old('name') }}">
                                    @error('name')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">Email address</label>
                                <div class="mt-1">
                                    <input type="email" name="email" id="email" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="you@example.com" required value="{{ old('email') }}">
                                    @error('email')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            
                            <div>
                                <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Join Waitlist
                                </button>
                            </div>
                        </form>
                        
                        <!-- Referral entry -->
                        <div class="mt-6 pt-6 border-t border-gray-200">
                            <div class="flex items-center justify-between">
                                <p class="text-sm text-gray-500">Have a referral code?</p>
                                <button id="show-referral-btn" class="text-sm font-medium text-indigo-600 hover:text-indigo-500" onclick="showReferralInput()">Enter it here</button>
                            </div>
                            
                            <div id="referral-input" class="hidden mt-4">
                                <div class="flex items-center">
                                    <input type="text" id="manual-referral" placeholder="Enter referral code" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md mr-2">
                                    <button onclick="applyReferralCode()" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Apply
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Referral benefits -->
            <div class="mt-16">
                <div class="lg:text-center">
                    <h3 class="text-xl font-bold text-gray-900">Refer Friends & Earn Rewards</h3>
                    <p class="mt-2 text-lg text-gray-500">Share your referral link and earn ₹100 for each friend who joins</p>
                </div>
                
                <div class="mt-8 grid grid-cols-1 gap-5 sm:grid-cols-3">
                    <div class="bg-white overflow-hidden shadow rounded-lg">
                        <div class="px-4 py-5 sm:p-6 text-center">
                            <div class="inline-flex items-center justify-center h-12 w-12 rounded-md bg-indigo-100 text-indigo-600 mb-4">
                                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900">₹100 per Referral</h3>
                            <p class="mt-2 text-sm text-gray-500">
                                Earn cash rewards for every friend who joins through your link
                            </p>
                        </div>
                    </div>
                    
                    <div class="bg-white overflow-hidden shadow rounded-lg">
                        <div class="px-4 py-5 sm:p-6 text-center">
                            <div class="inline-flex items-center justify-center h-12 w-12 rounded-md bg-indigo-100 text-indigo-600 mb-4">
                                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900">Early Access</h3>
                            <p class="mt-2 text-sm text-gray-500">
                                Top referrers get priority access to the platform before others
                            </p>
                        </div>
                    </div>
                    
                    <div class="bg-white overflow-hidden shadow rounded-lg">
                        <div class="px-4 py-5 sm:p-6 text-center">
                            <div class="inline-flex items-center justify-center h-12 w-12 rounded-md bg-indigo-100 text-indigo-600 mb-4">
                                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900">Free Projects</h3>
                            <p class="mt-2 text-sm text-gray-500">
                                Refer 5+ friends and get premium projects for free
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- FAQ Section -->
    <div class="bg-gray-50 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:text-center">
                <h2 class="text-base text-indigo-600 font-semibold tracking-wide uppercase">FAQ</h2>
                <p class="mt-2 text-3xl font-extrabold text-gray-900 sm:text-4xl">
                    Frequently asked questions
                </p>
                <p class="mt-4 max-w-2xl text-xl text-gray-500 lg:mx-auto">
                    Everything you need to know about SkillBolt.dev
                </p>
            </div>

            <div class="mt-12">
                <dl class="space-y-10 md:space-y-0 md:grid md:grid-cols-2 md:gap-x-8 md:gap-y-10">
                    <div>
                        <dt class="text-lg leading-6 font-medium text-gray-900">
                            Is this platform only for final year students?
                        </dt>
                        <dd class="mt-2 text-base text-gray-500">
                            While our primary focus is on final year projects, students from any year can use our platform to buy projects, learn from them, and even sell their own work.
                        </dd>
                    </div>
                    <div>
                        <dt class="text-lg leading-6 font-medium text-gray-900">
                            How does the AI customization work?
                        </dt>
                        <dd class="mt-2 text-base text-gray-500">
                            Our AI analyzes the project code and suggests modifications to make it unique while preserving functionality. It also explains the logic behind each component to enhance your understanding.
                        </dd>
                    </div>
                    <div>
                        <dt class="text-lg leading-6 font-medium text-gray-900">
                            What's the pricing model?
                        </dt>
                        <dd class="mt-2 text-base text-gray-500">
                            Project prices vary based on complexity, but typically range from ₹1,500 to ₹15,000. We also offer subscription plans for unlimited access to certain project categories.
                        </dd>
                    </div>
                    <div>
                        <dt class="text-lg leading-6 font-medium text-gray-900">
                            Can I sell my own projects?
                        </dt>
                        <dd class="mt-2 text-base text-gray-500">
                            Absolutely! Student-to-student selling is a core feature. Your first 5 sales are commission-free, and verified sellers get premium visibility on the platform.
                        </dd>
                    </div>
                    <div>
                        <dt class="text-lg leading-6 font-medium text-gray-900">
                            Is there a plagiarism check?
                        </dt>
                        <dd class="mt-2 text-base text-gray-500">
                            Yes, our platform includes a plagiarism checker to ensure originality before submission. Additionally, our AI modification tools help make each project unique.
                        </dd>
                    </div>
                    <div>
                        <dt class="text-lg leading-6 font-medium text-gray-900">
                            When are you launching?
                        </dt>
                        <dd class="mt-2 text-base text-gray-500">
                            We're launching in approximately 30 days. Join our waitlist to be notified and get early access when we go live!
                        </dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>
    
    <!-- CTA Section -->
    <div class="bg-indigo-700">
        <div class="max-w-2xl mx-auto text-center py-16 px-4 sm:py-20 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-extrabold text-white sm:text-4xl">
                <span class="block">Ready to transform your final year project?</span>
            </h2>
            <p class="mt-4 text-lg leading-6 text-indigo-200">
                Join our waitlist today and be the first to experience the future of project development.
            </p>
            <a href="#waitlist" class="mt-8 w-full inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-indigo-600 bg-white hover:bg-indigo-50 sm:w-auto">
                Join Waitlist
            </a>
        </div>
    </div>
    
    <!-- Footer -->
    <footer class="bg-white">
        <div class="max-w-7xl mx-auto py-12 px-4 overflow-hidden sm:px-6 lg:px-8">
            <nav class="-mx-5 -my-2 flex flex-wrap justify-center" aria-label="Footer">
                <div class="px-5 py-2">
                    <a href="#" class="text-base text-gray-500 hover:text-gray-900">
                        About
                    </a>
                </div>
                <div class="px-5 py-2">
                    <a href="#" class="text-base text-gray-500 hover:text-gray-900">
                        Features
                    </a>
                </div>
                <div class="px-5 py-2">
                    <a href="#" class="text-base text-gray-500 hover:text-gray-900">
                        Pricing
                    </a>
                </div>
                <div class="px-5 py-2">
                    <a href="{{ route('terms') }}" class="text-base text-gray-500 hover:text-gray-900">
                        Terms
                    </a>
                </div>
                <div class="px-5 py-2">
                    <a href="{{ route('privacy') }}" class="text-base text-gray-500 hover:text-gray-900">
                        Privacy
                    </a>
                </div>
                <div class="px-5 py-2">
                    <a href="#" class="text-base text-gray-500 hover:text-gray-900">
                        Contact
                    </a>
                </div>
            </nav>
            <div class="mt-8 flex justify-center space-x-6">
                <a href="#" class="text-gray-400 hover:text-gray-500">
                    <span class="sr-only">Twitter</span>
                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" />
                    </svg>
                </a>
                <a href="#" class="text-gray-400 hover:text-gray-500">
                    <span class="sr-only">LinkedIn</span>
                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path fill-rule="evenodd" d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z" clip-rule="evenodd" />
                    </svg>
                </a>
                <a href="#" class="text-gray-400 hover:text-gray-500">
                    <span class="sr-only">Instagram</span>
                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd" />
                    </svg>
                </a>
            </div>
            <p class="mt-8 text-center text-base text-gray-400">
                &copy; 2025 SkillBolt.dev. All rights reserved.
            </p>
        </div>
    </footer>

    <!-- JavaScript for referral functionality -->
    <script>
        // Function to show referral code input
        function showReferralInput() {
            document.getElementById('referral-input').classList.toggle('hidden');
            const button = document.getElementById('show-referral-btn');
            if (document.getElementById('referral-input').classList.contains('hidden')) {
                button.textContent = 'Enter it here';
            } else {
                button.textContent = 'Hide';
            }
        }
        
        // Function to apply referral code
        function applyReferralCode() {
            const code = document.getElementById('manual-referral').value.trim();
            if (code) {
                // Update form with referral code
                const form = document.querySelector('form');
                
                // Check if referral input already exists
                let referralInput = form.querySelector('input[name="referral_code"]');
                
                if (!referralInput) {
                    // Create a new hidden input if it doesn't exist
                    referralInput = document.createElement('input');
                    referralInput.type = 'hidden';
                    referralInput.name = 'referral_code';
                    form.appendChild(referralInput);
                }
                
                // Set the value
                referralInput.value = code;
                
                // Show confirmation message
                alert('Referral code applied successfully!');
            } else {
                alert('Please enter a valid referral code.');
            }
        }
        
        // Check for referral code in URL on page load
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            const refCode = urlParams.get('ref');
            
            if (refCode) {
                // Add visual indicator that a referral code is active
                const waitlistSection = document.getElementById('waitlist');
                const formContainer = waitlistSection.querySelector('.bg-white.shadow-lg');
                const referralBadge = document.createElement('div');
                referralBadge.className = 'bg-indigo-100 text-indigo-800 text-sm font-medium px-3 py-1 rounded-full inline-flex items-center mb-4';
                referralBadge.innerHTML = '<svg class="h-4 w-4 mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" /></svg> Referral Applied: ' + refCode;
                
                formContainer.insertBefore(referralBadge, formContainer.firstChild.nextSibling);
            }
        });
        
        // Countdown timer functionality
        document.addEventListener('DOMContentLoaded', function() {
            // Set the launch date - 30 days from now
            const launchDate = new Date();
            launchDate.setDate(launchDate.getDate() + 30);
            
            function updateCountdown() {
                const now = new Date().getTime();
                const distance = launchDate - now;
                
                const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                
                // Update the countdown elements
                document.querySelectorAll('.countdown-item')[0].querySelector('span:first-child').textContent = days;
                document.querySelectorAll('.countdown-item')[1].querySelector('span:first-child').textContent = hours;
                document.querySelectorAll('.countdown-item')[2].querySelector('span:first-child').textContent = minutes;
            }
            
            // Update the countdown every minute
            updateCountdown();
            setInterval(updateCountdown, 60000);
        });
    </script>
</body>
</html>

                       