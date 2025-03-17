<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @author Alexis Beauvois alexisbeauvois5@gmail.com
 */
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
