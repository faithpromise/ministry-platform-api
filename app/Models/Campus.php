<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Campus
 * @package App\Models
 *
 * @property integer $id
 * @property string $name
 * @property string $remote_slug
 *
 */
class Campus extends Model {

    public function groups() {
        return $this->hasMany(Group::class);
    }

}
