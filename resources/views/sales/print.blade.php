<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comprovante de Venda - {{ $sale->invoice_number }}</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        @media print {
            body {
                font-size: 12px;
            }
            .no-print {
                display: none !important;
            }
            @page {
                size: auto;
                margin: 5mm;
            }
        }
    </style>
</head>
<body class="p-6">
    <div class="max-w-md mx-auto bg-white p-6 rounded shadow-sm">
        <!-- Cabeçalho -->
        <div class="text-center mb-6">
            <h1 class="text-xl font-bold">{{ config('app.name') }}</h1>
            <h4 class="font-bold">{{ $company->name }}</h4>
            <p class="text-sm text-gray-600">CNPJ: {{ $company->formatted_cnpj }}</p>
            <p class="text-sm text-gray-600">{{ $company->address }}</p>
            <p class="text-sm text-gray-600">Tel: {{ $company->formatted_phone }}</p>
        </div>
        
        <!-- Informações da Venda -->
        <div class="border-b pb-4 mb-4">
            <div class="flex justify-between items-center mb-2">
                <h2 class="text-lg font-semibold">COMPROVANTE DE VENDA</h2>
                <span class="bg-gray-100 px-2 py-1 rounded text-sm">{{ $sale->invoice_number }}</span>
            </div>
            <div class="grid grid-cols-2 gap-2 text-sm">
                <p><span class="font-medium">Data:</span> {{ $sale->created_at->format('d/m/Y H:i') }}</p>
                <p><span class="font-medium">Vendedor:</span> {{ $sale->user->name }}</p>
                <p><span class="font-medium">Pagamento:</span> {{ $paymentMethods[$sale->payment_method] ?? $sale->payment_method }}</p>
                @if($sale->client)
                    <p><span class="font-medium">Cliente:</span> {{ $sale->client->name }}</p>
                @endif
            </div>
        </div>
        
        <!-- Itens da Venda -->
        <div class="mb-4">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b">
                        <th class="text-left pb-1">Produto</th>
                        <th class="text-right pb-1">Qtd</th>
                        <th class="text-right pb-1">Unit.</th>
                        <th class="text-right pb-1">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sale->items as $item)
                    <tr class="border-b">
                        <td class="py-1">{{ $item->product->name }}</td>
                        <td class="text-right py-1">{{ $item->quantity }}</td>
                        <td class="text-right py-1">R$ {{ number_format($item->unit_price, 2, ',', '.') }}</td>
                        <td class="text-right py-1">R$ {{ number_format($item->total_price, 2, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <!-- Totais -->
        <div class="border-t pt-2 mb-6">
            <div class="flex justify-between text-sm">
                <span>Subtotal:</span>
                <span>R$ {{ number_format($sale->total - $sale->tax + $sale->discount, 2, ',', '.') }}</span>
            </div>
            @if($sale->discount > 0)
            <div class="flex justify-between text-sm">
                <span>Desconto:</span>
                <span class="text-red-600">- R$ {{ number_format($sale->discount, 2, ',', '.') }}</span>
            </div>
            @endif
            @if($sale->tax > 0)
            <div class="flex justify-between text-sm">
                <span>Taxas:</span>
                <span class="text-blue-600">+ R$ {{ number_format($sale->tax, 2, ',', '.') }}</span>
            </div>
            @endif
            <div class="flex justify-between font-bold mt-1">
                <span>TOTAL:</span>
                <span>R$ {{ number_format($sale->total, 2, ',', '.') }}</span>
            </div>
        </div>
        
        <!-- Rodapé -->
        <div class="text-center text-xs text-gray-500">
            <p>Obrigado pela preferência!</p>
            <p>{{ $company->name }} - {{ $company->email }}</p>
            <p class="mt-4">Data de emissão: {{ now()->format('d/m/Y H:i') }}</p>
        </div>
        
        <!-- Botão de impressão (não aparece na impressão) -->
        <div class="mt-6 no-print text-center">
            <button onclick="window.print()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">
                <i class="fas fa-print mr-2"></i> Imprimir
            </button>
        </div>
    </div>
</body>
</html>