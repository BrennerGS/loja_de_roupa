<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Relatório de Vendas</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h1>Relatório de Vendas</h1>
    <p>Período: {{ $startDate }} a {{ $endDate }}</p>
    
    <table>
        <thead>
            <tr>
                <th>Data</th>
                <th>Nº Venda</th>
                <th>Cliente</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sales as $sale)
            <tr>
                <td>{{ $sale->created_at->format('d/m/Y') }}</td>
                <td>{{ $sale->invoice_number }}</td>
                <td>{{ $sale->client->name ?? 'Consumidor Final' }}</td>
                <td>R$ {{ number_format($sale->total, 2, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <div style="margin-top: 20px;">
        <strong>Total de Vendas:</strong> {{ $sales->count() }}<br>
        <strong>Valor Total:</strong> R$ {{ number_format($totalSales, 2, ',', '.') }}<br>
        <strong>Total de Itens:</strong> {{ $totalItems }}
    </div>
</body>
</html>