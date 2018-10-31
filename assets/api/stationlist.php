<?php

$Service = new \DBLS\Controller\Base\Station();

$arr = $Service->getStationListByRoute(0, 40, 20);
return $arr;