<?php

namespace App\Http\Controllers;

use App\MinistryPlatform\Http\Client;
use App\MinistryPlatform\Models\Group_Inquiry;
use Carbon\Carbon;
use Illuminate\Http\Request;

class GroupInquiriesController extends Controller {

    public function store(Request $request, Client $mp) {

        $data = $this->validate($request, [
            'Group_ID'   => 'required',
            'First_Name' => 'required',
            'Last_Name'  => 'required',
            'Email'      => 'required',
            'Phone'      => '',
            'Comments'   => '',
        ]);

        $contact = $mp->contacts()->firstOrCreate($data['First_Name'], $data['Last_Name'], $data['Email']);

        $data['Contact_ID'] = $contact->Contact_ID;
        $data['Inquiry_Date'] = Carbon::now()->format('Y-m-d\TH:i:s');

        /** @var Group_Inquiry $group_inquiry */
        $mp->groupInquiries()->create($data);

    }

}
