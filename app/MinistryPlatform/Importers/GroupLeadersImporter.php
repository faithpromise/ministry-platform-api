<?php

namespace App\MinistryPlatform\Importers;

use App\Models\Group;
use App\Models\GroupLeader;

class GroupLeadersImporter extends ImporterAbstract {

    private $select_columns = [
        'Group_Participants'                    => ['Group_ID'],
        'Participant_ID_Table_Contact_ID_Table' => ['Contact_ID', 'First_Name', 'Last_Name', 'Email_Address'],
    ];

    public function import() {

        $leader_role_id = config('ministryplatform.group_leader_role_id');

        $group_ids = Group::query()->pluck('id')->toArray();
        $group_ids = implode(',', $group_ids);

        $data = $this->client->post('tables/Group_Participants/get', [
            'Select' => $this->buildSelectQuery($this->select_columns),
            'Filter' => "Group_ID IN (" . $group_ids . ") AND Group_Role_ID=$leader_role_id",
            'Top'    => 5000,
        ]);

        foreach ($data as $datum) {
            $leader = GroupLeader::findOrNew($datum->Contact_ID);
            $leader->id = $datum->Contact_ID;
            $leader->group_id = $datum->Group_ID;
            $leader->first_name = trim($datum->First_Name);
            $leader->last_name = trim($datum->Last_Name);
            $leader->email = trim($datum->Email_Address);
            $leader->save();
        }

    }

}