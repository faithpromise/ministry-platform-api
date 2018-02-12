<?php

namespace App\Console\Commands;

use App\Models\Group;
use Carbon\Carbon;
use Illuminate\Console\Command;

class GeocodeGroups extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'groups:geocode';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {

        $limit = 5;

        $groups = Group::query()
            ->whereNull('latitude')
            ->where('geocode_attempts', '<=', 4)
            ->whereNotNull('zip')
            ->where(function ($query) {
                $one_hour_ago = Carbon::now('UTC');
                $query->whereNull('last_geocode_attempt_at')->orWhere('last_geocode_attempt_at', '<', $one_hour_ago);
            })
            ->limit($limit)
            ->get();

        /** @var Group $group */
        foreach ($groups as $group) {
            $address_parts = array_filter([$group->street, $group->city, $group->state, $group->zip]);
            $address = implode(', ', $address_parts);

            $this->info('Geocoding: ' . $address);
            $result = app('geocoder')->geocode($address)->get();

            $this->info('Found ' . $result->count() . ' items');

            $group->last_geocode_attempt_at = Carbon::now('UTC');
            $group->geocode_attempts = $group->geocode_attempts + 1;

            if ($result->count() > 0) {
                $group->latitude = $result[0]->getCoordinates()->getLatitude();
                $group->longitude = $result[0]->getCoordinates()->getLongitude();
            } else {
                $this->warn('Failed');
            }

            $group->save();

        }

    }

}
