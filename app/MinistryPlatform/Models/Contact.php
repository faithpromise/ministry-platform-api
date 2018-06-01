<?php

namespace App\MinistryPlatform\Models;

/**
 * Class Contact
 * @package App\MinistryPlatform\Models
 *
 *
 * @property integer Contact_ID
 * @property boolean Company
 * @property string Company_Name
 * @property string Display_Name
 * @property integer Prefix_ID
 * @property string First_Name
 * @property string Middle_Name
 * @property string Last_Name
 * @property integer Suffix_ID
 * @property string Nickname
 * @property \DateTime Date_of_Birth
 * @property integer Gender_ID
 * @property integer Marital_Status_ID
 * @property integer Contact_Status_ID
 * @property integer Household_ID
 * @property integer Household_Position_ID
 * @property \DateTime Anniversary_Date
 * @property integer Participant_Record
 * @property integer Donor_Record
 * @property string Contact_Methods
 * @property string Email_Address
 * @property string Mobile_Phone
 * @property string Company_Phone
 * @property string Pager_Phone
 * @property string Fax_Phone
 * @property string Facebook_Account
 * @property string Twitter_Account
 * @property string Professional_Information
 * @property string Web_Page
 * @property integer Industry_ID
 * @property integer Occupation_ID
 * @property string Current_School
 * @property integer HS_Graduation_Year
 * @property string Communication_Preferences
 * @property boolean Bulk_Email_Opt_Out
 * @property boolean Email_Unlisted
 * @property boolean Do_Not_Text
 * @property boolean Mobile_Phone_Unlisted
 * @property boolean Remove_From_Directory
 * @property string Other_Information
 * @property integer User_Account
 * @property string ID_Card
 * @property string Contact_GUID
 * @property string Occupation_Name
 *
 *
 */
class Contact extends BaseModel {

    public function save() {

        // Make sure Company is set to 0
        $this->Company = 0;

        // Make sure Display Name is set
        $this->Display_Name = $this->Display_Name ?: ($this->Last_Name . ', ' . ($this->Nickname ?: $this->First_Name));

        return parent::save();
    }

}