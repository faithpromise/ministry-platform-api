<?php

namespace App\Transformers;

use App\Models\Group;
use League\Fractal\TransformerAbstract;

class GroupTransformer extends TransformerAbstract {

    protected $availableIncludes = ['campus', 'focus', 'lifeStage', 'leaders'];

    /**
     * A Fractal transformer.
     *
     * @param Group $group
     * @return array
     */
    public function transform(Group $group) {
        return [
            'id'                 => $group->id,
            'campus_slug'        => $group->campus ? $group->campus->remote_slug : null,
            'focus_slug'         => $group->focus ? $group->focus->id : null,
            'life_stage_slug'    => $group->lifeStage ? $group->lifeStage->id : null,
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

    public function includeFocus(Group $group) {
        return $group->focus ? $this->item($group->focus, new GroupFocusTransformer) : null;
    }

    public function includeLifeStage(Group $group) {
        return $group->lifeStage ? $this->item($group->lifeStage, new LifeStageTransformer()) : null;
    }

    public function includeCampus(Group $group) {
        return $group->campus ? $this->item($group->campus, new CampusTransformer) : null;
    }

}
