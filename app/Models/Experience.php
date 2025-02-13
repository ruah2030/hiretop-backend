<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $user_id
 * @property string $name
 * @property string $desc
 * @property string $start_at
 * @property string $finshed_at
 * @property string $created_at
 * @property string $updated_at
 * @property User $user
 */
class Experience extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['user_id', 'name', 'desc', 'start_at', 'finished_at', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
