@extends('layouts.app', ['title' => 'Cadastrar Fornecedor'])

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <h2 class="text-2xl font-semibold mb-6">Cadastrar Novo Fornecedor</h2>

    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('suppliers.store') }}" onsubmit="return true;">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Coluna 1 -->
            <div class="space-y-4">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Nome do Fornecedor *</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                </div>
                
                <div>
                    <label for="contact_name" class="block text-sm font-medium text-gray-700">Nome do Contato *</label>
                    <input type="text" id="contact_name" name="contact_name" value="{{ old('contact_name') }}" required
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                </div>
                
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email *</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                </div>
            </div>
            
            <!-- Coluna 2 -->
            <div class="space-y-4">
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700">Telefone *</label>
                    <input type="text" id="phone" name="phone" value="{{ old('phone') }}" required
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                </div>
                
                <div>
                    <label for="address" class="block text-sm font-medium text-gray-700">Endereço *</label>
                    <input type="text" id="address" name="address" value="{{ old('address') }}" required
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                </div>
                
                <div>
                    <label for="cnpj" class="block text-sm font-medium text-gray-700">CNPJ (apenas Numeros) *</label>
                    <input type="text" id="cnpj" name="cnpj" value="{{ old('cnpj') }}" maxlength="14" required
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                </div>
            </div>
            
            <!-- Campo full width -->
            <div class="md:col-span-2">
                <label for="products_provided" class="block text-sm font-medium text-gray-700">Produtos Fornecidos (separados por vírgula)</label>
                <input type="text" id="products_provided" name="products_provided" value="{{ old('products_provided') }}"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            </div>
        </div>
        
        <div class="mt-6 flex justify-end space-x-3">
            <a href="{{ route('suppliers.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-md">
                Cancelar
            </a>
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md">
                Cadastrar Fornecedor
            </button>
        </div>
    </form>
</div>
@endsection