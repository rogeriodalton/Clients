<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Neighborhood extends Model
{
    use HasFactory;

    protected $table = 'neighborhoods';

    /**
     * @var array
     */
    protected $filable = [
        'neighborhood',
    ];

    /**
     * @var array
     */
    protected $hidden = [
        'fneighborhood',
        'created_at',
        'updated_at',
    ];

    /**
     * define phonetics attribute
     */
    public function setFneighborhoodAttribute($value)
    {
        $this->attributes['fneighborhood'] = phonetics($value);
    }


}
