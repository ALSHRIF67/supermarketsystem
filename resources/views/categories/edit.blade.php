@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-6 flex items-center justify-between">
        <h2 class="text-xl font-semibold text-slate-800">Edit Category</h2>
        <a href="{{ route('categories.index') }}" class="text-slate-500 hover:text-slate-700 text-sm font-medium transition-colors">
            &larr; Back to List
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-8">
        <form action="{{ route('categories.update', $category) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="space-y-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-slate-700 mb-1">Category Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $category->name) }}" 
                        class="w-full rounded-lg border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 @error('name') border-rose-500 @enderror"
                        placeholder="e.g. Beverages, Bakery, Dairy" required>
                    @error('name')
                        <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-slate-700 mb-1">Description (Optional)</label>
                    <textarea name="description" id="description" rows="4" 
                        class="w-full rounded-lg border-slate-200 focus:border-indigo-500 focus:ring-indigo-500"
                        placeholder="Describe what this category includes...">{{ old('description', $category->description) }}</textarea>
                </div>

                <div class="pt-4 flex items-center gap-4">
                    <button type="submit" class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-4 rounded-lg transition-colors">
                        Update Category
                    </button>
                    <a href="{{ route('categories.index') }}" class="flex-1 bg-slate-100 hover:bg-slate-200 text-slate-700 text-center font-bold py-3 px-4 rounded-lg transition-colors">
                        Cancel
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
