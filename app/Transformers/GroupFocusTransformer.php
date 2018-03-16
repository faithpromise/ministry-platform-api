<?php

namespace App\Transformers;

use App\Models\GroupFocus;
use League\Fractal\TransformerAbstract;

class GroupFocusTransformer extends TransformerAbstract {
    /**
     * A Fractal transformer.
     *
     * @param GroupFocus $focus
     * @return array
     */
    public function transform(GroupFocus $focus) {
        return [
            'id'          => $focus->id,
            'name'        => $focus->name,
            'description' => $focus->description,
        ];
    }
}
