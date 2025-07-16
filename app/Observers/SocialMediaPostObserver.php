<?php

namespace App\Observers;

use App\Models\SocialMediaPost;
use App\Services\ActivityLogger;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class SocialMediaPostObserver
{
    /**
     * Handle the SocialMediaPost "created" event.
     */
    public function created(SocialMediaPost $socialMediaPost): void
    {
        ActivityLogger::log(
            event: 'post_created',
            model: $socialMediaPost,  
            newData: $socialMediaPost->toArray(),
            description: "Novo post criado para {$socialMediaPost->platform} - Status: {$socialMediaPost->status}"
        );
    }

    /**
     * Handle the SocialMediaPost "updated" event.
     */
    public function updated(SocialMediaPost $post): void
    {
        $changes = $post->getChanges();
        unset($changes['updated_at']);

        if (!empty($changes)) {
            $oldData = [];
            $newData = [];
            $descriptionParts = [];

            foreach ($changes as $field => $newValue) {
                $oldValue = $post->getOriginal($field);
                
                // Tratamento especial para campos JSON
                if ($field === 'metrics') {
                    $oldValue = json_decode($oldValue, true);
                    $newValue = json_decode($newValue, true);
                }

                $oldData[$field] = $oldValue;
                $newData[$field] = $newValue;

                // Formatar para descrição humana
                if ($field === 'image') {
                    $descriptionParts[] = "Imagem do post atualizada";
                } elseif ($field === 'status') {
                    $descriptionParts[] = "Status alterado de '{$oldValue}' para '{$newValue}'";
                } elseif ($field === 'publish_at') {
                    $descriptionParts[] = "Data de publicação alterada de'{$oldValue}' para '{$newValue}'";
                } elseif ($field === 'caption') {
                    $descriptionParts[] = "Legenda da publicação alterada de'{$oldValue}' para '{$newValue}'";
                } else {
                    $descriptionParts[] = "$field atualizado de'{$oldValue}' para '{$newValue}'";
                }
            }

            ActivityLogger::log(
                event: 'post_updated',
                model: $post,
                oldData: $oldData,
                newData: $newData,
                description: "Post atualizado: " . implode(', ', $descriptionParts)
            );
        }
    }

    /**
     * Handle the SocialMediaPost "deleted" event.
     */
    public function deleted(SocialMediaPost $socialMediaPost): void
    {
        ActivityLogger::log(
            event: 'post_deleted',
            model: $socialMediaPost,
            oldData: $socialMediaPost->toArray(),
            description: "Post para {$socialMediaPost->platform} removido {$socialMediaPost}"
        );
        
        // Limpar imagem se existir
        if ($socialMediaPost->image) {
            \Storage::disk('public')->delete($socialMediaPost->image);
        }
    }

    /**
     * Handle the SocialMediaPost "restored" event.
     */
    public function restored(SocialMediaPost $socialMediaPost): void
    {
        ActivityLogger::log(
            event: 'post_restored',
            model: $post,
            newData: $post->toArray(),
            description: "Post para {$post->platform} restaurado da lixeira - ID: {$post->id}"
        );
    }

    /**
     * Handle the SocialMediaPost "force deleted" event.
     */
    public function forceDeleted(SocialMediaPost $socialMediaPost): void
    {
        // Registrar dados antes da exclusão permanente
        $postData = $post->toArray();
        
        ActivityLogger::log(
            event: 'post_force_deleted',
            model: $post,
            oldData: $postData,
            description: "Post para {$post->platform} removido permanentemente - ID: {$post->id}"
        );

        // Limpar imagem associada se existir
        if ($post->image) {
            Storage::disk('public')->delete($post->image);
            
            ActivityLogger::log(
                event: 'post_image_deleted',
                model: $post,
                description: "Imagem do post {$post->id} removida permanentemente"
            );
        }
    }
}
