<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Client;
use App\Models\Product;
use App\Models\SaleItem;
use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Requests\SaleRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SaleController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:manage-sales');
    }

    public function index(Request $request)
    {
        $this->authorize('manage-sales');

        $query = Sale::with(['client', 'user', 'items'])
            ->when($request->date_from, function($q) use ($request) {
                $q->whereDate('created_at', '>=', $request->date_from);
            })
            ->when($request->date_to, function($q) use ($request) {
                $q->whereDate('created_at', '<=', $request->date_to);
            })
            ->when($request->client_id, function($q) use ($request) {
                $q->where('client_id', $request->client_id);
            })
            ->when($request->payment_method, function($q) use ($request) {
                $q->where('payment_method', $request->payment_method);
            });

        $sales = $query->latest()->paginate(15);
        $clients = Client::all();
        $paymentMethods = ['cash' => 'Dinheiro', 'credit' => 'Cartão Crédito', 'debit' => 'Cartão Débito', 'transfer' => 'Transferência'];

        return view('sales.index', compact('sales', 'clients', 'paymentMethods'));
    }

    public function create()
    {
        
        $this->authorize('manage-sales');

        $products = Product::active()->get();
        $clients = Client::all();
        return view('sales.create', compact('products', 'clients'));
    }

    public function store(SaleRequest $request)
    {

        $this->authorize('manage-sales');

        DB::beginTransaction();
    
        try {
            
            // 1. Criar a venda
            $sale = Sale::create([
                'invoice_number' => 'VENDA-' . now()->format('YmdHis') . '-' . Str::upper(Str::random(4)),
                'client_id' => $request->client_id,
                'user_id' => auth()->id(),
                'payment_method' => $request->payment_method,
                'discount' => $request->discount ?? 0,
                'tax' => $request->tax ?? 0,
                'notes' => $request->notes,
                'total' => 0 // Será calculado
            ]);

            

            // 2. Adicionar produtos
            $total = 0;
            $items = [];

           foreach ($request->products as $productData) {
                $product = Product::findOrFail($productData['product_id']);
                
                $unitPrice = $product->price;
                $quantity = $productData['quantity'];
                $itemTotal = $unitPrice * $quantity;
                
                // Criar item da venda
                $sale->items()->create([
                    'product_id' => $product->id,
                    'unit_price' => $unitPrice,
                    'quantity' => $quantity,
                    'total_price' => $itemTotal
                ]);
                
                $total += $itemTotal;
                
                // Atualizar estoque
                $product->decrement('quantity', $quantity);
            }

            // Calcular total com desconto e taxa
            $finalTotal = ($total - $request->discount) + $request->tax;
            

            // Atualizar total da venda
            $sale->update(['total' => $finalTotal]);

            DB::commit();
            

            return redirect()->route('sales.index')
                ->with('success', 'Venda finalizada com sucesso!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Erro ao finalizar venda: ' . $e->getMessage());
        }
    }

    public function show(Sale $sale)
    {
        $this->authorize('manage-sales');

        $sale->load(['client', 'user', 'items.product']);
        return view('sales.show', compact('sale'));
    }

    public function print(Sale $sale)
    {   
        $this->authorize('manage-sales');
        
        $company = Company::firstOrNew();

        $sale->load(['client', 'items.product']);
        return view('sales.print', compact('sale', 'company'));
    }
}
