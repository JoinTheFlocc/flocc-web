<?php

namespace Flocc\User\Floccs;

use Flocc\Searches;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class Search
 *
 * @package Flocc\User\Floccs
 */
class Search
{
    /**
     * Get from floccs and searches by user ID
     *
     * @param int $user_id
     *
     * @return array
     */
    public function getUserFloccsData($user_id)
    {
        $data      = ['activities' => [], 'places' => [], 'both' => []];

        $floccs    = Floccs::where('user_id', $user_id)->leftjoin('activities', 'users_floccs.activity_id', '=', 'activities.id')->get();
        $searches  = Searches::where('user_id', $user_id)->where(\DB::raw('DATEDIFF(now(), time)'), '<=', 30)->leftjoin('activities', 'searches.activity_id', '=', 'activities.id')->get();

        foreach([$floccs, $searches] as $object) {
            foreach($object as $row) {
                // Activities
                if($row->getActivityName() !== null) {
                    if(in_array([$row->getActivityId(), $row->getActivityName()], $data['activities']) === false) {
                        $data['activities'][] = [$row->getActivityId(), $row->getActivityName(), null];
                    }
                }

                // Places
                if($row->getPlace() !== null) {
                    if(in_array($row->getPlace(), $data['places']) === false) {
                        $data['places'][] = [null, null, $row->getPlace()];
                    }
                }

                // Both
                if($row->getActivityName() !== null and $row->getPlace() !== null) {
                    if(in_array([$row->getActivityId(), $row->getActivityName(), $row->getPlace()], $data['both']) === false) {
                        $data['both'][] = [$row->getActivityId(), $row->getActivityName(), $row->getPlace()];
                    }
                }
            }
        }

        return (count($data['activities']) === 0 or count($data['places']) === 0 or count($data['both']) === 0) ? null : $data;
    }

    /**
     * Find floccs
     *
     * @param int|null $activity_id
     * @param string|null $place
     * @param int $user_id
     *
     * @return \Flocc\User\Floccs\Floccs
     */
    private function findFloccs($activity_id, $place, $user_id)
    {
        $find = Floccs::select('users_floccs.id', 'users_floccs.activity_id', 'activities.name', 'users_floccs.place')->where('users_floccs.user_id', '<>', $user_id);

        $find->leftjoin('activities', 'users_floccs.activity_id', '=', 'activities.id');
        $find->leftjoin('users_floccs_settings', function($join) use($user_id) {
            $join->on('users_floccs_settings.flocc_id', '=', 'users_floccs.id');
            $join->on('users_floccs_settings.user_id', '=', \DB::raw($user_id));
            $join->on('users_floccs_settings.name', '=', \DB::raw('"hide_flocc"'));
        });

        if($activity_id !== null) {
            $find->where('activity_id', $activity_id);
        }

        if($activity_id !== null) {
            $find->where('place', $place);
        }

        $find->whereNotNull('users_floccs.id');
        $find->whereNull('users_floccs_settings.value');

        return $find->get();
    }

    /**
     * Get floccs
     *
     * @param int $user_id
     * @param int $limit
     *
     * @return Collection
     */
    public function getFloccs($user_id, $limit = 1)
    {
        $floccs     = new Collection();

        $user_id    = (int) $user_id;
        $user_data  = $this->getUserFloccsData($user_id);
        $data       = [];

        if($user_data === null) {
            $data = (new Floccs())->getPopular(1);
        } else {
            foreach([$user_data['both'], $user_data['activities'], $user_data['places']] as $rows) {
                foreach($rows as $row) {
                    $find = $this->findFloccs($row[0], $row[2], $user_id);

                    foreach($find as $row) {
                        $data[$row->getId()] = $row;

                        if(count($data) === $limit) {
                            break;
                        }
                    }
                }

                if(count($data) === $limit) {
                    break;
                }
            }

            if(count($data) === 0) {
                $data = (new Floccs())->getPopular(1);
            }
        }

        foreach($data as $row) {
            $floccs->push(new Flocc($row));
        }

        return $floccs;
    }
}