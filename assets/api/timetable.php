<?php

$TimetableData = new \DBLS\Model\TimetableData(17, 0, '12:00', 0, 1);

$Timetable = new \DBLS\Controller\Base\TimetableGenerator($TimetableData);
$time = $Timetable->generate();

return $time;