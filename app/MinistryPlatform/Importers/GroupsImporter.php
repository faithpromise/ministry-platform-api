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

            // Extract the group's name
            // Pipe "|" in the group name means "Leader's Name | Group Name"
            $name_parts = explode('|', $datum->Group_Name);
            $has_group_name = count($name_parts) > 1;

            $start_time_parts = explode(':', trim($datum->Meeting_Time));
            $start_time = count($start_time_parts) !== 3 ? null : Carbon::createFromTime(intval($start_time_parts[0]), $start_time_parts[1]);

            $group = Group::findOrNew($datum->Group_ID);
            $group->id = $datum->Group_ID;
            $group->campus_id = $datum->Congregation_ID ?: null;
            $group->focus_id = $datum->Group_Focus_ID ?: null;
            $group->life_stage_id = $datum->Life_Stage_ID ?: null;
            $group->name = trim($has_group_name ? $name_parts[1] : $name_parts[0]);
            $group->subtitle = trim($has_group_name ? $name_parts[0] : null);
            $group->description = trim($datum->Description) ?: null;
            $group->day_of_week = trim($datum->Meeting_Day) ?: null;
            $group->start_time = $start_time ? $start_time->format('g:i A') : null;
            $group->frequency = trim($datum->Meeting_Frequency) ?: null;
            $group->contact_first_name = trim($datum->First_Name) ?: null;
            $group->contact_last_name = trim($datum->Last_Name) ?: null;
            $group->street = trim($datum->Address_Line_1) ?: null;
            $group->city = trim($datum->City) ?: null;
            $group->state = trim($datum->{'State/Region'}) ?: null;
            $group->zip = trim($datum->Postal_Code) ?: null;
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