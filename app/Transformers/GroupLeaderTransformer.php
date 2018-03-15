<?php

namespace App\Transformers;

use App\Models\GroupLeader;
use League\Fractal\TransformerAbstract;

class GroupLeaderTransformer extends TransformerAbstract {
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(GroupLeader $leader) {
        return [
            'id'         => $leader->id,
            'first_name' => $leader->first_name,
            'last_name'  => $leader->last_name,
        ];
    }
}
