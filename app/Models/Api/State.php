<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    use HasFactory;

    protected $table = 'states';

    /**
     * @var array
     */
    protected $filable = [
        'country_id',
        'uf',
        'state',
    ];

    /**
     * @var array
     */
    protected $hidden = [
        'fstate',
        'created_at',
        'updated_at',
    ];

    /**
     * define phonetics attribute
     */
    public function setFstateAttribute($value)
    {
        $this->attributes['fstate'] = phonetics($value);
    }


}
