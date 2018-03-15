<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class GroupLeader
 * @package App\Models
 *
 * @property integer $id
 * @property integer $group_id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 *
 * @property Group $group
 *
 */
class GroupLeader extends Model {

    public function group() {
        return $this->belongsTo(Group::class);
    }

}
