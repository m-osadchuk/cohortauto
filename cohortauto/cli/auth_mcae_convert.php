<?php


define('CLI_SCRIPT', true);

require(__DIR__.'/../../../config.php');
require_once($CFG->libdir . '/clilib.php');

$updatesql = "UPDATE {cohort}
                 SET component = 'local_cohortauto'
               WHERE component = 'auth_mcae'";

$DB->execute($updatesql);

cli_writeln(get_string('cli_migrated_auth_mcae', 'local_cohortauto'));
