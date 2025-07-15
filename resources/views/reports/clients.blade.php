@extends('layouts.app', ['title' => 'Relatório de Clientes'])

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 space-y-4 md:space-y-0">
        <h2 class="text-2xl font-semibold">Relatório de Clientes</h2>
        
        <div class="flex space-x-2">
            <a href="{{ route('reports.clients', array_merge(request()->query(), ['export' => 'pdf'])) }}" 
               class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md flex items-center">
                <i class="fas fa-file-pdf mr-2"></i> Exportar PDF
            </a>
            <a href="{{ route('reports.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-md">
                Voltar
            </a>
        </div>
    </div>
    
    <!-- Filtros -->
    <form method="GET" action="{{ route('reports.clients') }}" class="mb-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label for="search" class="block text-sm font-medium text-gray-700">Pesquisar</label>
                <input type="text" id="search" name="search" value="{{ request('search') }}"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            </div>
            
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
            
            <div class="flex items-end">
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md h-[42px]">
                    <i class="fas fa-filter mr-2"></i> Filtrar
                </button>
            </div>
        </div>
    </form>
    
    <!-- Resumo -->
    <div class="mb-6 bg-gray-50 p-4 rounded-md">
        <h3 class="text-lg font-medium mb-3">Resumo Geral</h3>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="bg-white p-3 rounded shadow">
                <p class="text-sm font-medium text-gray-500">Total de Clientes</p>
                <p class="text-2xl font-semibold text-gray-900">{{ $totalClients }}</p>
            </div>
            <div class="bg-white p-3 rounded shadow">
                <p class="text-sm font-medium text-gray-500">Clientes Ativos</p>
                <p class="text-2xl font-semibold text-green-600">{{ $activeClients }}</p>
            </div>
            <div class="bg-white p-3 rounded shadow">
                <p class="text-sm font-medium text-gray-500">Valor Total Gasto</p>
                <p class="text-2xl font-semibold text-blue-600">R$ {{ number_format($totalSpent, 2, ',', '.') }}</p>
            </div>
            <div class="bg-white p-3 rounded shadow">
                <p class="text-sm font-medium text-gray-500">Média por Cliente</p>
                <p class="text-2xl font-semibold text-purple-600">R$ {{ number_format($averageSpent, 2, ',', '.') }}</p>
            </div>
        </div>
    </div>
    
    <!-- Tabela de Clientes -->
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cliente</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contato</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Gasto</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Compras</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Última Compra</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($clients as $client)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">{{ $client->name }}</div>
                                <div class="text-sm text-gray-500">{{ $client->cpf }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ $client->email }}</div>
                        <div class="text-sm text-gray-500">{{ $client->phone }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-green-600">
                        R$ {{ number_format($client->total_spent, 2, ',', '.') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $client->purchases_count }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $client->last_purchase ? $client->last_purchase->format('d/m/Y') : 'Nunca comprou' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($client->purchases_count > 0)
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                Ativo
                            </span>
                        @else
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                Inativo
                            </span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                        Nenhum cliente encontrado
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <!-- Paginação -->
    <div class="mt-4">
        {{ $clients->links() }}
    </div>
    
    <!-- Gráficos -->
    <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white p-4 rounded-md shadow">
            <h3 class="text-lg font-medium mb-3">Clientes por Status</h3>
            <canvas id="clientStatusChart" height="200"></canvas>
        </div>
        <div class="bg-white p-4 rounded-md shadow">
            <h3 class="text-lg font-medium mb-3">Top 10 Clientes</h3>
            <canvas id="topClientsChart" height="200"></canvas>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Gráfico de status dos clientes
    const statusCtx = document.getElementById('clientStatusChart').getContext('2d');
    new Chart(statusCtx, {
        type: 'doughnut',
        data: {
            labels: ['Clientes Ativos', 'Clientes Inativos'],
            datasets: [{
                data: [{{ $activeClients }}, {{ $inactiveClients }}],
                backgroundColor: [
                    'rgba(40, 167, 69, 0.7)',
                    'rgba(255, 193, 7, 0.7)'
                ],
                borderColor: [
                    'rgba(40, 167, 69, 1)',
                    'rgba(255, 193, 7, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'right'
                }
            }
        }
    });
    
    // Gráfico de top clientes
    const topClientsCtx = document.getElementById('topClientsChart').getContext('2d');
    new Chart(topClientsCtx, {
        type: 'bar',
        data: {
            labels: @json($topClients->pluck('name')),
            datasets: [{
                label: 'Valor Gasto (R$)',
                data: @json($topClients->pluck('total_spent')),
                backgroundColor: 'rgba(13, 110, 253, 0.7)',
                borderColor: 'rgba(13, 110, 253, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'R$ ' + value.toLocaleString('pt-BR');
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