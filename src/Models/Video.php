<?php

namespace BrianFaust\Vidible\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $table = 'vidible_video';

    protected $fillable = [
        'vidible_id',
        'vidible_type',
        'slot',
        'width',
        'height',
        'mime_type',
        'extension',
        'orientation',
    ];

    public function vidible()
    {
        return $this->morphTo();
    }

    public function scopeForVidible(Builder $query, $type, $id)
    {
        return $query->where('vidible_type', $type)
                        ->where('vidible_id', $id);
    }

    public function scopeInSlot(Builder $query, $slot)
    {
        return $query->whereIn('slot', (array) $slot);
    }

    public function scopeNotInSlot(Builder $query, $slot)
    {
        return $query->whereNotIn('slot', (array) $slot);
    }

    public function scopeWithoutSlot(Builder $query)
    {
        return $query->whereNull('slot');
    }

    public function scopeUnattached(Builder $query)
    {
        return $query->whereNull('vidible_id')
                        ->whereNull('vidible_type');
    }

    public function scopeAttached(Builder $query)
    {
        return $query->whereNotNull('vidible_id')
                        ->whereNotNull('vidible_type');
    }

    public function scopeHighestRes(Builder $query)
    {
        return $query->orderByRaw('(width * height) DESC');
    }

    public function scopeRandom(Builder $query)
    {
        return $query->orderBy('RAND()');
    }

    public function scopeInIntegerSlot(Builder $query)
    {
        return $query->whereRaw(sprintf('%s.slot REGEXP \'^[[:digit:]]+$\'', $query->getQuery()->from));
    }

    public function scopeInNamedSlot(Builder $query, $slot)
    {
        return $query->where('slot', '=', $slot);
    }

    public function scopeOnlyPortrait(Builder $query)
    {
        return $query->where('orientation', '=', 'portrait');
    }

    public function scopeOnlyLandscape(Builder $query)
    {
        return $query->where('orientation', '=', 'landscape');
    }

    public function scopeWithMinimumWidth(Builder $query, $width)
    {
        return $query->where('width', '>=', $width);
    }

    public function scopeWithMinimumHeight(Builder $query, $height)
    {
        return $query->where('height', '>=', $height);
    }
}
