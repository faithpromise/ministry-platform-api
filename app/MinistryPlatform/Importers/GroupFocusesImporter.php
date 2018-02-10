<?php

namespace App\MinistryPlatform\Importers;

use App\Models\GroupFocus;

class GroupFocusesImporter extends ImporterAbstract {


    public function import() {

        $data = $this->client->get('tables/Group_Focuses');

        foreach ($data as $datum) {
            $focus = GroupFocus::findOrNew($datum->Group_Focus_ID);
            $focus->id = $datum->Group_Focus_ID;
            $focus->name = $datum->Group_Focus;
            $focus->description = $datum->Description;
            $focus->save();
        }

    }

}