<?php

$Service = new \DBLS\Controller\Base\Station();

$arr = $Service->getStationListByRoute(0, false);
return $arr;