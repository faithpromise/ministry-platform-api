<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class GroupFocus
 * @package App\Models
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 *
 */
class GroupFocus extends Model {

    protected $table = 'group_focuses';

    public function groups() {
        return $this->hasMany(Group::class, 'focus_id');
    }

}
