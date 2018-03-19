<?php

return [

    'domain'        => env('MINISTRY_PLATFORM_DOMAIN'),
    'client_id'     => env('MINISTRY_PLATFORM_CLIENT_ID'),
    'client_secret' => env('MINISTRY_PLATFORM_CLIENT_SECRET'),
    'username'      => env('MINISTRY_PLATFORM_USERNAME'),
    'password'      => env('MINISTRY_PLATFORM_PASSWORD'),

    'small_group_type_id'  => env('MINISTRY_PLATFORM_SMALL_GROUP_TYPE_ID', 1),
    'group_leader_role_id' => env('MINISTRY_PLATFORM_GROUP_LEADER_ROLE_ID', 1),

    'heartbeat_import_groups'    => env('HEARTBEAT_IMPORT_GROUPS', 'http://127.0.0.1'),
    'cms_import_groups_url'      => env('CMS_IMPORT_GROUPS_URL', 'http://127.0.0.1'),
    'cms_import_focuses_url'     => env('CMS_IMPORT_FOCUSES_URL', 'http://127.0.0.1'),
    'cms_import_life_stages_url' => env('CMS_IMPORT_LIFE_STAGES_URL', 'http://127.0.0.1'),

];