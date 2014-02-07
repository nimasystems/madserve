<?php
/* mAdserve Ad Request */

require_once 'init.php';

if (DEBUG) {
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
} else {
	error_reporting(0);
}

require_once 'functions/r_f.php';

ad_request($_GET);

?>