@extends('layouts.app', ['title' => 'Configurações'])

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <h2 class="text-2xl font-semibold mb-6">Configurações do Sistema</h2>
    
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <!-- Menu Lateral -->
        <div class="md:col-span-1">
            <nav class="space-y-1">
                <a href="#" class="bg-indigo-50 border-indigo-500 text-indigo-700 group flex items-center px-3 py-2 text-sm font-medium border-l-4">
                    <i class="fas fa-building text-indigo-500 mr-3"></i>
                    Empresa
                </a>
                <a href="{{ route('settings.users') }}" class="border-transparent text-gray-600 hover:bg-gray-50 hover:text-gray-900 group flex items-center px-3 py-2 text-sm font-medium border-l-4">
                    <i class="fas fa-users text-gray-400 group-hover:text-gray-500 mr-3"></i>
                    Usuários e Permissões
                </a>
            </nav>
        </div>
        
        <!-- Conteúdo - Configurações da Empresa -->
        <div class="md:col-span-3">
            <h3 class="text-lg font-medium mb-4">Dados da Empresa</h3>
            
            <form action="{{ route('settings.update-company') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="grid grid-cols-1 gap-6 mb-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Nome da Empresa *</label>
                        <input type="text" id="name" name="name" value="{{ $company->name }}" required
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>
                    
                    <div>
                        <label for="address" class="block text-sm font-medium text-gray-700">Endereço *</label>
                        <input type="text" id="address" name="address" value="{{ $company->address }}" required
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700">Telefone *</label>
                            <input type="text" id="phone" name="phone" value="{{ $company->phone }}" required
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>
                        
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Email *</label>
                            <input type="email" id="email" name="email" value="{{ $company->email }}" required
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>
                    </div>
                    
                    <div>
                        <label for="cnpj" class="block text-sm font-medium text-gray-700">CNPJ *</label>
                        <input type="text" id="cnpj" name="cnpj" value="{{ $company->cnpj }}" required
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>
                    
                    <div>
                        <label for="logo" class="block text-sm font-medium text-gray-700">Logo</label>
                        <input type="file" id="logo" name="logo" accept="image/*"
                               class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                        @if($company->logo)
                            <div class="mt-2 flex items-center">
                                <img src="{{ asset('storage/' . $company->logo) }}" alt="Logo da empresa" class="h-16">
                                <span class="ml-2 text-sm text-gray-500">Logo atual</span>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Redes Sociais -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Redes Sociais</label>
                        <div class="mt-1 grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="social_media_instagram" class="sr-only">Instagram</label>
                                <div class="relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fab fa-instagram text-purple-500"></i>
                                    </div>
                                    <input type="text" id="social_media_instagram" name="social_media[instagram]" 
                                           value="{{ $company->social_media['instagram'] ?? '' }}"
                                           class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-10 sm:text-sm border-gray-300 rounded-md"
                                           placeholder="@seuinstagram">
                                </div>
                            </div>
                            <div>
                                <label for="social_media_facebook" class="sr-only">Facebook</label>
                                <div class="relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fab fa-facebook text-blue-600"></i>
                                    </div>
                                    <input type="text" id="social_media_facebook" name="social_media[facebook]" 
                                           value="{{ $company->social_media['facebook'] ?? '' }}"
                                           class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-10 sm:text-sm border-gray-300 rounded-md"
                                           placeholder="fb.com/suapagina">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="flex justify-end">
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md">
                        Salvar Configurações
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection