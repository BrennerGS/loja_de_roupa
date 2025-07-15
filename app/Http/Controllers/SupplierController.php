<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Http\Requests\SupplierRequest;

class SupplierController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:manage-suppliers');
    }

    public function index(Request $request)
    {
        $query = Supplier::when($request->search, function($q) use ($request) {
            $q->where('name', 'like', "%{$request->search}%")
              ->orWhere('contact_name', 'like', "%{$request->search}%")
              ->orWhere('email', 'like', "%{$request->search}%")
              ->orWhere('cnpj', 'like', "%{$request->search}%");
        });

        $suppliers = $query->orderBy('name')->paginate(15);
        return view('suppliers.index', compact('suppliers'));
    }

    public function create()
    {
        
        return view('suppliers.create');
    }

    public function store(SupplierRequest $request)
    {

        $data = $request->validated();
        $data['products_provided'] = explode(',', $request->products_provided);
        
        Supplier::create($data);
        return redirect()->route('suppliers.index')->with('success', 'Fornecedor cadastrado com sucesso!');
    }

    public function show(Supplier $supplier)
    {

        return view('suppliers.show', compact('supplier'));
    }

    public function edit(Supplier $supplier)
    {
        return view('suppliers.edit', compact('supplier'));
    }

    public function update(SupplierRequest $request, Supplier $supplier)
    {
        $data = $request->validated();
        $data['products_provided'] = explode(',', $request->products_provided);
        
        $supplier->update($data);
        return redirect()->route('suppliers.index')->with('success', 'Fornecedor atualizado com sucesso!');
    }

    public function destroy(Supplier $supplier)
    {
        $supplier->delete();
        return redirect()->route('suppliers.index')->with('success', 'Fornecedor removido com sucesso!');
    }
}
