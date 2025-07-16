@extends('layouts.app')

@section('title', 'Lixeira')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold mb-6">Lixeira</h1>
    
    @foreach(['clients', 'products', 'sales', 'suppliers'] as $model)
        <div class="mb-8">
            <h2 class="text-xl font-semibold mb-4 capitalize">{{ str_replace('_', ' ', $model) }} Excluídos</h2>
            
            @if(isset($trashedItems[$model]))
            <div class="bg-white rounded-lg shadow overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nome</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Excluído em</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Ações</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($trashedItems[$model] as $item)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $item->id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ $item->name ?? $item->title ?? $item->invoice_number ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ \Carbon\Carbon::parse($item->deleted_at)->format('d/m/Y H:i') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap flex space-x-2">
                                    <form action="{{ route('trash.restore', [$model, $item->id]) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="text-indigo-600 hover:text-indigo-900">Restaurar</button>
                                    </form>
                                    <span>|</span>
                                    <form action="{{ route('trash.destroy', [$model, $item->id]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900" 
                                            onclick="return confirm('Tem certeza que deseja excluir permanentemente?')">
                                            Excluir Permanentemente
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
            @else
                <p class="text-gray-500 mb-8">Nenhum item na lixeira</p>
            @endif
        </div>
    @endforeach
</div>
@endsection