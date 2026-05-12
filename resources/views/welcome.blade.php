<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MarketOS | نظام إدارة السوبر ماركت الذكي</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Kufi+Arabic:wght@400;600;700;900&display=swap" rel="stylesheet">

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Noto Kufi Arabic', sans-serif;
            background: radial-gradient(circle at top right, #ecfdf5 0%, #f8fafc 40%, #ffffff 100%);
            overflow-x: hidden;
        }

        .hero-glass {
            background: rgba(255, 255, 255, 0.4);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.05);
        }

        .animate-float {
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(2deg); }
            100% { transform: translateY(0px) rotate(0deg); }
        }

        .blob {
            position: absolute;
            width: 500px;
            height: 500px;
            background: linear-gradient(135deg, #10b981 0%, #3b82f6 100%);
            filter: blur(80px);
            opacity: 0.1;
            z-index: -1;
            border-radius: 50%;
        }
    </style>
</head>
<body class="antialiased min-h-screen flex flex-col items-center justify-center p-6 relative">
    
    <!-- Decorative Elements -->
    <div class="blob -top-24 -right-24"></div>
    <div class="blob -bottom-24 -left-24 animate-float" style="animation-delay: -3s;"></div>

    <div class="w-full max-w-5xl relative">
        <!-- Navigation -->
        <nav class="absolute -top-20 left-0 right-0 flex items-center justify-between px-6 py-4 z-10">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-emerald-600 rounded-xl flex items-center justify-center shadow-lg shadow-emerald-500/20">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                </div>
                <span class="text-xl font-black text-slate-900 tracking-tight">MarketOS</span>
            </div>

            @if (Route::has('login'))
                <div class="flex items-center gap-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="px-6 py-2.5 bg-slate-900 text-white rounded-xl font-bold text-sm transition-all hover:bg-slate-800 hover:shadow-xl hover:shadow-slate-900/10 active:scale-95">
                            لوحة التحكم
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-black text-slate-600 hover:text-emerald-600 transition-colors">
                            تسجيل الدخول
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="px-6 py-2.5 bg-emerald-600 text-white rounded-xl font-bold text-sm transition-all hover:bg-emerald-700 hover:shadow-xl hover:shadow-emerald-500/20 active:scale-95">
                                إنشاء حساب
                            </a>
                        @endif
                    @endauth
                </div>
            @endif
        </nav>

        <!-- Hero Section -->
        <div class="hero-glass rounded-[3rem] p-12 md:p-20 flex flex-col items-center text-center space-y-12 overflow-hidden relative">
            <div class="space-y-6 max-w-3xl relative z-10">
                <div class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-50 text-emerald-600 rounded-full text-[10px] font-black uppercase tracking-[0.2em] border border-emerald-100 mb-4 animate-slide-up">
                    <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
                    نظام إدارة السوبر ماركت الحديث
                </div>
                
                <h1 class="text-5xl md:text-7xl font-black text-slate-900 leading-[1.1] tracking-tighter animate-slide-up" style="animation-delay: 0.1s;">
                    تحكم ذكي، <br/>
                    <span class="text-emerald-600">نمو غير محدود.</span>
                </h1>
                
                <p class="text-lg md:text-xl text-slate-500 font-medium leading-relaxed max-w-2xl mx-auto animate-slide-up" style="animation-delay: 0.2s;">
                    ارتقِ بأعمالك إلى المستوى التالي مع MarketOS. نظام متكامل لنقاط البيع، إدارة المخزون، والتقارير المالية بدقة واحترافية متناهية.
                </p>
            </div>

            <div class="flex flex-wrap items-center justify-center gap-6 animate-slide-up" style="animation-delay: 0.3s;">
                @auth
                    <a href="{{ url('/dashboard') }}" class="px-10 py-5 bg-emerald-600 text-white rounded-2xl font-black text-lg transition-all hover:bg-emerald-700 hover:shadow-2xl hover:shadow-emerald-500/30 flex items-center gap-3 active:scale-95 group">
                        <span>ابدأ الآن</span>
                        <svg class="w-6 h-6 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    </a>
                @else
                    <a href="{{ route('register') }}" class="px-10 py-5 bg-emerald-600 text-white rounded-2xl font-black text-lg transition-all hover:bg-emerald-700 hover:shadow-2xl hover:shadow-emerald-500/30 flex items-center gap-3 active:scale-95 group">
                        <span>ابدأ تجربتك المجانية</span>
                        <svg class="w-6 h-6 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    </a>
                    <a href="{{ route('login') }}" class="px-10 py-5 bg-white text-slate-600 border border-slate-200 rounded-2xl font-black text-lg transition-all hover:bg-slate-50 hover:border-slate-300 active:scale-95">
                        تسجيل الدخول
                    </a>
                @endauth
            </div>

            <!-- Features Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 w-full pt-12 animate-slide-up" style="animation-delay: 0.4s;">
                <div class="p-8 bg-white/50 rounded-[2rem] border border-white/50 text-right space-y-4">
                    <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                    <h3 class="text-xl font-black text-slate-900">نقطة بيع سريعة</h3>
                    <p class="text-sm text-slate-500 font-medium">نظام POS متطور يدعم الباركود والطباعة الحرارية بلمح البصر.</p>
                </div>

                <div class="p-8 bg-white/50 rounded-[2rem] border border-white/50 text-right space-y-4">
                    <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                    </div>
                    <h3 class="text-xl font-black text-slate-900">مخزون دقيق</h3>
                    <p class="text-sm text-slate-500 font-medium">تتبع كل قطعة في مستودعاتك مع تنبيهات ذكية عند انخفاض الكمية.</p>
                </div>

                <div class="p-8 bg-white/50 rounded-[2rem] border border-white/50 text-right space-y-4">
                    <div class="w-12 h-12 bg-rose-50 text-rose-600 rounded-2xl flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2h2a2 2 0 002-2zM9 19h6m-6 0l6-6m0 0V9a2 2 0 012-2h2a2 2 0 012 2v10a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    </div>
                    <h3 class="text-xl font-black text-slate-900">تقارير مالية</h3>
                    <p class="text-sm text-slate-500 font-medium">تحليلات دقيقة للأرباح والمبيعات تساعدك في اتخاذ قراراتك.</p>
                </div>
            </div>
        </div>

        <footer class="mt-20 text-center space-y-4 pb-12 animate-slide-up" style="animation-delay: 0.6s;">
            <div class="flex items-center justify-center gap-6 text-slate-400 font-black text-[10px] uppercase tracking-widest">
                <span>Made with ❤️ for Markets</span>
                <span class="w-1 h-1 bg-slate-300 rounded-full"></span>
                <span>Version 1.0.0</span>
            </div>
            <p class="text-slate-400 font-medium text-xs">جميع الحقوق محفوظة &copy; {{ date('Y') }} نظام السوق الذكي</p>
        </footer>
    </div>
</body>
</html>
