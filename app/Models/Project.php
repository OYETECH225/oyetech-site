<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Project extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $fillable = [
        'title', 'slug', 'pole', 'client', 'sector',
        'challenge', 'solution', 'results', 'is_featured',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('gallery');
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('webp')
            ->format('webp')
            ->width(1200)
            ->nonQueued();
    }

    public function getCoverUrlAttribute(): ?string
    {
        return $this->getFirstMedia('gallery')
            ? $this->getFirstMediaUrl('gallery', 'webp')
            : null;
    }

    public function services()
    {
        return Service::where('pole', $this->pole)->get();
    }

    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', true);
    }

    public function scopePole(Builder $query, string $pole): Builder
    {
        return $query->where('pole', $pole);
    }
}
