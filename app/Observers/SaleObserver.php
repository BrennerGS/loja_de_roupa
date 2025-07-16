<?php

namespace App\Observers;

use App\Models\Sale;
use App\Services\ActivityLogger;

class SaleObserver
{
    /**
     * Handle the Sale "created" event.
     */
    public function created(Sale $sale): void
    {
        ActivityLogger::log(
            event: 'created',
            model: $sale,
            newData: $sale->toArray(),
            description: "Venda #{$sale->invoice_number} criada - Total: R$ " . number_format($sale->total, 2)
        );
    }

    /**
     * Handle the Sale "updated" event.
     */
    public function updated(Sale $sale): void
    {
        $changes = $sale->getChanges();
        unset($changes['updated_at']);

        if (!empty($changes)) {
            $oldData = [];
            $newData = [];
            $descriptionParts = [];

            foreach ($changes as $field => $newValue) {
                $oldValue = $sale->getOriginal($field);
                
                $oldData[$field] = $oldValue;
                $newData[$field] = $newValue;

                if ($field === 'status') {
                    $descriptionParts[] = "Status alterado de '{$oldValue}' para '{$newValue}'";
                } elseif ($field === 'total') {
                    $descriptionParts[] = "Valor total alterado de {$oldValue} para {$newValue}";
                } elseif ($field === 'payment_method') {
                    $descriptionParts[] = "Método de pagamento alterado de '{$oldValue}' para '{$newValue}'";
                } else {
                    $descriptionParts[] = "$field atualizado de '{$oldValue}' para '{$newValue}'";
                }
            }

            ActivityLogger::log(
                event: 'sale_updated',
                model: $sale,
                oldData: $oldData,
                newData: $newData,
                description: "Venda atualizada: " . implode(', ', $descriptionParts)
            );
        }
    }

    /**
     * Handle the Sale "deleted" event.
     */
    public function deleted(Sale $sale): void
    {
        ActivityLogger::log(
            event: 'deleted',
            model: $sale,
            oldData: $sale->toArray(),
            description: "Venda #{$sale->invoice_number} cancelada"
        );
    }

    /**
     * Handle the Sale "restored" event.
     */
    public function restored(Sale $sale): void
    {
        ActivityLogger::log(
            event: 'restored',
            model: $sale,
            newData: $sale->toArray(),
            description: "Venda #{$sale->invoice_number} restaurada"
        );
    }

    /**
     * Handle the Sale "force deleted" event.
     */
    public function forceDeleted(Sale $sale): void
    {
        ActivityLogger::log(
            event: 'forceDeleted',
            model: $sale,
            oldData: $sale->toArray(),
            description: "Venda #{$sale->invoice_number} removida permanentemente"
        );
    }
}
