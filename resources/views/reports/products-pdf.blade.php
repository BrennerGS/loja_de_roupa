<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Relatório de Produtos</title>
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
        .header img {
            height: 60px;
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
        .low-stock {
            background-color: #fff3f3;
        }
        .inactive {
            background-color: #fff8e6;
        }
        .status-active {
            color: #28a745;
            font-weight: bold;
        }
        .status-inactive {
            color: #dc3545;
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
        <div class="title">Relatório de Produtos</div>
        <div class="subtitle">Gerado em: {{ now()->format('d/m/Y H:i') }}</div>
    </div>

    <div class="summary">
        <div class="summary-item">
            <span class="summary-label">Total de Produtos:</span>
            <span>{{ $products->count() }}</span>
        </div>
        <div class="summary-item">
            <span class="summary-label">Valor Total em Estoque:</span>
            <span>R$ {{ number_format($totalInventoryValue, 2, ',', '.') }}</span>
        </div>
        <div class="summary-item">
            <span class="summary-label">Produtos com Baixo Estoque:</span>
            <span>{{ $lowStockCount }}</span>
        </div>
        <div class="summary-item">
            <span class="summary-label">Produtos Inativos:</span>
            <span>{{ $inactiveCount }}</span>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th width="25%">Produto</th>
                <th width="15%">Código</th>
                <th width="15%">Categoria</th>
                <th width="10%">Preço</th>
                <th width="10%">Estoque</th>
                <th width="10%">Mínimo</th>
                <th width="10%">Status</th>
                <th width="15%">Valor Estoque</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
            <tr class="{{ $product->quantity <= $product->min_quantity ? 'low-stock' : '' }} {{ !$product->active ? 'inactive' : '' }}">
                <td>{{ $product->name }}</td>
                <td>{{ $product->sku }}</td>
                <td>{{ $product->category->name }}</td>
                <td>R$ {{ number_format($product->price, 2, ',', '.') }}</td>
                <td>{{ $product->quantity }}</td>
                <td>{{ $product->min_quantity }}</td>
                <td class="status-{{ $product->active ? 'active' : 'inactive' }}">
                    {{ $product->active ? 'Ativo' : 'Inativo' }}
                </td>
                <td>R$ {{ number_format($product->price * $product->quantity, 2, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Relatório gerado por {{ config('app.name') }} - Página {PAGENO} de {nbpg}
    </div>
</body>
</html>