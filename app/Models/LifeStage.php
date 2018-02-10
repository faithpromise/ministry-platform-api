<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LifeStage
 * @package App\Models
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 *
 */
class LifeStage extends Model {

    public function groups() {
        return $this->hasMany(Group::class);
    }

}