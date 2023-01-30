<?php


define('CLI_SCRIPT', true);

require(__DIR__.'/../../../config.php');
require_once($CFG->libdir . '/adminlib.php');
require_once($CFG->libdir . '/clilib.php');
require_once($CFG->dirroot . '/local/cohortauto/lib.php');

cron_setup_user(get_admin());

$username = cli_input('Synchronise cohorts for username:');

if ($username) {
    if ($user = $DB->get_record('user', array('username' => $username))) {
        $handler = new local_cohortauto_handler();
        $handler->user_profile_hook($user);

        cli_writeln(get_string('cli_user_sync_complete', 'local_cohortauto', $username));
    } else {
        cli_error(get_string('cli_user_sync_notfound', 'local_cohortauto', $username));
    }
}
