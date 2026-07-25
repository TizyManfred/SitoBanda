<?php

namespace App\Models\Traits;

use App\Models\Attachment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

trait HasAttachments
{
    protected static function bootHasAttachments(): void
    {
        static::deleting(function (Model $model): void {
            $usesSoftDeletes = in_array(SoftDeletes::class, class_uses_recursive($model), true);

            if (! $usesSoftDeletes || $model->isForceDeleting()) {
                $model->attachments()->get()->each->delete();
            }
        });
    }

    public function attachments(): MorphMany
    {
        return $this->morphMany(Attachment::class, 'attachable')
            ->orderBy('display_order')
            ->orderBy('id');
    }
}
