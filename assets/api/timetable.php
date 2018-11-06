<?php

$TimetableData = new \DBLS\Model\TimetableData(0, 22, '12:00', 0, 1);

$Timetable = new \DBLS\Controller\Base\TimetableGenerator($TimetableData);
$time = $Timetable->getSession();

return $time->getTimetable();