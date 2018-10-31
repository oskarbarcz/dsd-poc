<?php

$Service = new \DBLS\Controller\Base\Station(0);

$arr = $Service->getStationList(7, 0);
return $arr;