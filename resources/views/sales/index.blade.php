@extends('layouts.app', ['title' => 'Vendas'])

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 space-y-4 md:space-y-0">
        <h2 class="text-2xl font-semibold">Histórico de Vendas</h2>
        
        <a href="{{ route('sales.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md flex items-center">
            <i class="fas fa-cash-register mr-2"></i> Nova Venda
        </a>
    </div>
    
    <!-- Filtros -->
    <form method="GET" action="{{ route('sales.index') }}" class="mb-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label for="date_from" class="block text-sm font-medium text-gray-700">Data Inicial</label>
                <input type="date" id="date_from" name="date_from" value="{{ request('date_from') }}"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            </div>
            
            <div>
                <label for="date_to" class="block text-sm font-medium text-gray-700">Data Final</label>
                <input type="date" id="date_to" name="date_to" value="{{ request('date_to') }}"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            </div>
            
            <div>
                <label for="client_id" class="block text-sm font-medium text-gray-700">Cliente</label>
                <select id="client_id" name="client_id"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    <option value="">Todos</option>
                    @foreach($clients as $client)
                        <option value="{{ $client->id }}" {{ request('client_id') == $client->id ? 'selected' : '' }}>
                            {{ $client->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div>
                <label for="payment_method" class="block text-sm font-medium text-gray-700">Pagamento</label>
                <select id="payment_method" name="payment_method"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    <option value="">Todos</option>
                    @foreach($paymentMethods as $key => $method)
                        <option value="{{ $key }}" {{ request('payment_method') == $key ? 'selected' : '' }}>
                            {{ $method }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        
        <div class="mt-4 flex justify-end space-x-3">
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md">
                <i class="fas fa-filter mr-2"></i> Filtrar
            </button>
            
            <a href="{{ route('sales.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-md">
                <i class="fas fa-times mr-2"></i> Limpar
            </a>
        </div>
    </form>
    
    <!-- Resumo -->
    <div class="mb-6 bg-gray-50 p-4 rounded-md">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="bg-white p-3 rounded shadow">
                <p class="text-sm font-medium text-gray-500">Total de Vendas</p>
                <p class="text-2xl font-semibold text-gray-900">{{ $sales->total() }}</p>
            </div>
            <div class="bg-white p-3 rounded shadow">
                <p class="text-sm font-medium text-gray-500">Valor Total</p>
                <p class="text-2xl font-semibold text-green-600">R$ {{ number_format($sales->sum('total'), 2, ',', '.') }}</p>
            </div>
            <div class="bg-white p-3 rounded shadow">
                <p class="text-sm font-medium text-gray-500">Média por Venda</p>
                <p class="text-2xl font-semibold text-blue-600">R$ {{ number_format($sales->avg('total'), 2, ',', '.') }}</p>
            </div>
            <div class="bg-white p-3 rounded shadow">
                <p class="text-sm font-medium text-gray-500">Maior Venda</p>
                <p class="text-2xl font-semibold text-purple-600">R$ {{ number_format($sales->max('total'), 2, ',', '.') }}</p>
            </div>
        </div>
    </div>
    
    <!-- Tabela de Vendas -->
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nº Venda</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Data</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cliente</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Itens</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pagamento</th>
                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($sales as $sale)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        {{ $sale->invoice_number }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $sale->created_at->format('d/m/Y H:i') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $sale->client->name ?? 'Consumidor Final' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $sale->items->sum('quantity') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-green-600">
                        R$ {{ number_format($sale->total, 2, ',', '.') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $paymentMethods[$sale->payment_method] ?? $sale->payment_method }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <div class="flex justify-end space-x-2">
                            <a href="{{ route('sales.show', $sale->id) }}" class="text-indigo-600 hover:text-indigo-900" title="Detalhes">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('sales.print', $sale->id) }}" class="text-blue-600 hover:text-blue-900" title="Imprimir" target="_blank">
                                <i class="fas fa-print"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                        Nenhuma venda encontrada
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <!-- Paginação -->
    <div class="mt-4">
        {{ $sales->links() }}
    </div>
</div>
@endsection