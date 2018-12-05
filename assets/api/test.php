<?php

use ArchFW\Controller\Router;

$a = Router::getNthURI(2);

if ($a == 20) {
    echo 'Liczba jest równa 20';
} else {
    echo 'Liczba nie jest równa 20';
}

die;