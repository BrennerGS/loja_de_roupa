@extends('layouts.app', ['title' => 'Editar Fornecedor'])

@section('content')
<div class="bg-white rounded-lg shadow-md p-6 max-w-3xl mx-auto">
    <h2 class="text-2xl font-semibold mb-6">Editar Fornecedor</h2>
    
    <form action="{{ route('suppliers.update', $supplier->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Nome do Fornecedor *</label>
                <input type="text" id="name" name="name" value="{{ old('name', $supplier->name) }}" required
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label for="contact_name" class="block text-sm font-medium text-gray-700">Nome do Contato *</label>
                <input type="text" id="contact_name" name="contact_name" value="{{ old('contact_name', $supplier->contact_name) }}" required
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                @error('contact_name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email *</label>
                <input type="email" id="email" name="email" value="{{ old('email', $supplier->email) }}" required
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label for="phone" class="block text-sm font-medium text-gray-700">Telefone *</label>
                <input type="text" id="phone" name="phone" value="{{ old('phone', $supplier->phone) }}" required
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                @error('phone')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="md:col-span-2">
                <label for="address" class="block text-sm font-medium text-gray-700">Endereço *</label>
                <input type="text" id="address" name="address" value="{{ old('address', $supplier->address) }}" required
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                @error('address')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label for="cnpj" class="block text-sm font-medium text-gray-700">CNPJ *</label>
                <input type="text" id="cnpj" name="cnpj" value="{{ old('cnpj', $supplier->cnpj) }}"  maxlength="14" required
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                @error('cnpj')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="md:col-span-2">
                <label for="products_provided" class="block text-sm font-medium text-gray-700">Produtos Fornecidos</label>
                <textarea id="products_provided" name="products_provided" rows="2"
                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                          placeholder="Liste os produtos fornecidos, separados por vírgula">{{ old('products_provided', $supplier->products_provided ? implode(', ', $supplier->products_provided) : '') }}</textarea>
                @error('products_provided')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>
        
        <div class="mt-6 flex justify-end space-x-3">
            <a href="{{ route('suppliers.show', $supplier->id) }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-md">
                Cancelar
            </a>
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md">
                Atualizar Fornecedor
            </button>
        </div>
    </form>
</div>
@endsection