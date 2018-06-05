<?php

namespace App\MinistryPlatform\Importers;

use App\Models\LifeStage;

class GroupLifeStagesImporter extends ImporterAbstract {

    public function import() {

        $result = $this->client->get('tables/Life_Stages');

        foreach ($result->getData() as $datum) {
            $life_stage = LifeStage::findOrNew($datum->Life_Stage_ID);
            $life_stage->id = $datum->Life_Stage_ID;
            $life_stage->name = trim($datum->Life_Stage);
            $life_stage->description = trim($datum->Description);
            $life_stage->save();
        }

    }

}