<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'reference', 'amount', 'status', 'concept', 'debt_provider_id', 'provider_id'
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
     * @param mixed $query
     * @param mixed $reference
     * @return boolean 
     */
    public function scopeReferenceExists($query, $reference)
    {
        return $query->where('reference', $reference)->count() > 0;
    }

}
