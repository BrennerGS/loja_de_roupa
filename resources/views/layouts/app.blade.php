<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }} - @yield('title')</title>
    
    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Alpine JS -->
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.2/dist/alpine.min.js" defer></script>
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex flex-col">
        <!-- Header -->
        <header class="bg-indigo-700 text-white shadow-md">
            <div class="container mx-auto px-4 py-3 flex justify-between items-center">
                <div class="flex items-center space-x-4">
                    <a href="{{ route('dashboard') }}" class="text-2xl font-bold">
                        {{ config('app.name') }}
                    </a>
                    @auth
                    <nav class="hidden md:flex space-x-1">
                        @if(auth()->user()->hasPermission('manage-products'))
                            <a href="{{ route('products.index') }}" class="px-3 py-2 rounded hover:bg-indigo-600 {{ request()->routeIs('products.*') ? 'bg-indigo-800' : '' }}">
                                Produtos
                            </a>
                        @endif
                        @if(auth()->user()->hasPermission('manage-sales'))
                            <a href="{{ route('sales.index') }}" class="px-3 py-2 rounded hover:bg-indigo-600 {{ request()->routeIs('sales.*') ? 'bg-indigo-800' : '' }}">
                                Vendas
                            </a>
                        @endif
                        @if(auth()->user()->hasPermission('manage-clients'))
                            <a href="{{ route('clients.index') }}" class="px-3 py-2 rounded hover:bg-indigo-600 {{ request()->routeIs('clients.*') ? 'bg-indigo-800' : '' }}">
                                Clientes
                            </a>
                        @endif
                        @if(auth()->user()->hasPermission('manage-suppliers'))
                            <a href="{{ route('suppliers.index') }}" class="px-3 py-2 rounded hover:bg-indigo-600 {{ request()->routeIs('suppliers.*') ? 'bg-indigo-800' : '' }}">
                                Fornecedores
                            </a>
                        @endif
                        @if(auth()->user()->hasPermission('view-reports'))
                            <a href="{{ route('reports.index') }}" class="px-3 py-2 rounded hover:bg-indigo-600 {{ request()->routeIs('reports.*') ? 'bg-indigo-800' : '' }}">
                                Relatórios
                            </a>
                        @endif
                        @if(auth()->user()->hasPermission('manage-social'))
                            <a href="{{ route('social.index') }}" class="px-3 py-2 rounded hover:bg-indigo-600 {{ request()->routeIs('social.*') ? 'bg-indigo-800' : '' }}">
                                Redes Sociais
                            </a>
                        @endif
                        @if(auth()->user()->hasPermission('manage-settings'))
                            <a href="{{ route('settings.index') }}" class="px-3 py-2 rounded hover:bg-indigo-600 {{ request()->routeIs('settings.*') ? 'bg-indigo-800' : '' }}">
                                Configurações
                            </a>
                        @endif
                        
                    </nav>

                    @endauth
                </div>
                
                @auth
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" class="flex items-center space-x-2 focus:outline-none">
                        <span class="font-medium">{{ auth()->user()->name }}</span>
                        <i class="fas fa-chevron-down text-xs transition-transform duration-200" :class="{ 'transform rotate-180': open }"></i>
                    </button>
                    
                    <div x-show="open" @click.away="open = false" 
                         x-transition:enter="transition ease-out duration-100"
                         x-transition:enter-start="transform opacity-0 scale-95"
                         x-transition:enter-end="transform opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="transform opacity-100 scale-100"
                         x-transition:leave-end="transform opacity-0 scale-95"
                         class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
                        <a href="{{ route('profile') }}" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">
                            <i class="fas fa-user mr-2"></i> Perfil
                        </a>
                        @can('manage-trash')
                            <a href="{{ route('trash.index') }}" class="block px-4 py-2 text-gray-800 hover:bg-gray-100 ">
                               <i class="fas fa-trash mr-2"></i> Lixeira
                            </a>
                        @endcan
                        @can('view-activity-logs')
                            <a href="{{ route('admin.activity-logs.index') }}" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">
                               <i class="fas fa-history mr-2"></i> Historico
                            </a>
                        @endcan
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 text-gray-800 hover:bg-gray-100">
                                <i class="fas fa-sign-out-alt mr-2"></i> Sair
                            </button>
                        </form>
                    </div>
                </div>
                @endauth
            </div>
        </header>
        
        <!-- Mobile Menu -->
        @auth
        <div class="bg-indigo-600 text-white md:hidden">
            <div class="container mx-auto px-4 py-2">
                <nav class="flex overflow-x-auto space-x-4 py-2">
                    @if(auth()->user()->hasPermission('manage-products'))
                        <a href="{{ route('products.index') }}" class="px-3 py-1 rounded hover:bg-indigo-500 whitespace-nowrap {{ request()->routeIs('products.*') ? 'bg-indigo-700' : '' }}">
                            Produtos
                        </a>
                    @endif
                    @if(auth()->user()->hasPermission('manage-sales'))
                        <a href="{{ route('sales.index') }}" class="px-3 py-1 rounded hover:bg-indigo-500 whitespace-nowrap {{ request()->routeIs('sales.*') ? 'bg-indigo-700' : '' }}">
                            Vendas
                        </a>
                    @endif
                    @if(auth()->user()->hasPermission('manage-clients'))
                        <a href="{{ route('clients.index') }}" class="px-3 py-1 rounded hover:bg-indigo-500 whitespace-nowrap {{ request()->routeIs('clients.*') ? 'bg-indigo-700' : '' }}">
                            Clientes
                        </a>
                    @endif
                    @if(auth()->user()->hasPermission('manage-suppliers'))
                        <a href="{{ route('suppliers.index') }}" class="px-3 py-1 rounded hover:bg-indigo-500 whitespace-nowrap {{ request()->routeIs('suppliers.*') ? 'bg-indigo-700' : '' }}">
                            Fornecedores
                        </a>
                    @endif
                    @if(auth()->user()->hasPermission('view-reports'))
                        <a href="{{ route('reports.index') }}" class="px-3 py-1 rounded hover:bg-indigo-500 whitespace-nowrap {{ request()->routeIs('reports.*') ? 'bg-indigo-700' : '' }}">
                            Relatórios
                        </a>
                    @endif
                </nav>
            </div>
        </div>
        @endauth
        
        <!-- Main Content -->
        <main class="flex-grow container mx-auto px-4 py-6">
            @yield('content')
        </main>
        
        <!-- Footer -->
        <footer class="bg-gray-800 text-white py-4">
            <div class="container mx-auto px-4 text-center">
                <p>&copy; {{ date('Y') }} {{ config('app.name') }}. Todos os direitos reservados.</p>
            </div>
        </footer>
    </div>
    
    @stack('scripts')
</body>
</html>