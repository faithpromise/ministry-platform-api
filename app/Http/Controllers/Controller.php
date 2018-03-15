<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Transformers\GroupTransformer;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController {

    public function groups() {

        $groups = Group::query()->with(['campus', 'focus', 'lifeStage', 'leaders'])->get();

        $result = fractal($groups, new GroupTransformer);
        $result->parseIncludes('leaders');

        return $result->respond();

    }

}