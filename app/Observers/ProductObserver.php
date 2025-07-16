<?php

namespace App\Observers;

use App\Models\Product;
use App\Services\ActivityLogger;

class ProductObserver
{
    /**
     * Handle the Product "created" event.
     */
    public function created(Product $product): void
    {
        ActivityLogger::log(
            event: 'created',
            model: $product,
            newData: $product->toArray(),
            description: "Produto {$product->name} criado"
        );
    }

    /**
     * Handle the Product "updated" event.
     */
    public function updated(Product $product): void
    {
        $changes = $product->getChanges();
        
        // Remove campos que não precisam ser logados
        unset($changes['updated_at']);
        
        if (!empty($changes)) {
            ActivityLogger::logChanges(
                model: $product,
                changes: $changes,
                event: 'updated'
            );
        }
    }

    /**
     * Handle the Product "deleted" event.
     */
    public function deleted(Product $product): void
    {
        ActivityLogger::log(
            event: 'moved_to_trash',
            model: $product,
            oldData: $product->toArray(),
            description: "{$product->name} movido para a lixeira"
        );
    }

    /**
     * Handle the Product "restored" event.
     */
    public function restored(Product $product): void
    {
        ActivityLogger::log(
            event: 'restored',
            model: $product,
            newData: $product->toArray(),
            description: "Produto {$product->name} restaurado da lixeira"
        );
    }

    /**
     * Handle the Product "force deleted" event.
     */
    public function forceDeleted(Product $product): void
    {
        // Registrar dados antes da exclusão permanente
        $data = $product->toArray();
        
        ActivityLogger::log(
            event: 'forceDeleted',
            model: $product,
            oldData: $data,
            description: "Produto {$product->name} removido permanentemente"
        );

        // Limpar imagem se existir
        if ($product->image) {
            \Storage::disk('public')->delete($product->image);
        }
    }
}
