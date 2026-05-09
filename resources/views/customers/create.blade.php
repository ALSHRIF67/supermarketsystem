@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-6 flex items-center justify-between">
        <h2 class="text-xl font-semibold text-slate-800">Add New Customer</h2>
        <a href="{{ route('customers.index') }}" class="text-slate-500 hover:text-slate-700 text-sm font-medium transition-colors">
            &larr; Back to List
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-8">
        <form action="{{ route('customers.store') }}" method="POST">
            @csrf
            <div class="space-y-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-slate-700 mb-1">Customer Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" 
                        class="w-full rounded-lg border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 @error('name') border-rose-500 @enderror"
                        placeholder="e.g. Ahmed Ali" required>
                    @error('name') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="email" class="block text-sm font-medium text-slate-700 mb-1">Email Address</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" 
                            class="w-full rounded-lg border-slate-200 focus:border-indigo-500 focus:ring-indigo-500"
                            placeholder="customer@example.com">
                        @error('email') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="phone" class="block text-sm font-medium text-slate-700 mb-1">Phone Number</label>
                        <input type="text" name="phone" id="phone" value="{{ old('phone') }}" 
                            class="w-full rounded-lg border-slate-200 focus:border-indigo-500 focus:ring-indigo-500"
                            placeholder="+249...">
                        @error('phone') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label for="address" class="block text-sm font-medium text-slate-700 mb-1">Address</label>
                    <textarea name="address" id="address" rows="3" 
                        class="w-full rounded-lg border-slate-200 focus:border-indigo-500 focus:ring-indigo-500"
                        placeholder="Customer's physical address...">{{ old('address') }}</textarea>
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-4 rounded-lg transition-colors">
                        Register Customer
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
