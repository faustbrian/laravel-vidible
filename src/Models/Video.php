<?php

/*
 * This file is part of Laravel Vidible.
 *
 * (c) DraperStudio <hello@draperstudio.tech>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DraperStudio\Vidible\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Video.
 *
 * @author DraperStudio <hello@draperstudio.tech>
 */
class Video extends Model
{
    /**
     * @var string
     */
    protected $table = 'vidible_video';

    /**
     * @var array
     */
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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function vidible()
    {
        return $this->morphTo();
    }

    /**
     * @param Builder $query
     * @param $type
     * @param $id
     *
     * @return $this
     */
    public function scopeForVidible(Builder $query, $type, $id)
    {
        return $query->where('vidible_type', $type)
                        ->where('vidible_id', $id);
    }

    /**
     * @param Builder $query
     * @param $slot
     *
     * @return mixed
     */
    public function scopeInSlot(Builder $query, $slot)
    {
        return $query->whereIn('slot', (array) $slot);
    }

    /**
     * @param Builder $query
     * @param $slot
     *
     * @return mixed
     */
    public function scopeNotInSlot(Builder $query, $slot)
    {
        return $query->whereNotIn('slot', (array) $slot);
    }

    /**
     * @param Builder $query
     *
     * @return mixed
     */
    public function scopeWithoutSlot(Builder $query)
    {
        return $query->whereNull('slot');
    }

    /**
     * @param Builder $query
     *
     * @return mixed
     */
    public function scopeUnattached(Builder $query)
    {
        return $query->whereNull('vidible_id')
                        ->whereNull('vidible_type');
    }

    /**
     * @param Builder $query
     *
     * @return mixed
     */
    public function scopeAttached(Builder $query)
    {
        return $query->whereNotNull('vidible_id')
                        ->whereNotNull('vidible_type');
    }

    /**
     * @param Builder $query
     *
     * @return mixed
     */
    public function scopeHighestRes(Builder $query)
    {
        return $query->orderByRaw('(width * height) DESC');
    }

    /**
     * @param Builder $query
     *
     * @return mixed
     */
    public function scopeRandom(Builder $query)
    {
        return $query->orderBy('RAND()');
    }

    /**
     * @param Builder $query
     *
     * @return mixed
     */
    public function scopeInIntegerSlot(Builder $query)
    {
        return $query->whereRaw(sprintf('%s.slot REGEXP \'^[[:digit:]]+$\'', $query->getQuery()->from));
    }

    /**
     * @param Builder $query
     * @param $slot
     *
     * @return $this
     */
    public function scopeInNamedSlot(Builder $query, $slot)
    {
        return $query->where('slot', '=', $slot);
    }

    /**
     * @param Builder $query
     *
     * @return $this
     */
    public function scopeOnlyPortrait(Builder $query)
    {
        return $query->where('orientation', '=', 'portrait');
    }

    /**
     * @param Builder $query
     *
     * @return $this
     */
    public function scopeOnlyLandscape(Builder $query)
    {
        return $query->where('orientation', '=', 'landscape');
    }

    /**
     * @param Builder $query
     * @param $width
     *
     * @return $this
     */
    public function scopeWithMinimumWidth(Builder $query, $width)
    {
        return $query->where('width', '>=', $width);
    }

    /**
     * @param Builder $query
     * @param $height
     *
     * @return $this
     */
    public function scopeWithMinimumHeight(Builder $query, $height)
    {
        return $query->where('height', '>=', $height);
    }
}
