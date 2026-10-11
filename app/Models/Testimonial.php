<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Testimonial extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'author_name', 'author_role', 'company',
        'content', 'rating', 'order', 'is_active', 'publication_authorized',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'publication_authorized' => 'boolean',
        'rating' => 'integer',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('photo')->singleFile();
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('webp')
            ->format('webp')
            ->width(200)
            ->nonQueued();
    }

    public function getPhotoUrlAttribute(): ?string
    {
        return $this->getFirstMedia('photo')
            ? $this->getFirstMediaUrl('photo', 'webp')
            : null;
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true)->orderBy('order');
    }

    /**
     * Témoignages réels publiables : visibles, autorisés par leur auteur et complets
     * (nom, fonction, entreprise, citation).
     */
    public function scopePublishable(Builder $query): Builder
    {
        return $query->active()
            ->where('publication_authorized', true)
            ->whereNotNull('author_role')->where('author_role', '!=', '')
            ->where('author_name', '!=', '')
            ->where('company', '!=', '')
            ->where('content', '!=', '');
    }
}
