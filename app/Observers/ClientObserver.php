<?php

namespace App\Observers;

use App\Models\Client;
use App\Services\ActivityLogger;

class ClientObserver
{
    /**
     * Handle the Client "created" event.
     */
    public function created(Client $client): void
    {
        ActivityLogger::log(
            event: 'created',
            model: $client,
            newData: $client->toArray(),
            description: "Cliente {$client->name} cadastrado"
        );
    }

    /**
     * Handle the Client "updated" event.
     */
    public function updated(Client $client): void
    {
        $changes = $client->getChanges();
        unset($changes['updated_at']);

        if (!empty($changes)) {
            $oldData = [];
            $newData = [];
            $descriptionParts = [];

            foreach ($changes as $field => $newValue) {
                $oldValue = $client->getOriginal($field);
                
                $oldData[$field] = $oldValue;
                $newData[$field] = $newValue;

                if ($field === 'name') {
                    $descriptionParts[] = "Nome alterado de '{$oldValue}' para '{$newValue}'";
                } elseif ($field === 'email') {
                    $descriptionParts[] = "E-mail alterado de '{$oldValue}' para '{$newValue}'";
                } elseif ($field === 'phone') {
                    $descriptionParts[] = "Telefone alterado de '{$oldValue}' para '{$newValue}'";
                } else {
                    $descriptionParts[] = "$field atualizado de '{$oldValue}' para '{$newValue}'";
                }
            }

            ActivityLogger::log(
                event: 'client_updated',
                model: $client,
                oldData: $oldData,
                newData: $newData,
                description: "Cliente atualizado: " . implode(', ', $descriptionParts)
            );
        }
    }

    /**
     * Handle the Client "deleted" event.
     */
    public function deleted(Client $client): void
    {
        ActivityLogger::log(
            event: 'moved_to_trash',
            model: $client,
            oldData: $client->toArray(),
            description: "{$client->name} movido para a lixeira"
        );
    }

    /**
     * Handle the Client "restored" event.
     */
    public function restored(Client $client): void
    {
        ActivityLogger::log(
            event: 'restored',
            model: $client,
            newData: $client->toArray(),
            description: "Cliente {$client->name} restaurado"
        );
    }

    /**
     * Handle the Client "force deleted" event.
     */
    public function forceDeleted(Client $client): void
    {
        ActivityLogger::log(
            event: 'forceDeleted',
            model: $client,
            oldData: $client->toArray(),
            description: "Cliente {$client->name} removido permanentemente"
        );
    }
}
