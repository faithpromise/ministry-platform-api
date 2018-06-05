<?php

namespace App\MinistryPlatform\Importers;

use App\Models\GroupFocus;

class GroupFocusesImporter extends ImporterAbstract {


    public function import() {

        $result = $this->client->get('tables/Group_Focuses');

        foreach ($result->getData() as $datum) {
            $focus = GroupFocus::findOrNew($datum->Group_Focus_ID);
            $focus->id = $datum->Group_Focus_ID;
            $focus->name = trim(preg_replace('/group$/i', '', $datum->Group_Focus));
            $focus->description = trim($datum->Description);
            $focus->save();
        }

    }

}