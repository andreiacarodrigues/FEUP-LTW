<?php

session_start();
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf'] = 1; // generate_random_token();    //falta isto
}

?>