<?php

$TimetableData = new \DBLS\Model\TimetableData(43, 0, '15:03', 0, 1, 160);
try {
    $Timetable = new \DBLS\Controller\Base\TimetableGenerator($TimetableData, 1);
    $SESSION = $Timetable->getSession();

    $session = $SESSION->initSession();

    $session->next();
    $session->next();
    $session->next();
    $session->next();
    $session->next();

//    return $session->getCurrent();

    return $session->getTimetable();
} catch (\DBLS\Exceptions\ElementNotFoundException $e) {
    echo 'ELEMENT NOT FOUND';
} catch (\DBLS\Exceptions\TimetableException $e) {
    echo $e->getMessage();
}
