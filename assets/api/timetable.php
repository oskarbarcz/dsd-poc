<?php

$TimetableData = new \DBLS\Model\TimetableData(43, 0, '15:03', 0, 1, 160);

$Timetable = new \DBLS\Controller\Base\TimetableGenerator($TimetableData);
$time = $Timetable->getSession();

$route = new \DBLS\Controller\Base\Route();

return $time->getTimetable();