<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WebserviceCredential extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'auth_type_id', 'user', 'password', 'client_id', 'client_secret', 'api_key', 'webservice_id'
    ];

    protected $dates = ['deleted_at', 'created_at', 'updated_at'];

    /**
     * Get WebService Data
     */
    public function webservice()
    {
        return $this->hasOne(Webservice::class, 'id', 'webservice_id');
    }
}
