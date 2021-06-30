<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    protected $table = 'cities';

    /**
     * @var array
     */
    protected $filable = [
        'state_id',
        'country_id',
        'city',
    ];

    /**
     * @var array
     */
    protected $hidden = [
        'fcity',
        'created_at',
        'updated_at',
    ];

    /**
     * define phonetics attribute
     */
    public function setFcityAttribute($value)
    {
        $this->attributes['fcity'] = phonetics($value);
    }


}
