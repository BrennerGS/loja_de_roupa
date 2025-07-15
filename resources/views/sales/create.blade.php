@extends('layouts.app', ['title' => 'Nova Venda'])

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <h2 class="text-2xl font-semibold mb-6">Registrar Nova Venda</h2>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        
    <form action="{{ route('sales.store') }}" method="POST" x-data="saleForm()">
        @csrf
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Coluna 1 - Dados da Venda -->
            <div class="lg:col-span-1 space-y-4">
                <div>
                    <label for="client_id" class="block text-sm font-medium text-gray-700">Cliente</label>
                    <select id="client_id" name="client_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <option value="">Consumidor Final</option>
                        @foreach($clients as $client)
                            <option value="{{ $client->id }}">{{ $client->name }} ({{ $client->phone }})</option>
                        @endforeach
                    </select>
                </div>
                
                <div>
                    <label for="payment_method" class="block text-sm font-medium text-gray-700">Forma de Pagamento *</label>
                    <select id="payment_method" name="payment_method" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <option value="cash">Dinheiro</option>
                        <option value="credit">Cartão de Crédito</option>
                        <option value="debit">Cartão de Débito</option>
                        <option value="transfer">Transferência</option>
                        <option value="pix">PIX</option>
                    </select>
                </div>
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="discount" class="block text-sm font-medium text-gray-700">Desconto (R$)</label>
                        <input type="number" step="0.01" min="0" id="discount" name="discount" x-model="discount" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>
                    <div>
                        <label for="tax" class="block text-sm font-medium text-gray-700">Taxas (R$)</label>
                        <input type="number" step="0.01" min="0" id="tax" name="tax" x-model="tax" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>
                    <div>
                        <label for="invoice_number" class="block text-sm font-medium text-gray-700">Número da Nota Fiscal</label>
                        <input type="text" id="invoice_number" name="invoice_number" required 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>
                </div>
                
                <div>
                    <label for="notes" class="block text-sm font-medium text-gray-700">Observações</label>
                    <textarea id="notes" name="notes" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
                </div>
                
                <!-- Resumo Financeiro -->
                <div class="bg-gray-50 p-4 rounded-md">
                    <div class="flex justify-between mb-2">
                        <span class="font-medium">Subtotal:</span>
                        <span x-text="'R$ ' + subtotal.toFixed(2).replace('.', ',')"></span>
                    </div>
                    <div class="flex justify-between mb-2">
                        <span class="font-medium">Desconto:</span>
                        <span class="text-red-600" x-text="'- R$ ' + Number(discount).toFixed(2).replace('.', ',')"></span>
                    </div>
                    <div class="flex justify-between mb-2">
                        <span class="font-medium">Taxas:</span>
                        <span class="text-blue-600" x-text="'+ R$ ' + Number(tax).toFixed(2).replace('.', ',')"></span>
                    </div>
                    <div class="flex justify-between text-lg font-bold border-t pt-2 mt-2">
                        <span>Total:</span>
                        <span class="text-green-600" x-text="'R$ ' + total.toFixed(2).replace('.', ',')"></span>
                    </div>
                    <input type="hidden" name="total" x-bind:value="total">
                </div>
                
                <button type="submit" @click="validateForm" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-4 rounded-md">
                    Finalizar Venda
                </button>
            </div>
            
            <!-- Coluna 2 - Produtos -->
            <div class="lg:col-span-2">
                <div class="bg-gray-50 p-4 rounded-md mb-4">
                    <h3 class="font-medium mb-2">Adicionar Produtos</h3>
                    <div class="flex space-x-2">
                        <select x-model="selectedProduct" class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <option value="">Selecione um produto</option>
                            @foreach($products as $product)
                                <option 
                                    value="{{ json_encode([
                                        'id' => $product->id,
                                        'name' => $product->name,
                                        'price' => $product->price,
                                        'stock' => $product->quantity,
                                        'sku' => $product->sku
                                    ]) }}"
                                >
                                    {{ $product->name }} ({{ $product->sku }}) - R$ {{ number_format($product->price, 2, ',', '.') }} | Estoque: {{ $product->quantity }}
                                </option>
                            @endforeach
                        </select>
                        
                        <input x-model="productQuantity" type="number" min="1" value="1" class="w-20 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        
                        <button 
                            @click="addProduct"
                            type="button"
                            class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded-md"
                        >
                            <i class="fas fa-plus"></i> Adicionar
                        </button>
                    </div>
                </div>
                
                <!-- Tabela de Itens -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produto</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Preço Unit.</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantidade</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <template x-for="(item, index) in items" :key="index">
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="font-medium text-gray-900" x-text="item.name"></div>
                                        <div class="text-sm text-gray-500" x-text="'SKU: ' + item.sku"></div>
                                        <input type="hidden" x-bind:name="'products[' + index + '][product_id]'" x-bind:value="item.id">
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900" x-text="'R$ ' + item.price.toFixed(2).replace('.', ',')"></div>
                                        <input type="hidden" x-bind:name="'products[' + index + '][unit_price]'" x-bind:value="item.price">
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900" x-text="item.quantity"></div>
                                        <input type="hidden" x-bind:name="'products[' + index + '][quantity]'" x-bind:value="item.quantity">
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900" x-text="'R$ ' + (item.price * item.quantity).toFixed(2).replace('.', ',')"></div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <button 
                                            type="button"
                                            @click="removeItem(index)"
                                            class="text-red-600 hover:text-red-900"
                                        >
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            </template>
                            
                            <tr x-show="items.length === 0">
                                <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                    Nenhum produto adicionado
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
document.addEventListener('alpine:init', () => {
    const products = @json($products->map(function($product) {
            return [
                'id' => $product->id,
                'stock' => $product->quantity
            ];
        }));

    Alpine.data('saleForm', () => ({

        
        products: products,

        selectedProduct: null,
        productQuantity: 1,
        items: [],
        discount: 0,
        tax: 0,
        
        get subtotal() {
            return this.items.reduce((sum, item) => sum + (item.price * item.quantity), 0);
        },
        
        get total() {
            return this.subtotal - Number(this.discount) + Number(this.tax);
        },
        
        addProduct() {
            if (!this.selectedProduct) {
                alert('Selecione um produto');
                return;
            }
            
            const product = JSON.parse(this.selectedProduct);
            const quantity = parseInt(this.productQuantity);
            
            if (quantity < 1) {
                alert('A quantidade deve ser pelo menos 1');
                return;
            }
            
            if (quantity > product.stock) {
                alert(`Quantidade indisponível. Disponível: ${product.stock}`);
                return;
            }
            
            // Verifica se o produto já foi adicionado
            const existingItemIndex = this.items.findIndex(item => item.id === product.id);
            
            if (existingItemIndex >= 0) {
                // Atualiza a quantidade se o produto já existir
                this.items[existingItemIndex].quantity += quantity;
            } else {
                // Adiciona novo item
                this.items.push({
                    id: product.id,
                    name: product.name,
                    price: product.price,
                    quantity: quantity,
                    sku: product.sku
                });
            }
            
            // Resetar seleção
            this.selectedProduct = null;
            this.productQuantity = 1;
        },
        
        removeItem(index) {
            this.items.splice(index, 1);
        },
        
        validateForm() {
            if (this.items.length === 0) {
                alert('Adicione pelo menos um produto para continuar');
                return false;
            }
            
            // Verifica se há produtos com quantidade maior que o estoque
            const hasInvalidQuantity = this.items.some(item => {
                const product = this.products.find(p => p.id === item.id);
                return item.quantity > product.stock;
            });
            
            if (hasInvalidQuantity) {
                alert('Um ou mais produtos têm quantidade maior que o estoque disponível');
                return false;
            }
            
            return true; // Permite o envio do formulário
        }
    }));
});
</script>
@endsection