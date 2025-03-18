<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use SplQueue;
use Illuminate\Support\Facades\DB;

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

    /**
     * @param $target_person_id L'id de la personne donnée
     * @return array|false Le degré de parenté, le temps d'exécution, le nombre de requêtes et le plus court chemin ou false
     */
    public function getDegreeWith($target_person_id): array | false
    {
        $timestart = microtime(true);
        DB::enableQueryLog();
        $queue = new SplQueue();
        $explored = [];
        $root_id = $this->id;

        $queue->enqueue([$root_id, 0]);
        $explored[] = $root_id;

        $relationships = DB::select("
            SELECT child_id, parent_id FROM relationships
        ");

        $graph = [];
        foreach ($relationships as $relationship)
        {
            $graph[$relationship->parent_id][] = $relationship->child_id;
            $graph[$relationship->child_id][] = $relationship->parent_id;
        }

        while (!$queue->isEmpty())
        {
            list($person_id, $degree) = $queue->dequeue();

            if ($degree > 25)
            {
                return false;
            }

            if ($person_id == $target_person_id)
            {
                return
                [
                    'degree' => $degree,
                    'time' => (microtime(true) - $timestart)*1000,
                    'nb_queries' => count(DB::getQueryLog()),
                    'shortest_path' => $this->rebuildShortestPath($explored, $target_person_id)
                ];
            }

            if(isset($graph[$person_id]))
            {
                foreach ($graph[$person_id] as $adjacent_person_id)
                {
                    if(!isset($explored[$adjacent_person_id]))
                    {
                        $explored[$adjacent_person_id] = $person_id;
                        $queue->enqueue([$adjacent_person_id, $degree + 1]);
                    }
                }
            }
        }

        return false;
    }

    /**
     * @param $explored Le tableau des ids des personnes explorées
     * @param $target_person_id L'id de la personne donnée
     * @return array Le tableau qui correspond au plus court chemin
     */
    private function rebuildShortestPath($explored, $target_person_id): array
    {
        $shortest_path = [];
        $root_id = $this->id;

        while ($target_person_id !== $root_id)
        {
            array_unshift($shortest_path, $target_person_id);
            $target_person_id = $explored[$target_person_id];
        }

        array_unshift($shortest_path, $root_id);

        return $shortest_path;
    }
}
