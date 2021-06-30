<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $table = 'clients';

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = ['receive_news' => 'boolean',
                        'active' => 'boolean'
    ];
    /**
     * @var array
     */
    protected $filable = [
        'name',
        'email',
        'phone',
        'zipcode',
        'address',
        'address_number',
        'receive_news',
    ];
    /**
     * @var array
     */
    protected $hidden = [
        'neighborood_id',
        'city_id',
        'fname',
        'password',
        'active',
        'created_at',
        'updated_at',
    ];
    /**
     * define phonetics attribute
     */
    public function setFnameAttribute($value)
    {
        $this->attributes['fname'] = phonetics($value);
    }


}
