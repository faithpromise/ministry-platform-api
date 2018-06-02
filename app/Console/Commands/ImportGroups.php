<?php

namespace App\Console\Commands;

use App\MinistryPlatform\Http\Client;
use App\MinistryPlatform\Http\TokenPersistence;
use App\MinistryPlatform\Importers\CampusesImporter;
use App\MinistryPlatform\Importers\GroupFocusesImporter;
use App\MinistryPlatform\Importers\GroupLeadersImporter;
use App\MinistryPlatform\Importers\GroupLifeStagesImporter;
use App\MinistryPlatform\Importers\GroupsImporter;
use Illuminate\Console\Command;

class ImportGroups extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'groups:import';

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

        $client = new Client(
            config('ministryplatform.domain'),
            config('ministryplatform.client_id'),
            config('ministryplatform.client_secret'),
            config('ministryplatform.username'),
            config('ministryplatform.password'),
            new TokenPersistence
        );

        $groups_importer = new GroupsImporter($client);
        $group_leaders_importer = new GroupLeadersImporter($client);
        $categories_importer = new GroupFocusesImporter($client);
        $life_stages_importer = new GroupLifeStagesImporter($client);
        $campuses_importer = new CampusesImporter($client);

        $campuses_importer->import();
        $life_stages_importer->import();
        $categories_importer->import();
        $groups_importer->import();
        $group_leaders_importer->import();

    }

}
