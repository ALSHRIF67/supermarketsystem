@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-6 flex items-center justify-between">
        <h2 class="text-xl font-semibold text-slate-800">Edit Expense</h2>
        <a href="{{ route('expenses.index') }}" class="text-slate-500 hover:text-slate-700 text-sm font-medium transition-colors">
            &larr; Back to List
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-8">
        <form action="{{ route('expenses.update', $expense) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="expense_category_id" class="block text-sm font-medium text-slate-700 mb-1">Category</label>
                        <select name="expense_category_id" id="expense_category_id" class="w-full rounded-lg border-slate-200 focus:border-indigo-500 focus:ring-indigo-500" required>
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('expense_category_id', $expense->expense_category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('expense_category_id') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="expense_date" class="block text-sm font-medium text-slate-700 mb-1">Date</label>
                        <input type="date" name="expense_date" id="expense_date" value="{{ old('expense_date', $expense->expense_date->format('Y-m-d')) }}" 
                            class="w-full rounded-lg border-slate-200 focus:border-indigo-500 focus:ring-indigo-500" required>
                        @error('expense_date') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="amount" class="block text-sm font-medium text-slate-700 mb-1">Amount</label>
                        <input type="number" step="0.01" name="amount" id="amount" value="{{ old('amount', $expense->amount) }}" 
                            class="w-full rounded-lg border-slate-200 focus:border-indigo-500 focus:ring-indigo-500"
                            placeholder="0.00" required>
                        @error('amount') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="reference_number" class="block text-sm font-medium text-slate-700 mb-1">Ref / Invoice #</label>
                        <input type="text" name="reference_number" id="reference_number" value="{{ old('reference_number', $expense->reference_number) }}" 
                            class="w-full rounded-lg border-slate-200 focus:border-indigo-500 focus:ring-indigo-500"
                            placeholder="Optional">
                    </div>
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-slate-700 mb-1">Description</label>
                    <textarea name="description" id="description" rows="3" 
                        class="w-full rounded-lg border-slate-200 focus:border-indigo-500 focus:ring-indigo-500"
                        placeholder="What was this expense for?">{{ old('description', $expense->description) }}</textarea>
                </div>

                <div class="pt-4 flex items-center gap-4">
                    <button type="submit" class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-4 rounded-lg transition-colors">
                        Update Expense
                    </button>
                    <a href="{{ route('expenses.index') }}" class="flex-1 bg-slate-100 hover:bg-slate-200 text-slate-700 text-center font-bold py-3 px-4 rounded-lg transition-colors">
                        Cancel
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
