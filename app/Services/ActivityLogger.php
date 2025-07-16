<?php

namespace App\Services;

use App\Models\ActivityLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;


class ActivityLogger
{
    public static function log(
        string $event,
        Model $model = null,
        array $oldData = null,
        array $newData = null,
        string $description = null
    ): void {
        $request = app(Request::class);

        $data = [
            'event' => $event,
            'model_type' => $model ? get_class($model) : null,
            'model_id' => $model?->id,
            'old_data' => $oldData,
            'new_data' => $newData,
            'description' => $description,
            'user_id' => auth()->id(),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ];

        ActivityLog::create(Arr::whereNotNull($data));
    }

    public static function logChanges(Model $model, array $changes, string $event): void
    {
        $original = Arr::only($model->getOriginal(), array_keys($changes));
        
        self::log(
            event: $event,
            model: $model,
            oldData: $original,
            newData: $changes,
            description: self::generateDescription($model, $event)
        );
    }

    protected static function generateDescription(Model $model, string $event): string
    {
        $modelName = class_basename($model);
        $userName = auth()->user()->name;

        return match ($event) {
            'created' => "{$userName} criou um novo {$modelName}",
            'updated' => "{$userName} atualizou o {$modelName} #{$model->id}",
            'deleted' => "{$userName} removeu o {$modelName} #{$model->id}",
            default => "{$userName} realizou ação '{$event}' no {$modelName} #{$model->id}",
        };
    }
}