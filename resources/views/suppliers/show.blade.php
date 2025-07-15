@extends('layouts.app', ['title' => 'Detalhes do Fornecedor'])

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold">Detalhes do Fornecedor</h2>
        <div class="flex space-x-2">
            <a href="{{ route('suppliers.edit', $supplier->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-md flex items-center">
                <i class="fas fa-edit mr-2"></i> Editar
            </a>
            <a href="{{ route('suppliers.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-md">
                Voltar
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <!-- Informações do Fornecedor -->
        <div class="bg-gray-50 p-4 rounded-md">
            <h3 class="font-medium mb-3">Informações do Fornecedor</h3>
            <div class="space-y-2">
                <p><span class="font-medium">Nome:</span> {{ $supplier->name }}</p>
                <p><span class="font-medium">CNPJ:</span> {{ $supplier->formatted_cnpj }}</p>
                <p><span class="font-medium">Endereço:</span> {{ $supplier->address }}</p>
            </div>
        </div>

        <!-- Contato -->
        <div class="bg-gray-50 p-4 rounded-md">
            <h3 class="font-medium mb-3">Contato</h3>
            <div class="space-y-2">
                <p><span class="font-medium">Responsável:</span> {{ $supplier->contact_name }}</p>
                <p><span class="font-medium">Telefone:</span> {{ $supplier->phone }}</p>
                <p><span class="font-medium">Email:</span> {{ $supplier->email }}</p>
            </div>
        </div>
    </div>

    <!-- Produtos Fornecidos -->
    <div>
        <h3 class="text-lg font-medium mb-3">Produtos Fornecidos</h3>
        
        @if($supplier->products_provided && count($supplier->products_provided) > 0)
            <div class="bg-gray-50 p-4 rounded-md">
                <div class="flex flex-wrap gap-2">
                    @foreach($supplier->products_provided as $product)
                        <span class="bg-white px-3 py-1 rounded-full text-sm shadow-sm">{{ $product }}</span>
                    @endforeach
                </div>
            </div>
        @else
            <div class="bg-gray-50 p-4 rounded-md text-center text-gray-500">
                Nenhum produto registrado para este fornecedor
            </div>
        @endif
    </div>
</div>
@endsection