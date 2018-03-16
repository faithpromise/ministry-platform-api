<?php

namespace App\Transformers;

use App\Models\LifeStage;
use League\Fractal\TransformerAbstract;

class LifeStageTransformer extends TransformerAbstract {
    /**
     * A Fractal transformer.
     *
     * @param LifeStage $stage
     * @return array
     */
    public function transform(LifeStage $stage) {
        return [
            'id'          => $stage->id,
            'name'        => $stage->name,
            'description' => $stage->description,
        ];
    }
}
