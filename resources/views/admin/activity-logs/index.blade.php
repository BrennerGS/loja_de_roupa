@extends('layouts.app')

@section('title', 'Logs de Atividade')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Logs de Atividade</h6>
            <div class="dropdown no-arrow">
                <a class="dropdown-toggle" href="#" role="button" id="filterDropdown" 
                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-filter fa-sm fa-fw"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" 
                     aria-labelledby="filterDropdown">
                    <form class="px-4 py-3" method="GET">
                        <div class="form-group">
                            <label for="user_id">Usuário</label>
                            <select class="form-control" id="user_id" name="user_id">
                                <option value="">Todos</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" 
                                        {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="event">Evento</label>
                            <select class="form-control" id="event" name="event">
                                <option value="">Todos</option>
                                <option value="created" {{ request('event') == 'created' ? 'selected' : '' }}>Criação</option>
                                <option value="updated" {{ request('event') == 'updated' ? 'selected' : '' }}>Atualização</option>
                                <option value="deleted" {{ request('event') == 'deleted' ? 'selected' : '' }}>Remoção</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="model_type">Modelo</label>
                            <select class="form-control" id="model_type" name="model_type">
                                <option value="">Todos</option>
                                <option value="Product" {{ request('model_type') == 'Product' ? 'selected' : '' }}>Produtos</option>
                                <option value="Sale" {{ request('model_type') == 'Sale' ? 'selected' : '' }}>Vendas</option>
                                <option value="Client" {{ request('model_type') == 'Client' ? 'selected' : '' }}>Clientes</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Filtrar</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Data/Hora</th>
                            <th>Usuário</th>
                            <th>Ação</th>
                            <th>Modelo</th>
                            <th>Detalhes</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($logs as $log)
                        <tr>
                            <td>{{ $log->created_at->format('d/m/Y H:i') }}</td>
                            <td>{{ $log->user->name }}</td>
                            <td>
                                @if($log->event == 'created')
                                    <span class="badge badge-success">Criado</span>
                                @elseif($log->event == 'updated')
                                    <span class="badge badge-primary">Atualizado</span>
                                @elseif($log->event == 'deleted')
                                    <span class="badge badge-danger">Removido</span>
                                @else
                                    <span class="badge badge-info">{{ $log->event }}</span>
                                @endif
                            </td>
                            <td>{{ class_basename($log->model_type) }} #{{ $log->model_id }}</td>
                            <td>
                                <a href="{{ route('admin.activity-logs.show', $log) }}" 
                                   class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">Nenhum registro encontrado</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $logs->links() }}
        </div>
    </div>
</div>
@endsection