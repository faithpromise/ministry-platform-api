<?php

namespace App\Transformers;

use App\Models\Group;
use League\Fractal\TransformerAbstract;

class GroupTransformer extends TransformerAbstract {

    protected $availableIncludes = ['leaders'];

    /**
     * A Fractal transformer.
     *
     * @param Group $group
     * @return array
     */
    public function transform(Group $group) {
        return [
            'id'                 => $group->id,
            'campus'             => $group->campus ? ['slug' => $group->campus->remote_slug, 'title' => $group->campus->name,] : null,
            'focus'              => $group->focus ? ['slug' => $group->focus->id, 'title' => $group->focus->name,] : null,
            'life_stage'         => $group->lifeStage ? ['slug' => $group->lifeStage->id, 'title' => $group->lifeStage->name,] : null,
            'name'               => $group->name,
            'subtitle'           => $group->subtitle,
            'description'        => $group->description,
            'day_of_week'        => $group->day_of_week,
            'start_time'         => $group->start_time,
            'frequency'          => $group->frequency,
            'contact_first_name' => $group->contact_first_name,
            'contact_last_name'  => $group->contact_last_name,
            'street'             => $group->street,
            'city'               => $group->city,
            'state'              => $group->state,
            'zip'                => $group->zip,
            'latitude'           => $group->latitude,
            'longitude'          => $group->longitude,
            'first_meeting_at'   => $group->first_meeting_at->format('Y-m-d H:i:s'),
        ];
    }

    public function includeLeaders(Group $group) {
        return $this->collection($group->leaders, new GroupLeaderTransformer);
    }

}
