<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Relatório de Clientes</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
        }
        .title {
            font-size: 18px;
            font-weight: bold;
        }
        .subtitle {
            font-size: 14px;
            color: #666;
        }
        .summary {
            margin: 15px 0;
            padding: 10px;
            background-color: #f5f5f5;
            border-radius: 5px;
        }
        .summary-item {
            display: inline-block;
            margin-right: 30px;
        }
        .summary-label {
            font-weight: bold;
            color: #555;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th {
            background-color: #f2f2f2;
            text-align: left;
            padding: 8px;
            border: 1px solid #ddd;
        }
        td {
            padding: 8px;
            border: 1px solid #ddd;
        }
        .active {
            color: #28a745;
            font-weight: bold;
        }
        .inactive {
            color: #ffc107;
            font-weight: bold;
        }
        .footer {
            margin-top: 20px;
            padding-top: 10px;
            border-top: 1px solid #ddd;
            font-size: 10px;
            text-align: center;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">Relatório de Clientes</div>
        <div class="subtitle">Gerado em: {{ now()->format('d/m/Y H:i') }}</div>
    </div>

    <div class="summary">
        <div class="summary-item">
            <span class="summary-label">Total de Clientes:</span>
            <span>{{ $totalClients }}</span>
        </div>
        <div class="summary-item">
            <span class="summary-label">Clientes Ativos:</span>
            <span>{{ $activeClients }}</span>
        </div>
        <div class="summary-item">
            <span class="summary-label">Valor Total Gasto:</span>
            <span>R$ {{ number_format($totalSpent, 2, ',', '.') }}</span>
        </div>
        <div class="summary-item">
            <span class="summary-label">Média por Cliente:</span>
            <span>R$ {{ number_format($averageSpent, 2, ',', '.') }}</span>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th width="25%">Cliente</th>
                <th width="20%">CPF</th>
                <th width="20%">Contato</th>
                <th width="10%">Total Gasto</th>
                <th width="10%">Compras</th>
                <th width="15%">Última Compra</th>
            </tr>
        </thead>
        <tbody>
            @foreach($clients as $client)
            <tr>
                <td>{{ $client->name }}</td>
                <td>{{ $client->cpf }}</td>
                <td>
                    <div>{{ $client->email }}</div>
                    <div>{{ $client->phone }}</div>
                </td>
                <td>R$ {{ number_format($client->total_spent, 2, ',', '.') }}</td>
                <td>{{ $client->purchases_count }}</td>
                <td class="{{ $client->purchases_count > 0 ? 'active' : 'inactive' }}">
                    {{ $client->last_purchase ? $client->last_purchase->format('d/m/Y') : 'Nunca comprou' }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Relatório gerado por {{ config('app.name') }} - Página {PAGENO} de {nbpg}
    </div>
</body>
</html>