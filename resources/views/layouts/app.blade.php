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
            /* Brand Colors - Emerald */
            --primary-50: #ecfdf5;
            --primary-100: #d1fae5;
            --primary-200: #a7f3d0;
            --primary-300: #6ee7b7;
            --primary-400: #34d399;
            --primary-500: #10b981;
            --primary-600: #059669;
            --primary-700: #047857;
            
            --primary: var(--primary-500);
            --primary-hover: var(--primary-600);
            
            /* Backgrounds & Neutrals */
            --bg-main: #f8fafc;
            --card-bg: #ffffff;
            --sidebar-bg: #0f172a;
            
            /* Text Colors */
            --text-main: #0f172a;
            --text-muted: #64748b;
            --text-on-dark: #f8fafc;
            
            /* Functional Colors */
            --success: #10b981;
            --danger: #ef4444;
            --warning: #f59e0b;
            --info: #3b82f6;

            /* Shadows */
            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            --shadow-md: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
            --shadow-lg: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
            --shadow-primary: 0 10px 15px -3px rgb(16 185 129 / 0.2);
        }

        body {
            font-family: 'Noto Kufi Arabic', sans-serif;
            background-color: var(--bg-main);
            color: var(--text-main);
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
        }

        /* Glassmorphism Utilities */
        .glass {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .glass-dark {
            background: rgba(15, 23, 42, 0.8);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        /* Layout Enhancements */
        .main-content-area {
            transition: all 0.3s ease;
        }

        /* Card Styles */
        .premium-card {
            background: var(--card-bg);
            border-radius: 1.25rem;
            border: 1px solid rgba(226, 232, 240, 0.6);
            box-shadow: var(--shadow-sm);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .premium-card:hover {
            box-shadow: var(--shadow-md);
            transform: translateY(-2px);
        }

        /* Input & Form Styles */
        .form-input-group {
            margin-bottom: 1.5rem;
        }

        .custom-label {
            display: block;
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--text-muted);
            margin-bottom: 0.5rem;
            transition: color 0.2s ease;
        }

        .custom-input {
            width: 100%;
            background-color: #ffffff;
            border: 1.5px solid #e2e8f0;
            border-radius: 0.75rem;
            padding: 0.75rem 1rem;
            font-size: 0.95rem;
            transition: all 0.2s ease;
            box-shadow: var(--shadow-sm);
        }

        .custom-input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 4px var(--primary-100);
            background-color: #fff;
        }

        /* Button Styles */
        .btn-premium {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.625rem;
            padding: 0.75rem 1.5rem;
            border-radius: 0.875rem;
            font-weight: 700;
            font-size: 0.95rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
        }

        .btn-premium-primary {
            background: var(--primary);
            color: white;
            box-shadow: var(--shadow-primary);
        }

        .btn-premium-primary:hover {
            background: var(--primary-hover);
            transform: translateY(-2px);
            box-shadow: 0 12px 20px -5px rgb(16 185 129 / 0.3);
        }

        .btn-premium-primary:active {
            transform: translateY(0);
        }

        /* Table Modernization - Premium SaaS Style */
        .premium-table-container {
            @apply bg-transparent;
        }

        .premium-table {
            @apply w-full text-right border-separate;
            border-spacing: 0 0.75rem;
        }

        .premium-table thead th {
            @apply px-8 py-4 text-[11px] font-black uppercase tracking-[0.2em] text-slate-400 border-none;
        }

        .premium-table tbody tr {
            @apply bg-white shadow-sm transition-all duration-300 relative;
            border-radius: 1.25rem;
        }

        .premium-table tbody tr:hover {
            @apply shadow-lg transform -translate-y-0.5 z-10;
            background-color: #fcfdfd;
        }

        .premium-table td {
            @apply px-8 py-6 text-sm text-slate-600 border-y border-transparent first:border-r first:rounded-r-2xl last:border-l last:rounded-l-2xl transition-all;
            border-color: rgba(226, 232, 240, 0.4);
        }

        .premium-table tr:hover td {
            @apply border-emerald-100;
        }

        .premium-table tr:hover td:first-child {
            @apply border-r-emerald-200;
        }

        .premium-table tr:hover td:last-child {
            @apply border-l-emerald-200;
        }

        /* Responsive Table adjustments */
        @media (max-width: 768px) {
            .premium-table td, .premium-table th {
                @apply px-4 py-4;
            }
        }

        /* Animations */
        .animate-slide-up {
            animation: slideUp 0.5s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        [x-cloak] { display: none !important; }

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
                <div class="w-8 h-8 bg-emerald-600 rounded-lg flex items-center justify-center">
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
            class="fixed md:sticky top-0 right-0 w-72 h-screen bg-slate-900 text-white flex-shrink-0 transition-transform duration-300 z-50 no-print shadow-2xl">
            
            <div class="p-8 flex items-center gap-4">
                <div class="w-12 h-12 bg-gradient-to-br from-emerald-400 to-emerald-600 rounded-2xl flex items-center justify-center shadow-lg shadow-emerald-900/20">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                </div>
                <div>
                    <span class="text-2xl font-black tracking-tight block">MarketOS</span>
                    <span class="text-[10px] text-slate-500 font-bold uppercase tracking-widest">Premium Edition</span>
                </div>
            </div>

            <nav class="mt-4 px-4 space-y-1.5 h-[calc(100vh-140px)] overflow-y-auto custom-scrollbar">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3.5 px-5 py-3.5 rounded-xl transition-all duration-300 {{ request()->routeIs('dashboard') ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-900/40 font-bold' : 'text-slate-400 hover:bg-slate-800/50 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    <span>لوحة التحكم</span>
                </a>
                
                <div class="pt-4 pb-2 px-5 text-[10px] font-bold text-slate-600 uppercase tracking-[0.2em]">عمليات البيع</div>
                <a href="{{ route('pos') }}" class="flex items-center gap-3.5 px-5 py-3.5 rounded-xl transition-all duration-300 {{ request()->routeIs('pos') ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-900/40 font-bold' : 'text-slate-400 hover:bg-slate-800/50 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                    <span>نقطة البيع</span>
                </a>
                <a href="{{ route('sales.index') }}" class="flex items-center gap-3.5 px-5 py-3.5 rounded-xl transition-all duration-300 {{ request()->routeIs('sales.*') ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-900/40 font-bold' : 'text-slate-400 hover:bg-slate-800/50 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0-2.08.402-2.599-1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span>المبيعات</span>
                </a>

                <div class="pt-4 pb-2 px-5 text-[10px] font-bold text-slate-600 uppercase tracking-[0.2em]">المخزون</div>
                <a href="{{ route('products.index') }}" class="flex items-center gap-3.5 px-5 py-3.5 rounded-xl transition-all duration-300 {{ request()->routeIs('products.*') ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-900/40 font-bold' : 'text-slate-400 hover:bg-slate-800/50 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    <span>المنتجات</span>
                </a>
                <a href="{{ route('categories.index') }}" class="flex items-center gap-3.5 px-5 py-3.5 rounded-xl transition-all duration-300 {{ request()->routeIs('categories.*') ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-900/40 font-bold' : 'text-slate-400 hover:bg-slate-800/50 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>
                    <span>الأقسام</span>
                </a>
                <a href="{{ route('inventory.index') }}" class="flex items-center gap-3.5 px-5 py-3.5 rounded-xl transition-all duration-300 {{ request()->routeIs('inventory.*') ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-900/40 font-bold' : 'text-slate-400 hover:bg-slate-800/50 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                    <span>المخزون</span>
                </a>

                <div class="pt-4 pb-2 px-5 text-[10px] font-bold text-slate-600 uppercase tracking-[0.2em]">الإدارة</div>
                <a href="{{ route('expenses.index') }}" class="flex items-center gap-3.5 px-5 py-3.5 rounded-xl transition-all duration-300 {{ request()->routeIs('expenses.*') ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-900/40 font-bold' : 'text-slate-400 hover:bg-slate-800/50 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z"></path></svg>
                    <span>المصروفات</span>
                </a>
                <a href="{{ route('customers.index') }}" class="flex items-center gap-3.5 px-5 py-3.5 rounded-xl transition-all duration-300 {{ request()->routeIs('customers.*') ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-900/40 font-bold' : 'text-slate-400 hover:bg-slate-800/50 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    <span>العملاء</span>
                </a>
                <a href="{{ route('suppliers.index') }}" class="flex items-center gap-3.5 px-5 py-3.5 rounded-xl transition-all duration-300 {{ request()->routeIs('suppliers.*') ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-900/40 font-bold' : 'text-slate-400 hover:bg-slate-800/50 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    <span>الموردين</span>
                </a>
                <a href="{{ route('reports.index') }}" class="flex items-center gap-3.5 px-5 py-3.5 rounded-xl transition-all duration-300 {{ request()->routeIs('reports.*') ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-900/40 font-bold' : 'text-slate-400 hover:bg-slate-800/50 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2h2a2 2 0 002-2zM9 19h6m-6 0l6-6m0 0V9a2 2 0 012-2h2a2 2 0 012 2v10a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    <span>التقارير</span>
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 min-w-0 overflow-y-auto">
            <header class="bg-white/80 backdrop-blur-md border-b border-slate-200 px-6 md:px-10 py-5 flex items-center justify-between sticky top-0 z-10 no-print">
                <div class="flex items-center gap-6">
                    <button @click="sidebarOpen = !sidebarOpen" class="md:hidden p-2 rounded-xl bg-slate-100 text-slate-600 hover:bg-slate-200 transition-all">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
                    </button>
                    <h1 class="text-xl md:text-2xl font-black text-slate-800 tracking-tight">نظام السوق الذكي</h1>
                </div>
                
                <div class="flex items-center gap-6">
                    <div class="flex items-center gap-4 pl-6">
                        <div class="text-left hidden sm:block">
                            <p class="text-sm font-bold text-slate-800">{{ auth()->user()->name }}</p>
                            <form action="{{ route('logout') }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="text-[10px] uppercase tracking-[0.2em] font-black text-rose-500 hover:text-rose-600 transition-colors">
                                    تسجيل الخروج
                                </button>
                            </form>
                        </div>
                        <div class="w-11 h-11 bg-gradient-to-tr from-emerald-50 to-emerald-100 rounded-2xl flex items-center justify-center text-emerald-600 font-black shadow-sm border border-emerald-200/50 ring-4 ring-white">
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
