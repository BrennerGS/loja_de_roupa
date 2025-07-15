@extends('layouts.app', ['title' => 'Relatório de Produtos'])

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 space-y-4 md:space-y-0">
        <h2 class="text-2xl font-semibold">Relatório de Produtos</h2>
        
        <div class="flex space-x-2">
            <a href="{{ route('reports.products', array_merge(request()->query(), ['export' => 'pdf'])) }}" 
               class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md flex items-center">
                <i class="fas fa-file-pdf mr-2"></i> Exportar PDF
            </a>
            <a href="{{ route('reports.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-md">
                Voltar
            </a>
        </div>
    </div>
    
    <!-- Filtros -->
    <form method="GET" action="{{ route('reports.products') }}" class="mb-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label for="category_id" class="block text-sm font-medium text-gray-700">Categoria</label>
                <select id="category_id" name="category_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    <option value="">Todas as categorias</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }} ({{ $category->type }})
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div>
                <label for="active" class="block text-sm font-medium text-gray-700">Status</label>
                <select id="active" name="active" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    <option value="">Todos</option>
                    <option value="1" {{ request('active') === '1' ? 'selected' : '' }}>Ativos</option>
                    <option value="0" {{ request('active') === '0' ? 'selected' : '' }}>Inativos</option>
                </select>
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
        <h3 class="text-lg font-medium mb-3">Resumo do Estoque</h3>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="bg-white p-3 rounded shadow">
                <p class="text-sm font-medium text-gray-500">Total de Produtos</p>
                <p class="text-2xl font-semibold text-gray-900">{{ $products->count() }}</p>
            </div>
            <div class="bg-white p-3 rounded shadow">
                <p class="text-sm font-medium text-gray-500">Valor Total em Estoque</p>
                <p class="text-2xl font-semibold text-green-600">R$ {{ number_format($totalInventoryValue, 2, ',', '.') }}</p>
            </div>
            <div class="bg-white p-3 rounded shadow">
                <p class="text-sm font-medium text-gray-500">Produtos com Baixo Estoque</p>
                <p class="text-2xl font-semibold text-red-600">{{ $lowStockCount }}</p>
            </div>
            <div class="bg-white p-3 rounded shadow">
                <p class="text-sm font-medium text-gray-500">Produtos Inativos</p>
                <p class="text-2xl font-semibold text-yellow-600">{{ $inactiveCount }}</p>
            </div>
        </div>
    </div>
    
    <!-- Tabela de Produtos -->
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produto</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Categoria</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Preço</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estoque</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Valor em Estoque</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($products as $product)
                <tr class="{{ $product->quantity <= $product->min_quantity ? 'bg-red-50' : '' }}">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            @if($product->image)
                                <div class="flex-shrink-0 h-10 w-10">
                                    <img class="h-10 w-10 rounded-full object-cover" src="{{ asset('storage/' . $product->image) }}" alt="">
                                </div>
                            @endif
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">{{ $product->name }}</div>
                                <div class="text-sm text-gray-500">{{ $product->sku }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $product->category->name }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        R$ {{ number_format($product->price, 2, ',', '.') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ $product->quantity }}</div>
                        <div class="text-xs text-gray-500">Mín: {{ $product->min_quantity }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $product->active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $product->active ? 'Ativo' : 'Inativo' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-green-600">
                        R$ {{ number_format($product->price * $product->quantity, 2, ',', '.') }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                        Nenhum produto encontrado
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <!-- Gráfico (opcional) -->
    <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white p-4 rounded-md shadow">
            <h3 class="text-lg font-medium mb-3">Produtos por Categoria</h3>
            <canvas id="categoryChart" height="200"></canvas>
        </div>
        <div class="bg-white p-4 rounded-md shadow">
            <h3 class="text-lg font-medium mb-3">Status de Estoque</h3>
            <canvas id="stockStatusChart" height="200"></canvas>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Gráfico de produtos por categoria
    const categoryCtx = document.getElementById('categoryChart').getContext('2d');
    const categoryData = @json($productsByCategory);
    
    new Chart(categoryCtx, {
        type: 'bar',
        data: {
            labels: categoryData.map(item => item.category),
            datasets: [{
                label: 'Produtos por Categoria',
                data: categoryData.map(item => item.count),
                backgroundColor: 'rgba(79, 70, 229, 0.7)',
                borderColor: 'rgba(79, 70, 229, 1)',
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
                        stepSize: 1
                    }
                }
            }
        }
    });
    
    // Gráfico de status de estoque
    const stockCtx = document.getElementById('stockStatusChart').getContext('2d');
    
    new Chart(stockCtx, {
        type: 'doughnut',
        data: {
            labels: ['Estoque Normal', 'Estoque Baixo', 'Inativos'],
            datasets: [{
                data: [{{ $normalStockCount }}, {{ $lowStockCount }}, {{ $inactiveCount }}],
                backgroundColor: [
                    'rgba(16, 185, 129, 0.7)',
                    'rgba(245, 158, 11, 0.7)',
                    'rgba(239, 68, 68, 0.7)'
                ],
                borderColor: [
                    'rgba(16, 185, 129, 1)',
                    'rgba(245, 158, 11, 1)',
                    'rgba(239, 68, 68, 1)'
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
});
</script>
@endpush
@endsection