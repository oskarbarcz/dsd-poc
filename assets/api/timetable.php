<?php

$TimetableData = new \DBLS\Model\TimetableData(0, 43, '12:00', 0, 1, 160);

$Timetable = new \DBLS\Controller\Base\TimetableGenerator($TimetableData);
$time = $Timetable->getSession();

$route = new \DBLS\Controller\Base\Route();

return $time->getTimetable();