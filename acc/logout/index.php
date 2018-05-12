<?php

session_start();

unset($_SESSION['uname']);

header("Location: http://$_SERVER[HTTP_HOST]");

?>