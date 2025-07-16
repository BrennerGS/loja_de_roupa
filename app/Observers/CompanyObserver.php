<?php

namespace App\Observers;

use App\Models\Company;
use App\Services\ActivityLogger;
use Illuminate\Support\Facades\Log;


class CompanyObserver
{
    /**
     * Handle the Company "created" event.
     */
    public function created(Company $company): void
    {
        ActivityLogger::log(
            event: 'company_created',
            model: $company,
            newData: $company->toArray(),
            description: "Dados da empresa cadastrados"
        );
    }

    

    /**
     * Handle the Company "updated" event.
     */
    public function updated(Company $company): void
    {   
        
        $changes = $company->getChanges();
        unset($changes['updated_at']);

        if (!empty($changes)) {
            $oldData = [];
            $newData = [];
            $descriptionParts = [];

            foreach ($changes as $field => $newValue) {
                $oldValue = $company->getOriginal($field);
                
                // Tratamento especial para campos específicos
                if ($field === 'social_media') {
                    $oldValue = json_decode($oldValue, true) ?? [];
                    $newValue = json_decode($newValue, true) ?? [];
                }

                $oldData[$field] = $oldValue;
                $newData[$field] = $newValue;

                // Formatar para descrição humana
                if ($field === 'logo') {
                    $descriptionParts[] = "Logo atualizado";
                } elseif ($field === 'social_media') {
                    $descriptionParts[] = "Redes sociais atualizadas";
                } else {
                    $descriptionParts[] = "$field alterado de '{$oldValue}' para '{$newValue}'";
                }
            }

            ActivityLogger::log(
                event: 'company_updated',
                model: $company,
                oldData: $oldData,
                newData: $newData,
                description: "Dados da empresa atualizados: " . implode(', ', $descriptionParts)
            );
        }
    }

    /**
     * Handle the Company "deleted" event.
     */
    public function deleted(Company $company): void
    {
        //
    }

    /**
     * Handle the Company "restored" event.
     */
    public function restored(Company $company): void
    {
        //
    }

    /**
     * Handle the Company "force deleted" event.
     */
    public function forceDeleted(Company $company): void
    {
        //
    }
}
