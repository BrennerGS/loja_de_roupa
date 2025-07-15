@extends('layouts.app', ['title' => 'Detalhes da Venda'])

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold">Detalhes da Venda</h2>
        <div class="flex space-x-2">
            <a href="{{ route('sales.print', $sale->id) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md flex items-center" target="_blank">
                <i class="fas fa-print mr-2"></i> Imprimir
            </a>
            <a href="{{ route('sales.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-md">
                Voltar
            </a>
        </div>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Informações da Venda -->
        <div class="bg-gray-50 p-4 rounded-md">
            <h3 class="font-medium mb-3">Informações da Venda</h3>
            <div class="space-y-2">
                <p><span class="font-medium">Número:</span> {{ $sale->invoice_number }}</p>
                <p><span class="font-medium">Data:</span> {{ $sale->created_at->format('d/m/Y H:i') }}</p>
                <p><span class="font-medium">Vendedor:</span> {{ $sale->user->name }}</p>
                <p><span class="font-medium">Pagamento:</span> {{ $paymentMethods[$sale->payment_method] ?? $sale->payment_method }}</p>
            </div>
        </div>
        
        <!-- Informações do Cliente -->
        <div class="bg-gray-50 p-4 rounded-md">
            <h3 class="font-medium mb-3">Cliente</h3>
            @if($sale->client)
                <div class="space-y-2">
                    <p><span class="font-medium">Nome:</span> {{ $sale->client->name }}</p>
                    <p><span class="font-medium">Telefone:</span> {{ $sale->client->phone }}</p>
                    <p><span class="font-medium">Total de Compras:</span> {{ $sale->client->purchases_count }}</p>
                </div>
            @else
                <p>Consumidor Final</p>
            @endif
        </div>
        
        <!-- Resumo Financeiro -->
        <div class="bg-gray-50 p-4 rounded-md">
            <h3 class="font-medium mb-3">Resumo Financeiro</h3>
            <div class="space-y-2">
                <p class="flex justify-between">
                    <span class="font-medium">Subtotal:</span>
                    <span>R$ {{ number_format($sale->total - $sale->tax + $sale->discount, 2, ',', '.') }}</span>
                </p>
                <p class="flex justify-between">
                    <span class="font-medium">Desconto:</span>
                    <span class="text-red-600">- R$ {{ number_format($sale->discount, 2, ',', '.') }}</span>
                </p>
                <p class="flex justify-between">
                    <span class="font-medium">Taxas:</span>
                    <span class="text-blue-600">+ R$ {{ number_format($sale->tax, 2, ',', '.') }}</span>
                </p>
                <p class="flex justify-between text-lg font-bold border-t pt-2 mt-2">
                    <span>Total:</span>
                    <span class="text-green-600">R$ {{ number_format($sale->total, 2, ',', '.') }}</span>
                </p>
            </div>
        </div>
    </div>
    
    <!-- Itens da Venda -->
    <div class="mb-6">
        <h3 class="text-lg font-medium mb-3">Itens da Venda</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produto</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Preço Unit.</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantidade</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($sale->items as $item)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="font-medium text-gray-900">{{ $item->product->name }}</div>
                            <div class="text-sm text-gray-500">{{ $item->product->sku }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            R$ {{ number_format($item->unit_price, 2, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $item->quantity }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-green-600">
                            R$ {{ number_format($item->total_price, 2, ',', '.') }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    
    <!-- Observações -->
    @if($sale->notes)
    <div class="bg-gray-50 p-4 rounded-md">
        <h3 class="font-medium mb-2">Observações</h3>
        <p class="text-gray-700">{{ $sale->notes }}</p>
    </div>
    @endif
</div>
@endsection