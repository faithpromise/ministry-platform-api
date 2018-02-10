<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Group
 * @package App\Models
 *
 * @property integer $id
 * @property integer $campus_id
 * @property integer $focus_id
 * @property integer $life_stage_id
 * @property string $name
 * @property string $description
 * @property string $day_of_week
 * @property string $start_time
 * @property string $frequency
 * @property string $contact_first_name
 * @property string $contact_last_name
 * @property string $street
 * @property string $city
 * @property string $state
 * @property string $zip
 * @property string $latitude
 * @property string $longitude
 * @property Carbon $first_meeting_at
 * @property integer $batch_id
 *
 * @property Campus $campus
 * @property GroupFocus $focus
 * @property LifeStage $lifeStage
 *
 */
class Group extends Model {

    public function campus() {
        return $this->belongsTo(Campus::class);
    }

    public function focus() {
        return $this->belongsTo(GroupFocus::class);
    }

    public function lifeStage() {
        return $this->belongsTo(LifeStage::class);
    }

}