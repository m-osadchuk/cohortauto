<?php

defined('MOODLE_INTERNAL') || die;

class local_cohortauto_observer {

    public static function user_created(\core\event\user_created $event) {
        global $CFG, $DB;
        require_once($CFG->dirroot . '/local/cohortauto/lib.php');
        $eventdata = $event->get_data();
        $handler = new local_cohortauto_handler();
        if ($user = $DB->get_record('user', array('id' => $eventdata['relateduserid']))) {
            $handler->user_profile_hook($user);
        }
    }

    public static function user_updated(\core\event\user_updated $event) {
        global $CFG, $DB;
        require_once($CFG->dirroot . '/local/cohortauto/lib.php');
        $eventdata = $event->get_data();
        $handler = new local_cohortauto_handler();
        if ($user = $DB->get_record('user', array('id' => $eventdata['relateduserid']))) {
            $handler->user_profile_hook($user);
        }
    }
}
