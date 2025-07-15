@extends('layouts.app', ['title' => 'Fornecedores'])

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 space-y-4 md:space-y-0">
        <h2 class="text-2xl font-semibold">Gerenciamento de Fornecedores</h2>
        
        <a href="{{ route('suppliers.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md flex items-center">
            <i class="fas fa-plus mr-2"></i> Novo Fornecedor
        </a>
    </div>
    
    <!-- Filtros -->
    <form method="GET" action="{{ route('suppliers.index') }}" class="mb-6">
        <div class="flex items-center space-x-4">
            <div class="flex-1">
                <label for="search" class="sr-only">Pesquisar</label>
                <div class="relative rounded-md shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400"></i>
                    </div>
                    <input type="text" name="search" id="search" value="{{ request('search') }}"
                           class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-10 sm:text-sm border-gray-300 rounded-md"
                           placeholder="Pesquisar por nome, email ou CNPJ">
                </div>
            </div>
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md">
                Filtrar
            </button>
            <a href="{{ route('suppliers.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-md">
                Limpar
            </a>
        </div>
    </form>
    
    <!-- Tabela de Fornecedores -->
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fornecedor</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contato</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">CNPJ</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produtos Fornecidos</th>
                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($suppliers as $supplier)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="font-medium text-gray-900">{{ $supplier->name }}</div>
                        <div class="text-sm text-gray-500">{{ $supplier->address }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ $supplier->contact_name }}</div>
                        <div class="text-sm text-gray-500">{{ $supplier->phone }}</div>
                        <div class="text-sm text-gray-500">{{ $supplier->email }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $supplier->formatted_cnpj }}
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-900">
                            @if($supplier->products_provided && count($supplier->products_provided) > 0)
                                <div class="flex flex-wrap gap-1">
                                    @foreach($supplier->products_provided as $product)
                                        <span class="bg-gray-100 px-2 py-1 rounded text-xs">{{ $product }}</span>
                                    @endforeach
                                </div>
                            @else
                                -
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <div class="flex justify-end space-x-2">
                            <a href="{{ route('suppliers.show', $supplier->id) }}" class="text-indigo-600 hover:text-indigo-900" title="Ver">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('suppliers.edit', $supplier->id) }}" class="text-yellow-600 hover:text-yellow-900" title="Editar">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('suppliers.destroy', $supplier->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900" title="Excluir" onclick="return confirm('Tem certeza que deseja excluir este fornecedor?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                        Nenhum fornecedor encontrado
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <!-- Paginação -->
    <div class="mt-4">
        {{ $suppliers->links() }}
    </div>
</div>
@endsection