<?php

defined('MOODLE_INTERNAL') || die;

global $USER;

require_once($CFG->dirroot.'/user/profile/lib.php');
require_once($CFG->dirroot.'/local/cohortauto/lib.php');

//$juser1 = json_decode($USER->UF_VAVTADJSONS,true);
//
//$juser1 = json_decode($USER);
//$ret=array();
//
//$ret=$juser1->{"statusList"}[0];
//$ret1=$ret->{"groups"};
//
//var_dump($ret1);

if ($hassiteconfig) { // Needs this condition or there is error on login page.

    // Add view and convert to "Site administration - Users - Accounts" section.
    $ADMIN->add('accounts', new admin_externalpage('cohortautotool',
        get_string('label_cohortautotool', 'local_cohortauto'),
        new moodle_url('/local/cohortauto/convert.php')));



    if ($ADMIN->fulltree) {

        $settings = new admin_settingpage('local_cohortauto',
            get_string('pluginname', 'local_cohortauto'));

        // Profile field helper.
        $fldlist = array();
        $usrhelper = get_admin();

        profile_load_data($usrhelper);
        profile_load_custom_fields($usrhelper);
        $fldlist = cohortauto_prepare_profile_data($usrhelper);

        // Additional values for email.
        if (!empty($fldlist['email'])) {
            $fldlist['email'] = array(
                'full' => 'exampleuser@mail.example.com',
                'username' => 'exampleuser',
                'domain' => 'mail.example.com',
                'rootdomain' => 'example.com'
            );
        }

        $helparray = array();
        cohortauto_print_profile_data($fldlist, '', $helparray);

        $helptext = implode(', ', $helparray);

        $settings->add(new admin_setting_configtextarea(
            'local_cohortauto/mainrule_fld',
            get_string('mainrule_fld', 'local_cohortauto'),
            '', '')
        );

        $settings->add(new admin_setting_configcheckbox(
            'local_cohortauto/enableunenrol',
            get_string('enableunenrol', 'local_cohortauto'),
            '', 0)
        );
        $ADMIN->add('localplugins', $settings);
    }
}
