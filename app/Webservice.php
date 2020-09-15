<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Webservice extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'url', 'puerto', 'ip',
    ];

    protected $dates = ['deleted_at', 'created_at', 'updated_at'];

    /**
     * Get Provider Data
     */
    public function provider()
    {
        return $this->hasOne(Provider::class, 'id', 'provider_id');
    }

    /**
     * Get Webservice Credential Data
     */
    public function webserviceCredential()
    {
        return $this->hasOne(WebserviceCredential::class, 'webservice_id', 'id');
    }

    /**
     * @param mixed $query
     * @param mixed $providerId
     * 
     */
    public function scopeWhereProviderId($query, $providerId){
        $query->where('provider_id', $providerId);
    }

}
