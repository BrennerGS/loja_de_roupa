@extends('layouts.app', ['title' => 'Relatório de Vendas'])

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 space-y-4 md:space-y-0">
        <h2 class="text-2xl font-semibold">Relatório de Vendas</h2>
        
        <div class="flex space-x-2">
            <a href="{{ route('reports.sales', array_merge(request()->query(), ['export' => 'pdf'])) }}" 
               class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md flex items-center">
                <i class="fas fa-file-pdf mr-2"></i> Exportar PDF
            </a>
            <a href="{{ route('reports.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-md">
                Voltar
            </a>
        </div>
    </div>
    
    <!-- Filtros -->
    <form method="GET" action="{{ route('reports.sales') }}" class="mb-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label for="start_date" class="block text-sm font-medium text-gray-700">Data Inicial</label>
                <input type="date" id="start_date" name="start_date" value="{{ request('start_date') }}"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            </div>
            
            <div>
                <label for="end_date" class="block text-sm font-medium text-gray-700">Data Final</label>
                <input type="date" id="end_date" name="end_date" value="{{ request('end_date') }}"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            </div>
            
            <div class="flex items-end">
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md h-[42px]">
                    <i class="fas fa-filter mr-2"></i> Filtrar
                </button>
            </div>
        </div>
    </form>
    
    <!-- Resumo -->
    <div class="mb-6 bg-gray-50 p-4 rounded-md">
        <h3 class="text-lg font-medium mb-3">Resumo do Período</h3>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="bg-white p-3 rounded shadow">
                <p class="text-sm font-medium text-gray-500">Total de Vendas</p>
                <p class="text-2xl font-semibold text-gray-900">{{ $sales->count() }}</p>
            </div>
            <div class="bg-white p-3 rounded shadow">
                <p class="text-sm font-medium text-gray-500">Valor Total</p>
                <p class="text-2xl font-semibold text-green-600">R$ {{ number_format($totalSales, 2, ',', '.') }}</p>
            </div>
            <div class="bg-white p-3 rounded shadow">
                <p class="text-sm font-medium text-gray-500">Média por Venda</p>
                <p class="text-2xl font-semibold text-blue-600">R$ {{ number_format($sales->avg('total') ?? 0, 2, ',', '.') }}</p>
            </div>
            <div class="bg-white p-3 rounded shadow">
                <p class="text-sm font-medium text-gray-500">Total de Itens</p>
                <p class="text-2xl font-semibold text-purple-600">{{ $totalItems }}</p>
            </div>
        </div>
    </div>
    
    <!-- Tabela de Vendas -->
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Data</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nº Venda</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cliente</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Itens</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pagamento</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($sales as $sale)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $sale->created_at->format('d/m/Y') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        {{ $sale->invoice_number }}
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
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                        Nenhuma venda encontrada no período
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <!-- Gráfico (opcional) -->
    <div class="mt-8">
        <h3 class="text-lg font-medium mb-3">Vendas por Dia</h3>
        <div class="bg-white p-4 rounded-md shadow">
            <canvas id="salesChart" height="100"></canvas>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('salesChart').getContext('2d');
    
    // Dados do gráfico (substitua pelos seus dados reais)
    const salesData = @json($salesByDate);
    
    const labels = salesData.map(item => item.date);
    const data = salesData.map(item => item.total);
    
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Vendas por Dia',
                data: data,
                backgroundColor: 'rgba(79, 70, 229, 0.1)',
                borderColor: 'rgba(79, 70, 229, 1)',
                borderWidth: 2,
                tension: 0.1,
                fill: true
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return 'R$ ' + context.raw.toFixed(2).replace('.', ',');
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'R$ ' + value.toFixed(2).replace('.', ',');
                        }
                    }
                }
            }
        }
    });
});
</script>
@endpush
@endsection