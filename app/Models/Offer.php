<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $mode
 * @property string $title
 * @property string $description
 * @property string $type
 * @property string $taxonomy
 * @property string $deleted_at
 * @property string $created_at
 * @property string $updated_at
 */
class Offer extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['mode', 'title', 'description', 'user_id', 'active', 'type', 'taxonomy', 'deleted_at', 'created_at', 'updated_at'];

    public function users()
    {
        return $this->belongsToMany(User::class,'subscriptions', 'user_id', 'offer_id');
    }
}
