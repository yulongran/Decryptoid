<?php
require_once('../helpers/session.php');

destroy_session_and_data();
echo 'You have been logged out. <a href="/main.php">Go back to main page</a>';
