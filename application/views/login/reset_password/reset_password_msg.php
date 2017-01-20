<?php

if (isset($error_token_url)) {
	echo html_message($error_token_url, 'danger');
}


if (isset($error_code_end_time)) {
	echo html_message($error_code_end_time, 'danger');
}

if (isset($begin_success)) {
	echo html_message($begin_success, 'success');
}

if (isset($endup_success)) {
	echo html_message($endup_success, 'success');
}

?>

