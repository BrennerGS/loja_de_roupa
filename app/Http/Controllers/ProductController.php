<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ProductRequest;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:manage-products');
    }
    
    public function index(Request $request)
    {
        $this->authorize('manage-products');

        $qtd_page = $request->has('qtd_page') ? $request->query('qtd_page') : 15;

        $query = Product::with('category')
            ->when($request->search, function($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                  ->orWhere('sku', 'like', "%{$request->search}%")
                  ->orWhere('description', 'like', "%{$request->search}%");
            })
            ->when($request->category_id, function($q) use ($request) {
                $q->where('category_id', $request->category_id);
            })
            ->when($request->size, function($q) use ($request) {
                $q->where('size', $request->size);
            })
            ->when($request->color, function($q) use ($request) {
                $q->where('color', $request->color);
            })
            ->when($request->active !== null, function($q) use ($request) {
                $q->where('active', $request->active);
            });
            
        // Sempre usar paginate, mesmo para baixo estoque
        $products = $query->when($request->has('low_stock'), function($q) {
                $q->lowStock();
            })
            ->paginate($qtd_page)
            ->withQueryString(); // Mantém os parâmetros da URL na paginação
            
        $categories = Category::all();
        $sizes = Product::distinct('size')->pluck('size');
        $colors = Product::distinct('color')->pluck('color');
        
        return view('products.index', compact('products', 'categories', 'sizes', 'colors'));
    }
    
    public function create()
    {
        $this->authorize('manage-products');

        $categories = Category::all();
        return view('products.create', compact('categories'));
    }
    
    public function store(ProductRequest $request)
    {

        $this->authorize('manage-products');

        $data = $request->validated();
        
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }
        
        $product = Product::create($data);
        
        // Registrar entrada no estoque
        $product->inventoryMovements()->create([
            'quantity' => $product->quantity,
            'movement_type' => 'entrada',
            'user_id' => auth()->id(),
            'notes' => 'Cadastro inicial do produto'
        ]);
        
        return redirect()->route('products.index')->with('success', 'Produto cadastrado com sucesso!');
    }
    
    public function edit(Product $product)
    {
        $this->authorize('manage-products');

        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }
    
    public function update(ProductRequest $request, Product $product)
    {
        $this->authorize('manage-products');

        $data = $request->validated();
        
        if ($request->hasFile('image')) {
            // Remove a imagem antiga se existir
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $request->file('image')->store('products', 'public');
        }
        
        $product->update($data);
        
        return redirect()->route('products.index')->with('success', 'Produto atualizado com sucesso!');
    }
    
    public function destroy(Product $product)
    {
        $this->authorize('manage-products');

        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Produto removido com sucesso!');
    }
    
    public function inventoryHistory(Product $product)
    {
        $this->authorize('manage-products');

        $movements = $product->inventoryMovements()->with('user')->latest()->paginate(10);
        return view('products.inventory-history', compact('product', 'movements'));
    }
    
    public function adjustInventory(Request $request, Product $product)
    {
        $this->authorize('manage-products');
        
        $request->validate([
            'quantity' => 'required|integer|min:1',
            'type' => 'required|in:entrada,saida',
            'notes' => 'nullable|string'
        ]);
        
        $quantity = $request->type === 'entrada' 
            ? $request->quantity 
            : -$request->quantity;
            
        $product->increment('quantity', $quantity);
        
        $product->inventoryMovements()->create([
            'quantity' => $request->quantity,
            'movement_type' => $request->type,
            'user_id' => auth()->id(),
            'notes' => $request->notes
        ]);
        
        return back()->with('success', 'Estoque ajustado com sucesso!');
    }
}
