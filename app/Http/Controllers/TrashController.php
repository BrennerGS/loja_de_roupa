<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use App\Models\ActivityLog;
use App\Models\{
    Client, 
    Product, 
    Sale, 
    Supplier
};

class TrashController extends Controller
{
    public function index()
    {
        $trashedItems = [
            'clients' => \DB::table('clients')->whereNotNull('deleted_at')->get(),
            'products' => Product::onlyTrashed()->get(),
            'suppliers' => Supplier::onlyTrashed()->get(),
        ];

        $deletedClients = \DB::table('clients')->whereNotNull('deleted_at')->get();
        logger()->debug('Clientes na lixeira:', $deletedClients->toArray());

        // Verifica se Sale usa soft delete antes de adicionar
        if (in_array('Illuminate\Database\Eloquent\SoftDeletes', class_uses(Sale::class))) {
            $trashedItems['sales'] = Sale::onlyTrashed()->get();
        }

        return view('trash.index', compact('trashedItems'));
    }

    public function destroy($model, $id)
    {
        $modelClass = $this->getModelClass($model);
        
        // Verifica se o modelo usa soft delete
        if (!in_array('Illuminate\Database\Eloquent\SoftDeletes', class_uses($modelClass))) {
            return back()->with('error', 'Este modelo não suporta exclusão reversível');
        }
        
        $item = $modelClass::onlyTrashed()->findOrFail($id);
        $item->forceDelete();

        return back()->with('success', 'Item removido permanentemente!');
    }

    public function restore(string $modelType, int $id)
    {
        try {
            $modelClass = $this->resolveModel($modelType);
            
            $item = $modelClass::withTrashed()->find($id);
            
            if (!$item) {
                return back()->with('error', "Item não encontrado na lixeira");
            }

            if (!$item->trashed()) {
                return back()->with('warning', "Este item já está ativo");
            }

            $item->restore();

            // ActivityLogger::log(
            //     event: 'item_restored',
            //     model: $item,
            //     description: "Item restaurado: $modelType ID $id"
            // );

            return back()->with('success', 'Item restaurado com sucesso!');

        } catch (\InvalidArgumentException $e) {
            dd($e);
            return back()->with('error', $e->getMessage());
        } catch (\Exception $e) {
            dd($e);
            \Log::error("Erro ao restaurar item", [
                'modelType' => $modelType,
                'id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return back()->with('error', 'Erro ao restaurar item: ' . $e->getMessage());
        }
    }

    protected function resolveModel(string $modelType): string
    {
        // Mapeamento com os nomes no plural (como vem da rota)
        $modelMap = [
            'clients' => Client::class,
            'products' => Product::class,
            'sales' => Sale::class,
            'suppliers' => Supplier::class,
        ];

        // Verifica se o modelo existe no mapeamento
        if (!array_key_exists($modelType, $modelMap)) {
            throw new \InvalidArgumentException("Tipo de modelo inválido: $modelType");
        }

        return $modelMap[$modelType];
    }

}
