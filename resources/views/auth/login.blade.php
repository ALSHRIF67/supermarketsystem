<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - MarketOS</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="bg-slate-50 font-sans antialiased">
    <div class="min-h-screen flex items-center justify-center p-6">
        <div class="max-w-md w-full">
            <div class="text-center mb-10">
                <div class="w-16 h-16 bg-indigo-600 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg shadow-indigo-200">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-slate-900">Welcome Back</h1>
                <p class="text-slate-500 mt-2">Login to your MarketOS account</p>
            </div>

            <div class="bg-white rounded-3xl border border-slate-200 shadow-xl p-8 md:p-10">
                <form action="{{ route('login.post') }}" method="POST">
                    @csrf
                    <div class="space-y-6">
                        <div>
                            <label for="email" class="block text-sm font-semibold text-slate-700 mb-2">Email Address</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.206"></path></svg>
                                </span>
                                <input type="email" name="email" id="email" value="{{ old('email') }}" 
                                    class="w-full pl-10 pr-4 py-3 rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-50/50 transition-all"
                                    placeholder="admin@marketos.com" required autofocus>
                            </div>
                            @error('email') <p class="mt-2 text-xs text-rose-500">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <label for="password" class="block text-sm font-semibold text-slate-700">Password</label>
                                <a href="#" class="text-xs font-semibold text-indigo-600 hover:text-indigo-700 transition-colors">Forgot?</a>
                            </div>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                </span>
                                <input type="password" name="password" id="password" 
                                    class="w-full pl-10 pr-4 py-3 rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-50/50 transition-all"
                                    placeholder="••••••••" required>
                            </div>
                        </div>

                        <div class="flex items-center">
                            <input type="checkbox" name="remember" id="remember" class="w-4 h-4 text-indigo-600 border-slate-300 rounded focus:ring-indigo-500">
                            <label for="remember" class="ml-2 text-sm text-slate-600">Remember me</label>
                        </div>

                        <button type="submit" class="w-full bg-slate-900 hover:bg-slate-800 text-white font-bold py-4 rounded-xl transition-all shadow-lg shadow-slate-200 flex items-center justify-center gap-2">
                            Sign In
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </button>
                    </div>
                </form>

                <div class="mt-6 pt-6 border-t border-slate-100 text-center">
                    <p class="text-sm text-slate-500">
                        Don't have an account? 
                        <a href="{{ route('register') }}" class="font-bold text-indigo-600 hover:text-indigo-700">Create One</a>
                    </p>
                </div>
            </div>
            
            <p class="text-center mt-8 text-sm text-slate-500">
                © 2026 MarketOS System. All rights reserved.
            </p>
        </div>
    </div>
</body>
</html>
