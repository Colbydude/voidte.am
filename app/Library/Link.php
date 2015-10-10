<?php

namespace App\Library;

use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    /**
     * Fillable fields
     *
     * @var array
     */
    protected $fillable = ['url', 'hash'];
}
