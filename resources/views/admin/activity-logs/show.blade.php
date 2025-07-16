@extends('layouts.app')

@section('title', 'Detalhes do Log')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Detalhes do Log</h6>
            <a href="{{ route('admin.activity-logs.index') }}" class="btn btn-sm btn-secondary">
                Voltar
            </a>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h5>Informações Básicas</h5>
                    <ul class="list-group">
                        <li class="list-group-item">
                            <strong>Data/Hora:</strong> {{ $activityLog->created_at->format('d/m/Y H:i:s') }}
                        </li>
                        <li class="list-group-item">
                            <strong>Usuário:</strong> {{ $activityLog->user->name }}
                        </li>
                        <li class="list-group-item">
                            <strong>IP:</strong> {{ $activityLog->ip_address }}
                        </li>
                        <li class="list-group-item">
                            <strong>Evento:</strong> 
                            @if($activityLog->event == 'created')
                                <span class="badge badge-success">Criação</span>
                            @elseif($activityLog->event == 'updated')
                                <span class="badge badge-primary">Atualização</span>
                            @elseif($activityLog->event == 'deleted')
                                <span class="badge badge-danger">Remoção</span>
                            @else
                                <span class="badge badge-info">{{ $activityLog->event }}</span>
                            @endif
                        </li>
                        <li class="list-group-item">
                            <strong>Modelo:</strong> {{ class_basename($activityLog->model_type) }} #{{ $activityLog->model_id }}
                        </li>
                        <li class="list-group-item">
                            <strong>Descrição:</strong> {{ $activityLog->description }}
                        </li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <h5>Alterações</h5>
                    @if($activityLog->event == 'updated')
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Campo</th>
                                    <th>Valor Antigo</th>
                                    <th>Valor Novo</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($activityLog->old_data as $field => $oldValue)
                                    @if(array_key_exists($field, $activityLog->new_data))
                                        <tr>
                                            <td>{{ $field }}</td>
                                            <td>{{ is_array($oldValue) ? json_encode($oldValue) : $oldValue }}</td>
                                            <td>{{ is_array($activityLog->new_data[$field]) ? json_encode($activityLog->new_data[$field]) : $activityLog->new_data[$field] }}</td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    @elseif($activityLog->event == 'created')
                        <pre>{{ json_encode($activityLog->new_data, JSON_PRETTY_PRINT) }}</pre>
                    @elseif($activityLog->event == 'deleted')
                        <pre>{{ json_encode($activityLog->old_data, JSON_PRETTY_PRINT) }}</pre>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection