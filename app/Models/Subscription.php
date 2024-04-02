<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $user_id
 * @property integer $offer_id
 * @property string $step
 * @property string $created_at
 * @property string $updated_at
 * @property Offer $offer
 * @property User $user
 */
class Subscription extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['user_id', 'offer_id', 'step', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function offer()
    {
        return $this->belongsToMany(Offer::class, 'subscriptions')->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsToMany(User::class, 'subscriptions')->withTimestamps();
    }
}
