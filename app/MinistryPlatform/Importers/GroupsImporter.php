<?php

namespace App\MinistryPlatform\Importers;

use App\Models\Group;
use Carbon\Carbon;

class GroupsImporter extends ImporterAbstract {

    private $select_columns = [
        'Groups'                        => ['Group_ID', 'Congregation_ID', 'Group_Focus_ID', 'Life_Stage_ID', 'Group_Name', 'Description', 'Start_Date', 'End_Date', 'Group_Is_Full', 'Available_Online', 'Meeting_Time'],
        'Meeting_Day_ID_Table'          => ['Meeting_Day'],
        'Meeting_Frequency_ID_Table'    => ['Meeting_Frequency'],
        'Primary_Contact_Table'         => ['First_Name', 'Last_Name'],
        'Offsite_Meeting_Address_Table' => ['Address_Line_1', 'City', '"State/Region"', 'Postal_Code', 'Latitude', 'Longitude'],
    ];

    public function import() {

        $now = Carbon::now('UTC');
        $today_string = $now->format('Y-m-d');
        $group_type_id = config('ministryplatform.small_group_type_id');

        // Build select columns

        $data = $this->client->get('tables/Groups', [
            '$Filter' => "Group_Type_ID=$group_type_id AND Available_Online=1 AND (Group_Is_Full=0 OR Group_Is_Full IS NULL) AND (End_Date > '$today_string' OR End_Date IS NULL)",
            '$Select' => $this->buildSelectQuery(),
        ]);

        $batch_id = $now->timestamp;

        foreach ($data as $datum) {
            $group = Group::findOrNew($datum->Group_ID);
            $group->id = $datum->Group_ID;
            $group->campus_id = $datum->Congregation_ID;
            $group->focus_id = $datum->Group_Focus_ID;
            $group->life_stage_id = $datum->Life_Stage_ID;
            $group->name = $datum->Group_Name;
            $group->description = $datum->Description;
            $group->day_of_week = $datum->Meeting_Day;
            $group->start_time = $datum->Meeting_Time;
            $group->frequency = $datum->Meeting_Frequency;
            $group->contact_first_name = $datum->First_Name;
            $group->contact_last_name = $datum->Last_Name;
            $group->street = $datum->Address_Line_1;
            $group->city = $datum->City;
            $group->state = $datum->{'State/Region'};
            $group->zip = $datum->Postal_Code;
            $group->latitude = $datum->Latitude;
            $group->longitude = $datum->Longitude;
            $group->batch_id = $batch_id;
            $group->save();
        }

        // Remove inactive groups

        if (count($data) > 0)
            Group::query()->where('batch_id', '!=', $batch_id)->delete();

    }

    private function buildSelectQuery() {

        $select = [];

        foreach ($this->select_columns as $table => $fields) {
            $select[] = implode(', ', preg_filter('/^/', $table . '.', $fields));
        }

        return implode(', ', $select);
    }

}