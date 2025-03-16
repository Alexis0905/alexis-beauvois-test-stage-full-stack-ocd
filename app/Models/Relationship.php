<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Relationship extends Model
{
    /**
     * @var string La table
     */
    protected $table = 'relationships';

    /**
     * @var string[] Les attributs de la table
     */
    protected $fillable =
    [
        'created_by',
        'parent_id',
        'child_id'
    ];
}
