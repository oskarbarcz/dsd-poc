<?php

$TimetableData = new \DBLS\Model\TimetableData(43, 0, '15:03', 0, 1, 160);

$Timetable = new \DBLS\Controller\Base\TimetableGenerator($TimetableData, 0);
$time = $Timetable->getSession();

$session = $time->initSession();

$session->next();
$session->next();
$session->next();
$session->next();
$session->next();


//$route = new \DBLS\Controller\Base\Route();

return $session->getCurrent();