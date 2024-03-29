<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $meta_ref
 * @property string $meta_key
 * @property mixed $meta_value
 * @property string $deleted_at
 * @property string $created_at
 * @property string $updated_at
 * @property User $user
 */
class Meta extends Model
{

    CONST CULTURE = "culture";
    CONST OVERVIEW = "overview";
    CONST HISTORY = "history";
    CONST ORG_NAME = "org_name";
    /**
     * @var array
     */
    protected $fillable = ['meta_ref', 'meta_key', 'meta_value', 'deleted_at', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'meta_ref');
    }
}
