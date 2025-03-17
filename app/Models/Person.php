<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @author Alexis Beauvois alexisbeauvois5@gmail.com
 */
class Person extends Model
{
    /**
     * @var string La table
     */
    protected $table = 'people';

    /**
     * @var string[] Les attributs de la table
     */
    protected $fillable =
    [
        'created_by',
        'first_name',
        'last_name',
        'birth_name',
        'middle_names',
        'date_of_birth'
    ];

    /**
     * @return HasMany Les enfants du parent_id
     */
    public function children(): HasMany
    {
        return $this->hasMany(Relationship::class, 'parent_id');
    }

    /**
     * @return HasMany Les parents du child_id
     */
    public function parents(): HasMany
    {
        return $this->hasMany(Relationship::class, 'child_id');
    }

    /**
     * @return BelongsTo La personne dont l'id est celui de created_by
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
