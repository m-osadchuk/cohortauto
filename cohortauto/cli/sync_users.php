<?php


define('CLI_SCRIPT', true);

require(__DIR__.'/../../../config.php');
require_once($CFG->libdir . '/adminlib.php');
require_once($CFG->libdir . '/clilib.php');
require_once($CFG->dirroot . '/local/cohortauto/lib.php');


cron_setup_user(get_admin());

$handler = new local_cohortauto_handler();
$users = $DB->get_recordset('user', array('deleted' => 0));
// DB caching means the repeat query for counting is very low cost.
$usercount = $DB->count_records('user', array('deleted' => 0));

cli_writeln(get_string('cli_sync_users_begin', 'local_cohortauto'));

$transaction = $DB->start_delegated_transaction();

foreach ($users as $user) {
    $username = $user->username;
    cli_write(get_string('cli_sync_users_userstart', 'local_cohortauto', $username));
    $handler->user_profile_hook($user);
    cli_writeln(get_string('cli_sync_users_userdone', 'local_cohortauto'));
}
$users->close();

$transaction->allow_commit();
cli_writeln(get_string('cli_sync_users_finished', 'local_cohortauto', $usercount));
