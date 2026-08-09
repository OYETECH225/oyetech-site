<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Service extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $fillable = [
        'name', 'slug', 'pole', 'icon', 'summary', 'description',
        'deliverables', 'order', 'is_active',
    ];

    protected $casts = [
        'deliverables' => 'array',
        'is_active' => 'boolean',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('cover')->singleFile();
        $this->addMediaCollection('gallery');
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('webp')
            ->format('webp')
            ->width(1200)
            ->nonQueued();

        $this->addMediaConversion('thumb')
            ->format('webp')
            ->width(600)
            ->nonQueued();
    }

    public function getCoverUrlAttribute(): ?string
    {
        return $this->getFirstMediaUrl('cover', 'webp') ?: null;
    }

    /** Projets partageant le même pôle (jointure logique, pas de clé étrangère). */
    public function projects()
    {
        return Project::where('pole', $this->pole)->get();
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopePole(Builder $query, string $pole): Builder
    {
        return $query->where('pole', $pole);
    }

    public function getUrlAttribute(): string
    {
        return route(
            in_array($this->pole, ['conseil', 'communication', 'marketing', 'solutions', 'ilepay'])
                ? "services.{$this->pole}"
                : 'services.index'
        );
    }
}
