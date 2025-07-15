@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="min-h-screen bg-gray-100">
    <!-- Header -->
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
            <h1 class="text-3xl font-bold text-gray-900">Dashboard</h1>
            <div class="flex items-center space-x-4">
                <span class="text-gray-600">{{ auth()->user()->name }}</span>
                <img class="h-10 w-10 rounded-full" src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=random" alt="User profile">
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <!-- Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            @if(auth()->user()->hasPermission('manage-products'))
            <!-- Products Card -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                            <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dt class="text-sm font-medium text-gray-500 truncate">Produtos Cadastrados</dt>
                            <dd class="flex items-baseline">
                                <div class="text-2xl font-semibold text-gray-900">{{ $productsCount ?? 0 }}</div>
                                <div class="ml-2">
                                    <a href="{{ route('products.index') }}" class="text-xs text-indigo-600 hover:text-indigo-500">Ver todos</a>
                                </div>
                            </dd>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            @if(auth()->user()->hasPermission('manage-products'))
            <!-- Estoque Card -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                            <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dt class="text-sm font-medium text-gray-500 truncate">Produtos com Baixo Estoque</dt>
                            <dd class="flex items-baseline">
                                <div class="text-2xl font-semibold text-gray-900">{{ $lowStockCount ?? 0 }}</div>
                                <div class="ml-2">
                                    <a href="{{ route('products.index', ['low_stock' => true]) }}" class="text-xs text-indigo-600 hover:text-indigo-500">Ver itens</a>
                                </div>
                            </dd>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            @if(auth()->user()->hasPermission('manage-sales'))
            <!-- Vendas Hoje Card -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-yellow-500 rounded-md p-3">
                            <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dt class="text-sm font-medium text-gray-500 truncate">Vendas Hoje</dt>
                            <dd class="flex items-baseline">
                                <div class="text-2xl font-semibold text-gray-900">{{ $todaySalesCount ?? 0 }}</div>
                                <div class="ml-2">
                                    <a href="{{ route('sales.index') }}" class="text-xs text-indigo-600 hover:text-indigo-500">Ver vendas</a>
                                </div>
                            </dd>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            @if(auth()->user()->hasPermission('manage-clients'))
            <!-- Clientes Card -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-purple-500 rounded-md p-3">
                            <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dt class="text-sm font-medium text-gray-500 truncate">Clientes Recentes</dt>
                            <dd class="flex items-baseline">
                                <div class="text-2xl font-semibold text-gray-900">{{ $recentClientsCount ?? 0 }}</div>
                                <div class="ml-2">
                                    <a href="{{ route('clients.index') }}" class="text-xs text-indigo-600 hover:text-indigo-500">Ver clientes</a>
                                </div>
                            </dd>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>

        @if(auth()->user()->hasPermission('manage-sales'))
        <!-- Recent Sales Section -->
        <div class="bg-white shadow rounded-lg mb-8">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Vendas Recentes</h3>
            </div>
            <div class="bg-white overflow-hidden">
                <ul class="divide-y divide-gray-200">
                    @forelse($recentSales ?? [] as $sale)
                    <li class="px-4 py-4 sm:px-6 hover:bg-gray-50">
                        <div class="flex items-center justify-between">
                            <div class="text-sm font-medium text-indigo-600 truncate">{{ $sale->invoice_number }}</div>
                            <div class="ml-2 flex-shrink-0 flex">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    {{ $sale->client->name ?? 'Consumidor Final' }} - {{ $sale->created_at->format('d/m/Y H:i') }}
                                </span>
                            </div>
                        </div>
                    </li>
                    @empty
                    <li class="px-4 py-4 sm:px-6">
                        <div class="text-center text-gray-500">Nenhuma venda recente</div>
                    </li>
                    @endforelse
                </ul>
            </div>
            <div class="px-4 py-4 sm:px-6 border-t border-gray-200">
                <a href="{{ route('sales.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">Ver todas as vendas</a>
            </div>
        </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            @if(auth()->user()->hasPermission('manage-products'))
            
            <!-- Products with Stock -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Produtos com Baixo Estoque</h3>
                </div>
                <div class="px-4 py-5 sm:p-6">
                    @forelse($lowStockProducts ?? [] as $product)
                    <div class="mb-4">
                        <h4 class="text-md font-medium text-gray-900">{{ $product->name }}</h4>
                        <p class="text-sm text-gray-500">
                            Estoque: {{ $product->quantity }} (Mín: {{ $product->min_quantity }})
                            - Categoria: {{ $product->category->name }}
                        </p>
                    </div>
                    @empty
                    <div class="text-center text-gray-500">Nenhum produto com estoque baixo</div>
                    @endforelse
                    <a href="{{ route('products.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">Ver todos os produtos</a>
                </div>
            </div>
            @endif

            <!-- Quick Actions -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Ações Rápidas</h3>
                </div>
                <div class="px-4 py-5 sm:p-6">
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        @if(auth()->user()->hasPermission('manage-sales'))
                        <a href="{{ route('sales.create') }}" class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700">
                            Nova Venda
                        </a>
                        @endif

                        @if(auth()->user()->hasPermission('manage-products'))
                        <a href="{{ route('products.create') }}" class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700">
                            Adicionar Produto
                        </a>
                        @endif

                        @if(auth()->user()->hasPermission('manage-clients'))
                        <a href="{{ route('clients.create') }}" class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700">
                            Cadastrar Cliente
                        </a>
                        @endif

                        @if(auth()->user()->hasPermission('view-reports'))
                        <a href="{{ route('reports.index') }}" class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-purple-600 hover:bg-purple-700">
                            Relatórios
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
@endsection