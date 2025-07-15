<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Product;
use App\Models\Client;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view-reports');
    }

    public function index()
    {
        return view('reports.index');
    }

    public function sales(Request $request)
    {
        $startDate = $request->start_date ?? now()->subDays(30)->format('Y-m-d');
        $endDate = $request->end_date ?? now()->format('Y-m-d');

        // Consulta principal de vendas
        $sales = Sale::with(['client', 'user', 'items'])
            ->whereBetween('created_at', [$startDate, Carbon::parse($endDate)->endOfDay()])
            ->get();

        // Cálculo das vendas agrupadas por dia
        $salesByDate = Sale::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(total) as total'),
                DB::raw('COUNT(*) as count')
            )
            ->whereBetween('created_at', [$startDate, Carbon::parse($endDate)->endOfDay()])
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->map(function ($item) {
                return [
                    'date' => Carbon::parse($item->date)->format('d/m/Y'),
                    'total' => (float) $item->total,
                    'count' => $item->count
                ];
            });

        // Totais
        $totalSales = $sales->sum('total');
        $totalItems = $sales->sum(function($sale) {
            return $sale->items->sum('quantity');
        });

        // Métodos de pagamento para a view
        $paymentMethods = [
            'cash' => 'Dinheiro',
            'credit' => 'Cartão Crédito', 
            'debit' => 'Cartão Débito',
            'transfer' => 'Transferência'
        ];

        if ($request->export == 'pdf') {
            $pdf = Pdf::loadView('reports.sales_pdf', compact(
                'sales', 'startDate', 'endDate', 'totalSales', 'totalItems'
            ));
            return $pdf->download('relatorio-vendas-'.now()->format('d-m-Y').'.pdf');
        }

        return view('reports.sales', compact(
            'sales', 
            'startDate', 
            'endDate', 
            'totalSales', 
            'totalItems',
            'salesByDate',
            'paymentMethods'
        ));
    }

    public function products(Request $request)
    {
        // Consulta base com filtros
        $query = Product::with(['category'])
            ->when($request->category_id, function($q) use ($request) {
                $q->where('category_id', $request->category_id);
            })
            ->when($request->has('active'), function($q) use ($request) {
                $q->where('active', $request->active);
            });

        // Dados para os resumos
        $products = $query->get();
        $categories = Category::all();

        // Cálculos para os resumos
        $totalInventoryValue = $products->sum(function($product) {
            return $product->price * $product->quantity;
        });

        $lowStockCount = $products->where('quantity', '<=', DB::raw('min_quantity'))
            ->where('active', true)
            ->count();

        $inactiveCount = $products->where('active', false)->count();
        $normalStockCount = $products->where('quantity', '>', DB::raw('min_quantity'))
            ->where('active', true)
            ->count();

        // Dados para o gráfico por categoria
        $productsByCategory = Category::withCount('products')
            ->get()
            ->map(function($category) {
                return [
                    'category' => $category->name,
                    'count' => $category->products_count
                ];
            });

            
        // Exportar para PDF
        if ($request->export == 'pdf') {
            $pdf = PDF::loadView('reports.products-pdf', compact(
                'products',
                'totalInventoryValue',
                'lowStockCount',
                'inactiveCount'
            ));
            return $pdf->download('relatorio-produtos-'.now()->format('d-m-Y').'.pdf');
        }
        
        

        return view('reports.products', compact(
            'products',
            'categories',
            'totalInventoryValue',
            'lowStockCount',
            'inactiveCount',
            'normalStockCount',
            'productsByCategory'
        ));
    }

    public function clients(Request $request)
    {
        // Filtros
        $query = Client::withCount(['sales as purchases_count'])
            ->withSum('sales as total_spent', 'total')
            ->withMax('sales as last_purchase', 'created_at')
            ->when($request->search, function($q) use ($request) {
                $q->where('name', 'like', '%'.$request->search.'%')
                ->orWhere('email', 'like', '%'.$request->search.'%')
                ->orWhere('cpf', 'like', '%'.$request->search.'%');
            })
            ->when($request->date_from && $request->date_to, function($q) use ($request) {
                $q->whereHas('sales', function($query) use ($request) {
                    $query->whereBetween('created_at', [
                        Carbon::parse($request->date_from)->startOfDay(),
                        Carbon::parse($request->date_to)->endOfDay()
                    ]);
                });
            });

        // Dados para os gráficos e resumos
        $clients = $query->orderBy('total_spent', 'desc')->paginate(15);
        $totalClients = Client::count();
        $activeClients = Client::has('sales', '>', 0)->count();
        $inactiveClients = $totalClients - $activeClients;
        $totalSpent = Sale::sum('total');
        $averageSpent = $activeClients > 0 ? $totalSpent / $activeClients : 0;
        $topClients = Client::withSum('sales as total_spent', 'total')
            ->orderBy('total_spent', 'desc')
            ->limit(10)
            ->get();

        // Exportar para PDF
        if ($request->export == 'pdf') {
            $pdf = PDF::loadView('reports.clients-pdf', compact(
                'clients',
                'totalClients',
                'activeClients',
                'totalSpent',
                'averageSpent'
            ));
            return $pdf->download('relatorio-clientes-'.now()->format('d-m-Y').'.pdf');
        }

        return view('reports.clients', compact(
            'clients',
            'totalClients',
            'activeClients',
            'inactiveClients',
            'totalSpent',
            'averageSpent',
            'topClients'
        ));
    }
}
