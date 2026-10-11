<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class TeamMember extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'name', 'role', 'bio', 'linkedin_url', 'order', 'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('photo')->singleFile();
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('webp')
            ->format('webp')
            ->width(400)
            ->nonQueued();
    }

    public function getPhotoUrlAttribute(): ?string
    {
        return $this->getFirstMedia('photo')
            ? $this->getFirstMediaUrl('photo', 'webp')
            : null;
    }

    /**
     * Nom affiché au format unique « Prénom NOM » (ex. « Yamoussa KOUYATE »), quelle que
     * soit la saisie : un mot déjà en capitales est pris comme nom de famille et placé
     * en dernier ; sinon le dernier mot est le nom de famille.
     */
    public function getDisplayNameAttribute(): string
    {
        $words = preg_split('/\s+/u', trim((string) $this->name)) ?: [];

        if (count($words) < 2) {
            return trim((string) $this->name);
        }

        $isUpper = fn (string $w) => mb_strlen($w) > 1 && $w === mb_strtoupper($w) && $w !== mb_strtolower($w);
        $lastNames = array_values(array_filter($words, $isUpper));
        $firstNames = array_values(array_filter($words, fn ($w) => ! $isUpper($w)));

        if (! $lastNames) {
            $lastNames = [array_pop($firstNames)];
        }

        $firstNames = array_map(
            fn (string $w) => mb_convert_case(mb_strtolower($w), MB_CASE_TITLE),
            $firstNames
        );

        return implode(' ', [...$firstNames, ...array_map('mb_strtoupper', $lastNames)]);
    }

    /** Initiales pour l'avatar de remplacement quand la photo manque. */
    public function getInitialsAttribute(): string
    {
        return collect(preg_split('/\s+/u', $this->display_name))
            ->filter()
            ->map(fn (string $w) => mb_strtoupper(mb_substr($w, 0, 1)))
            ->take(2)
            ->implode('');
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true)->orderBy('order');
    }
}
