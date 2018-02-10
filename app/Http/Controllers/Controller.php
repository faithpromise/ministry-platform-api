<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController {

    public function groups() {

        $groups = Group::query()->with(['campus', 'focus', 'lifeStage'])->get();

        $data = [];

        /** @var Group $group */
        foreach ($groups as $group) {
            $data[] = [
                'id'                 => $group->id,
                'campus'             => $group->campus ? ['slug' => $group->campus->id, 'title' => $group->campus->name,] : null,
                'focus'              => $group->focus ? ['slug' => $group->focus->id, 'title' => $group->focus->name,] : null,
                'life_stage'         => $group->lifeStage ? ['slug' => $group->lifeStage->id, 'title' => $group->lifeStage->name,] : null,
                'name'               => $group->name,
                'description'        => $group->description,
                'day_of_week'        => $group->day_of_week,
                'frequency'          => $group->frequency,
                'contact_first_name' => $group->contact_first_name,
                'contact_last_name'  => $group->contact_last_name,
                'street'             => $group->street,
                'city'               => $group->city,
                'state'              => $group->state,
                'zip'                => $group->zip,
                'latitude'           => $group->latitude,
                'longitude'          => $group->longitude,
                'first_meeting_at'   => $group->first_meeting_at,
            ];
        }

        return response()->json($data);

    }

}