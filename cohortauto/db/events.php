<?php


defined('MOODLE_INTERNAL') || die;

$observers = array (
    array(
        'eventname' => '\core\event\user_created',
        'callback' => 'local_cohortauto_observer::user_created'
    ),
    array(
        'eventname' => '\core\event\user_updated',
        'callback' => 'local_cohortauto_observer::user_updated'
    ));
