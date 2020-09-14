<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Provider extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    protected $dates = ['deleted_at', 'created_at', 'updated_at'];

    public const ADAMSPAY = 1;

    /**
     * Get WebServices Data
     */
    public function webservices()
    {
        return $this->hasMany(Webservice::class, 'id', 'provider_id');
    }
}
