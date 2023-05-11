<?php

$p = 'admin';
$hash = '$2y$10$HyQH2H9508SBzuOjC6UkauqKYHajwUcdM7EdJiOyCTIOUISrsYRN6';


var_dump(password_verify($p, $hash));
