<?php

namespace App\Transformers;

use App\Models\Campus;
use League\Fractal\TransformerAbstract;

class CampusTransformer extends TransformerAbstract {
    /**
     * A Fractal transformer.
     *
     * @param Campus $campus
     * @return array
     */
    public function transform(Campus $campus) {
        return [
            'id'   => $campus->id,
            'slug' => $campus->remote_slug,
            'name' => $campus->name,
        ];
    }
}
