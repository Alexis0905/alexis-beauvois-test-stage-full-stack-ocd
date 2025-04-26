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
     * @param $target_person_id L'id de la personne cible
     * @return array|false Le degré de parenté, le temps d'exécution, le nombre de requêtes et le plus court chemin ou false
     */
    public function getDegreeWith($target_person_id): array|false
    {
        $memstart = memory_get_usage();
        $timestart = microtime(true);
        DB::enableQueryLog();

        $queue_root = new SplQueue();
        $queue_target = new SplQueue();
        $explored_root = [];
        $explored_target = [];
        $root_id = $this->id;

        $queue_root->enqueue([$root_id, 0]);
        $queue_target->enqueue([$target_person_id, 0]);

        $explored_root[$root_id] = ['person_id' => null, 'degree' => 0];
        $explored_target[$target_person_id] = ['person_id' => null, 'degree' => 0];

        $degree = null;
        $intersect_person_id = null;

        while (!$queue_root->isEmpty() && !$queue_target->isEmpty())
        {
            $result = $this->ProgressInGraph($queue_root, $explored_root, $explored_target);
            if ($result !== null)
            {
                $intersect_person_id = $result['intersect_person'];
                $degree = $result['degree'];
                break;
            }

            $result = $this->ProgressInGraph($queue_target, $explored_target, $explored_root);
            if ($result !== null)
            {
                $intersect_person_id = $result['intersect_person'];
                $degree = $result['degree'];
                break;
            }

            if ($degree > 25)
            {
                return false;
            }
        }

        return
        [
            'degree' => $degree,
            'time' => (microtime(true) - $timestart) * 1000,
            'nb_queries' => count(DB::getQueryLog()),
            'shortest_path' => $this->rebuildShortestPath($explored_root, $explored_target, $intersect_person_id),
            'memory' => (memory_get_usage() - $memstart) / 1024 / 1024,
            'memory_peak' => (memory_get_peak_usage() - $memstart) / 1024 / 1024
        ];
    }

    /**
     * @param $queue_this_side La queue de ce côté à parcourir
     * @param $explored_this_side Le tableau des personnes de ce côté à explorer
     * @param $explored_other_side Le tableau des personnes de l'autre côté à explorer
     * @return array|null La personne à l'intersection des deux BFS et le degré ou null
     */
    private function ProgressInGraph($queue_this_side, &$explored_this_side, $explored_other_side)
    {
        list($person_id, $degree) = $queue_this_side->dequeue();

        $children = DB::select("SELECT child_id FROM relationships WHERE parent_id = $person_id");
        $parents = DB::select("SELECT parent_id FROM relationships WHERE child_id = $person_id");
        $neighbors = array_unique(array_merge(array_column($parents, 'parent_id'), array_column($children, 'child_id')));

        foreach ($neighbors as $neighbor)
        {
            if (!isset($explored_this_side[$neighbor]))
            {
                $explored_this_side[$neighbor] = ['person_id' => $person_id, 'degree' => $degree + 1];
                $queue_this_side->enqueue([$neighbor, $degree + 1]);

                if (isset($explored_other_side[$neighbor]))
                {
                    return
                    [
                        'intersect_person' => $neighbor,
                        'degree' => $degree + 1 + $explored_other_side[$neighbor]['degree']
                    ];
                }
            }
        }

        return null;
    }

    /**
     * @param $explored_root Le tableau des personnes explorées depuis la racine
     * @param $explored_target Le tableau des personnes explorées depuis la cible
     * @param $intersect_node La personne à l'intersection des deux BFS
     * @return array Le plus court chemin de la racine à la cible
     */
    private function rebuildShortestPath($explored_root, $explored_target, $intersect_node)
    {
        $path = [];
        $current = $intersect_node;
        while ($current !== null)
        {
            array_unshift($path, $current);
            $current = $explored_root[$current]['person_id'];
        }

        $current = $explored_target[$intersect_node]['person_id'];
        while ($current !== null)
        {
            array_push($path, $current);
            $current = $explored_target[$current]['person_id'];
        }

        return $path;
    }
}
