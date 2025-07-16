<?php

namespace App\Observers;

use App\Models\Supplier;
use App\Services\ActivityLogger;
use Illuminate\Support\Facades\Storage;

class SupplierObserver
{
    /**
     * Handle the Supplier "created" event.
     */
    public function created(Supplier $supplier): void
    {
        ActivityLogger::log(
            event: 'created',
            model: $supplier,
            newData: $supplier->toArray(),
            description: "Novo fornecedor cadastrado: {$supplier->name} "
        );
    }

    /**
     * Handle the Supplier "updated" event.
     */
    public function updated(Supplier $supplier): void
    {
        $changes = $supplier->getChanges();
        unset($changes['updated_at']);

        if (!empty($changes)) {
            $oldData = [];
            $newData = [];
            $descriptionParts = [];

            foreach ($changes as $field => $newValue) {
                $oldValue = $supplier->getOriginal($field);
                
                if ($field === 'products_provided') {
                    if (is_string($oldValue)) {
                        $oldValue = json_decode($oldValue, true);
                    }

                    if (is_string($newValue)) {
                        $newValue = json_decode($newValue, true);
                    }
                }


                $oldData[$field] = $oldValue;
                $newData[$field] = $newValue;

                if ($field === 'name') {
                    $descriptionParts[] = "Nome do fornecedor alterado de '{$oldValue}' para '{$newValue}'";
                } elseif ($field === 'cnpj') {
                    $descriptionParts[] = "CNPJ atualizado";
                } elseif ($field === 'products_provided') {
                    $descriptionParts[] = "Produtos fornecidos atualizados";
                } else {
                    $descriptionParts[] = "$field atualizado de '{$oldValue}' para '{$newValue}'";
                }
            }

            ActivityLogger::log(
                event: 'supplier_updated',
                model: $supplier,
                oldData: $oldData,
                newData: $newData,
                description: "Fornecedor atualizado: " . implode(', ', $descriptionParts)
            );
        }
    }

    /**
     * Handle the Supplier "deleted" event.
     */
    public function deleted(Supplier $supplier): void
    {
        ActivityLogger::log(
            event: 'moved_to_trash',
            model: $supplier,
            oldData: $supplier->toArray(),
            description: "{$supplier->name} movido para a lixeira"
        );
    }

    /**
     * Handle the Supplier "restored" event.
     */
    public function restored(Supplier $supplier): void
    {
        ActivityLogger::log(
            event: 'restored',
            model: $supplier,
            newData: $supplier->toArray(),
            description: "Fornecedor {$supplier->name} restaurado"
        );
    }

    /**
     * Handle the Supplier "force deleted" event.
     */
    public function forceDeleted(Supplier $supplier): void
    {
        // Limpar documentos anexados se existirem
        if ($supplier->documents) {
            Storage::disk('supplier_docs')->delete($supplier->documents);
        }
        
        ActivityLogger::log(
            event: 'forceDeleted',
            model: $supplier,
            oldData: $supplier->toArray(),
            description: "Fornecedor {$supplier->name} removido permanentemente"
        );
    }
}
