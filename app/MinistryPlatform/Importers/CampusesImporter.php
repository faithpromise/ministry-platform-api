<?php

namespace App\MinistryPlatform\Importers;

use App\Models\Campus;
use Carbon\Carbon;

class CampusesImporter extends ImporterAbstract {

    public function import() {

        $now = Carbon::now('UTC');
        $today_string = $now->format('Y-m-d');

        $data = $this->client->get('tables/Congregations', [
            '$Select' => 'Congregation_ID, Congregation_Name',
            '$Filter' => "(Available_Online = 1 OR Available_Online IS NULL) AND (End_Date > '$today_string' OR End_Date IS NULL)",
        ]);

        foreach ($data as $datum) {
            $campus = Campus::findOrNew($datum->Congregation_ID);
            $campus->id = $datum->Congregation_ID;
            $campus->name = trim($datum->Congregation_Name);
            $campus->save();
        }

    }

}