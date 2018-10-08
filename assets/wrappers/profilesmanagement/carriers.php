<?php

use DBLS\Controller\CarrierHandler;
use DBLS\Model\NewCarrierData;

$CarrierHandler = new CarrierHandler();
// Download all current carriers
$carriers = $CarrierHandler->getCarriers(true);

// execute actions on subURL
if (array_key_exists(1, ROUTER) and ROUTER[1] === 'add') {
    $sideWindow = 'add';
} else if (array_key_exists(1, ROUTER) and ROUTER[1] === 'edit') {
    if (array_key_exists(2, ROUTER) and ROUTER[2] !== '') {
        // runs when entered edit in URL and provided valid id

    } else {
        // runs when entered edit in URL and not provided valid id
        header('Location: /carriers');
    }
} else if (array_key_exists(1, ROUTER) and ROUTER[1] === 'delete') {
    if (array_key_exists(2, ROUTER) and ROUTER[2] !== '') {
        // runs when entered delete in URL and provided valid id
        if (array_key_exists(3, ROUTER) and ROUTER[3] === 'confirmed') {
            // runs when confirmed to delete
            $CarrierHandler->deleteCarrierbyID(ROUTER[2]);
            // refresh after deletion
            header('Location: /carriers/');
        } else {
            $sideWindow = 'confirmDelete';
            $deleteID = ROUTER[2];
            return [
                'deleteID'   => $deleteID,
                'carriers'   => $carriers,
                'sideWindow' => $sideWindow,
            ];
        }
    } else {
        // runs when entered delete in URL and not provided valid id
        $sideWindow = 'edit';
        $sideWindow = 'delete';
        header('Location: /carriers/delete');
    }
} else {
    // when provided standard URL
    $sideWindow = null;
}


// if add form submitted
if (isset($_POST['add_fullname'])) {
    try {
        $Data = new NewCarrierData($_POST['add_fullname'], $_POST['address'], $_POST['nip'], $_POST['regon'], $_POST['uiccode']);
        $CarrierHandler->addCarrier($Data, null);
        // commit once more time if operation were runned
        $carriers = $CarrierHandler->getCarriers(true);
        return [
            'good'       => 'Carrier added successfully',
            'carriers'   => $carriers,
            'sideWindow' => $sideWindow,
        ];
    } catch (Exception $e) {
        return [
            'formerForm' => $_POST,
            'error'      => $e->getMessage(),
            'carriers'   => $carriers,
            'sideWindow' => $sideWindow,
        ];
    }
}


return [
    'carriers'   => $carriers,
    'sideWindow' => $sideWindow,
];