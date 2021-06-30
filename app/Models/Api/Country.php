<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    protected $table = 'countries';

    /**
     * @var array
     */
    protected $filable = [
        'country',
    ];

    /**
     * @var array
     */
    protected $hidden = [
        'fcountry',
        'created_at',
        'updated_at',
    ];

    /**
     * define phonetics attribute
     */
    public function setFcountryAttribute($value)
    {
        $this->attributes['fcountry'] = phonetics($value);
    }


}
