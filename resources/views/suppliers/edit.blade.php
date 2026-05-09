@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-6 flex items-center justify-between">
        <h2 class="text-xl font-semibold text-slate-800">Edit Supplier</h2>
        <a href="{{ route('suppliers.index') }}" class="text-slate-500 hover:text-slate-700 text-sm font-medium transition-colors">
            &larr; Back to List
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-8">
        <form action="{{ route('suppliers.update', $supplier) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="space-y-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-slate-700 mb-1">Supplier / Company Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $supplier->name) }}" 
                        class="w-full rounded-lg border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 @error('name') border-rose-500 @enderror"
                        placeholder="e.g. Almarai Group" required>
                    @error('name') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="contact_person" class="block text-sm font-medium text-slate-700 mb-1">Contact Person</label>
                    <input type="text" name="contact_person" id="contact_person" value="{{ old('contact_person', $supplier->contact_person) }}" 
                        class="w-full rounded-lg border-slate-200 focus:border-indigo-500 focus:ring-indigo-500"
                        placeholder="e.g. Mohamed Ahmed">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="email" class="block text-sm font-medium text-slate-700 mb-1">Email Address</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $supplier->email) }}" 
                            class="w-full rounded-lg border-slate-200 focus:border-indigo-500 focus:ring-indigo-500"
                            placeholder="vendor@example.com">
                        @error('email') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="phone" class="block text-sm font-medium text-slate-700 mb-1">Phone Number</label>
                        <input type="text" name="phone" id="phone" value="{{ old('phone', $supplier->phone) }}" 
                            class="w-full rounded-lg border-slate-200 focus:border-indigo-500 focus:ring-indigo-500"
                            placeholder="+249...">
                        @error('phone') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label for="address" class="block text-sm font-medium text-slate-700 mb-1">Office Address</label>
                    <textarea name="address" id="address" rows="3" 
                        class="w-full rounded-lg border-slate-200 focus:border-indigo-500 focus:ring-indigo-500"
                        placeholder="Supplier's physical address...">{{ old('address', $supplier->address) }}</textarea>
                </div>

                <div class="pt-4 flex items-center gap-4">
                    <button type="submit" class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-4 rounded-lg transition-colors">
                        Update Supplier
                    </button>
                    <a href="{{ route('suppliers.index') }}" class="flex-1 bg-slate-100 hover:bg-slate-200 text-slate-700 text-center font-bold py-3 px-4 rounded-lg transition-colors">
                        Cancel
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
