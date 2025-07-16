<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Sale;
use App\Models\Client;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        
        $user = auth()->user();
        
        $data = [];
        
        // Carrega as permissões do usuário uma única vez
        $user->load('permissions');

        // Dados para produtos (se usuário tem permissão)
        if ($user->hasPermission('manage-products')) {
            $data['productsCount'] = Product::count();
            $data['lowStockCount'] = Product::whereColumn('quantity', '<=', 'min_quantity')->count();
            $data['lowStockProducts'] = Product::with('category')
                ->whereColumn('quantity', '<=', 'min_quantity')
                ->orderBy('quantity')
                ->limit(5)
                ->get();
        }

        // Dados para vendas (se usuário tem permissão)
        if ($user->hasPermission('manage-sales')) {
            $data['todaySalesCount'] = Sale::whereDate('created_at', today())->count();
            $data['recentSales'] = Sale::with('client')
                ->latest()
                ->limit(5)
                ->get();
        }

        // Dados para clientes (se usuário tem permissão)
        if ($user->hasPermission('manage-clients')) {
            $data['recentClientsCount'] = Client::where('created_at', '>=', now()->subDays(30))->count();
        }

        // Dados para relatórios (se usuário tem permissão)
        if ($user->hasPermission('view-reports')) {
            $data['monthlySales'] = Sale::whereMonth('created_at', now()->month)
                ->sum('total');
        }

        return view('home', $data);
    }
}
