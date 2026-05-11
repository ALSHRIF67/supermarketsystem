<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'نظام إدارة السوبر ماركت') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Kufi+Arabic:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    <style>
        :root {
            --primary: #4f46e5;
            --primary-hover: #4338ca;
            --bg-main: #f8fafc;
            --card-bg: #ffffff;
            --input-focus: #4f46e5;
            --text-main: #1e293b;
            --text-muted: #64748b;
        }
        body {
            font-family: 'Noto Kufi Arabic', sans-serif;
            background-color: var(--bg-main);
            color: var(--text-main);
        }
        .form-input-group {
            position: relative;
            transition: all 0.3s ease;
        }
        .form-input-group:focus-within label {
            color: var(--primary);
            transform: translateY(-2px);
        }
        .custom-input {
            width: 100%;
            border-radius: 0.75rem;
            border: 1px solid #e2e8f0;
            padding: 0.75rem 1rem;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            background-color: #ffffff;
        }
        .custom-input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1);
            transform: translateY(-1px);
        }
        .custom-label {
            display: block;
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--text-muted);
            margin-bottom: 0.5rem;
            transition: all 0.2s ease;
        }
        .btn-primary {
            background-color: var(--primary);
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 0.75rem;
            font-weight: 700;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            box-shadow: 0 4px 6px -1px rgba(79, 70, 229, 0.2), 0 2px 4px -1px rgba(79, 70, 229, 0.1);
        }
        .btn-primary:hover {
            background-color: var(--primary-hover);
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(79, 70, 229, 0.3), 0 4px 6px -2px rgba(79, 70, 229, 0.1);
        }
        .btn-primary:active {
            transform: translateY(0);
        }
        .form-card {
            background: var(--card-bg);
            border-radius: 1.5rem;
            border: 1px solid rgba(226, 232, 240, 0.8);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05), 0 10px 10px -5px rgba(0, 0, 0, 0.02);
            overflow: hidden;
        }
        .animate-fade-in {
            animation: fadeIn 0.4s ease-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @media print {
            .no-print { display: none !important; }
            .print-only { display: block !important; }
            body { background: white !important; margin: 0 !important; padding: 0 !important; }
            main { padding: 0 !important; margin: 0 !important; }
        }
    </style>
</head>
<body class="antialiased bg-slate-50 text-slate-900 overflow-x-hidden" x-data="{ sidebarOpen: false }">
    <div class="min-h-screen flex flex-col md:flex-row">
        
        <!-- Mobile Header -->
        <header class="md:hidden bg-slate-900 text-white p-4 flex items-center justify-between sticky top-0 z-50 no-print">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                </div>
                <span class="text-lg font-bold">MarketOS</span>
            </div>
            <button @click="sidebarOpen = !sidebarOpen" class="p-2 rounded-lg hover:bg-slate-800 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
            </button>
        </header>

        <!-- Sidebar Overlay -->
        <div x-show="sidebarOpen" @click="sidebarOpen = false" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-black/50 z-40 md:hidden no-print"></div>

        <!-- Sidebar -->
        <aside 
            :class="sidebarOpen ? 'translate-x-0' : 'translate-x-full md:translate-x-0'"
            class="fixed md:sticky top-0 right-0 w-64 h-screen bg-slate-900 text-white flex-shrink-0 transition-transform duration-300 z-50 no-print">
            
            <div class="p-6 flex items-center gap-3">
                <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                </div>
                <span class="text-xl font-bold tracking-tight">MarketOS</span>
            </div>

            <nav class="mt-6 px-3 space-y-1 h-[calc(100vh-120px)] overflow-y-auto">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all {{ request()->routeIs('dashboard') ? 'bg-indigo-600 text-white font-medium' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    <span>لوحة التحكم</span>
                </a>
                <a href="{{ route('pos') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-slate-400 hover:bg-slate-800 hover:text-white transition-all {{ request()->routeIs('pos') ? 'bg-slate-800 text-white' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                    <span>نقطة البيع</span>
                </a>
                <a href="{{ route('categories.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-slate-400 hover:bg-slate-800 hover:text-white transition-all {{ request()->routeIs('categories.*') ? 'bg-slate-800 text-white' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>
                    <span>الأقسام</span>
                </a>
                <a href="{{ route('products.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-slate-400 hover:bg-slate-800 hover:text-white transition-all {{ request()->routeIs('products.*') ? 'bg-slate-800 text-white' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    <span>المنتجات</span>
                </a>
                <a href="{{ route('inventory.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-slate-400 hover:bg-slate-800 hover:text-white transition-all {{ request()->routeIs('inventory.*') ? 'bg-slate-800 text-white' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                    <span>المخزون</span>
                </a>
                <a href="{{ route('sales.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-slate-400 hover:bg-slate-800 hover:text-white transition-all {{ request()->routeIs('sales.*') ? 'bg-slate-800 text-white' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0-2.08.402-2.599-1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span>المبيعات</span>
                </a>
                <a href="{{ route('expenses.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-slate-400 hover:bg-slate-800 hover:text-white transition-all {{ request()->routeIs('expenses.*') ? 'bg-slate-800 text-white' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z"></path></svg>
                    <span>المصروفات</span>
                </a>
                <a href="{{ route('customers.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-slate-400 hover:bg-slate-800 hover:text-white transition-all {{ request()->routeIs('customers.*') ? 'bg-slate-800 text-white' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    <span>العملاء</span>
                </a>
                <a href="{{ route('suppliers.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-slate-400 hover:bg-slate-800 hover:text-white transition-all {{ request()->routeIs('suppliers.*') ? 'bg-slate-800 text-white' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    <span>الموردين</span>
                </a>
                <a href="{{ route('reports.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-slate-400 hover:bg-slate-800 hover:text-white transition-all {{ request()->routeIs('reports.*') ? 'bg-slate-800 text-white' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2h2a2 2 0 002-2zM9 19h6m-6 0l6-6m0 0V9a2 2 0 012-2h2a2 2 0 012 2v10a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    <span>التقارير</span>
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 min-w-0 overflow-y-auto">
            <header class="bg-white border-b border-slate-200 px-4 md:px-8 py-4 flex items-center justify-between sticky top-0 z-10 no-print">
                <h1 class="text-lg md:text-xl font-semibold text-slate-800">نظام السوق الذكي</h1>
                <div class="flex items-center gap-4">
                    <div class="flex items-center gap-3 pr-4 border-r border-slate-200">
                        <div class="text-left hidden sm:block">
                            <p class="text-sm font-semibold text-slate-800">{{ auth()->user()->name }}</p>
                            <form action="{{ route('logout') }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="text-[10px] uppercase tracking-widest font-bold text-rose-500 hover:text-rose-600 transition-colors">
                                    تسجيل الخروج
                                </button>
                            </form>
                        </div>
                        <div class="w-10 h-10 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-600 font-bold">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                    </div>
                </div>
            </header>

            <div class="p-4 md:p-8">
                @if(session('success'))
                    <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl flex items-center gap-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-6 p-4 bg-rose-50 border border-rose-200 text-rose-800 rounded-xl flex items-center gap-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        {{ session('error') }}
                    </div>
                @endif

                {{ $slot ?? '' }}
                @yield('content')
            </div>
        </main>
    </div>

    @livewireScripts
    <script>
        window.addEventListener('notify', event => {
            let data = event.detail[0] || event.detail;
            alert(data.message);
        });
    </script>
</body>
</html>
