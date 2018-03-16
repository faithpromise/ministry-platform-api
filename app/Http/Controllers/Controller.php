<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\GroupFocus;
use App\Models\LifeStage;
use App\Transformers\GroupFocusTransformer;
use App\Transformers\GroupTransformer;
use App\Transformers\LifeStageTransformer;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController {

    public function groups() {

        $groups = Group::query()->with(['campus', 'focus', 'lifeStage', 'leaders'])->get();

        $result = fractal($groups, new GroupTransformer);
        $result->parseIncludes('leaders');

        return $result->respond();

    }

    public function groupFocuses() {
        $focuses = GroupFocus::has('groups')->get();

        return fractal($focuses, new GroupFocusTransformer)->respond();
    }

    public function lifeStages() {
        $stages = LifeStage::has('groups')->get();

        return fractal($stages, new LifeStageTransformer)->respond();
    }

}