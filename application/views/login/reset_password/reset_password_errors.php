<?php

if (isset($error_token_url)) {
	echo html_message($error_token_url, 'danger');
}


if (isset($error_code_end_time)) {
	echo html_message($error_code_end_time, 'danger');
}


?>