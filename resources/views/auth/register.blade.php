<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - MarketOS</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="bg-slate-50 font-sans antialiased">
    <div class="min-h-screen flex items-center justify-center p-6">
        <div class="max-w-md w-full">
            <div class="text-center mb-10">
                <div class="w-16 h-16 bg-indigo-600 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg shadow-indigo-200">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-slate-900">Create Account</h1>
                <p class="text-slate-500 mt-2">Join MarketOS Management System</p>
            </div>

            <div class="bg-white rounded-3xl border border-slate-200 shadow-xl p-8 md:p-10">
                <form action="{{ route('register.post') }}" method="POST">
                    @csrf
                    <div class="space-y-6">
                        <div>
                            <label for="name" class="block text-sm font-semibold text-slate-700 mb-2">Full Name</label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" 
                                class="w-full px-4 py-3 rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-50/50 transition-all"
                                placeholder="Your Name" required autofocus>
                            @error('name') <p class="mt-2 text-xs text-rose-500">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-semibold text-slate-700 mb-2">Email Address</label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}" 
                                class="w-full px-4 py-3 rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-50/50 transition-all"
                                placeholder="name@example.com" required>
                            @error('email') <p class="mt-2 text-xs text-rose-500">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-semibold text-slate-700 mb-2">Password</label>
                            <input type="password" name="password" id="password" 
                                class="w-full px-4 py-3 rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-50/50 transition-all"
                                placeholder="••••••••" required>
                            @error('password') <p class="mt-2 text-xs text-rose-500">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-sm font-semibold text-slate-700 mb-2">Confirm Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" 
                                class="w-full px-4 py-3 rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-50/50 transition-all"
                                placeholder="••••••••" required>
                        </div>

                        <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-4 rounded-xl transition-all shadow-lg shadow-indigo-100 flex items-center justify-center gap-2">
                            Create Account
                        </button>
                    </div>
                </form>

                <div class="mt-6 pt-6 border-t border-slate-100 text-center">
                    <p class="text-sm text-slate-500">
                        Already have an account? 
                        <a href="{{ route('login') }}" class="font-bold text-indigo-600 hover:text-indigo-700">Sign In</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
