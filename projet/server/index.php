<?php
header('Access-Control-Allow-Origin: *');

// LOCAL :
//header('Access-Control-Allow-Origin: http://localhost:8080');

// ONLINE :
header('Access-Control-Allow-Origin: https://jaquierl.emf-informatique.ch/151/client/index.html');

header('Access-Control-Allow-Credentials: true');
include_once('ctrl/ctrlBrand.php');
include_once('ctrl/ctrlCar.php');
include_once('ctrl/ctrlUser.php');
include_once('wrk/wrkBrand.php');
include_once('wrk/wrkCar.php');
include_once('wrk/wrkTransaction.php');
include_once('wrk/wrkUser.php');
include_once('wrk/Connexion.php');
include_once('session/SessionManager.php');
include_once('bean/user.php');
include_once('bean/car.php');
include_once('bean/brand.php');

$session = new SessionManager();
$user = new CtrlUser();
$brand = new CtrlBrand();
$car = new CtrlCar();

if (isset($_POST['action'])) {
    switch ($_POST['action']) {
        case 'checkUser':
            if (isset($_POST['user'])) {
                if (isset($_POST['pass'])) {
                    $user->checkUser($_POST['user'], $_POST['pass'], $session);
                }
            }
            break;
        case 'createUser':
            if (isset($_POST['user'])) {
                if (isset($_POST['pass'])) {
                    $user->createUser($_POST['user'], $_POST['pass'], $session);
                }
            }
            break;
        case 'getCar':
            $car->getCar();
            break;
        case 'getCarFromUser':
            if (isset($_POST['user'])) {
                $car->getCarFromUser($_POST['user']);
            }
            break;
        case 'getBrand':
            $brand->getBrand();
            break;
        case 'addCar':
            if (isset($_POST['brand'])) {
                if (isset($_POST['model'])) {
                    if (isset($_POST['price'])) {
                        if (isset($_POST['user'])) {
                            if ($session->get('pk')) {
                                $car->newCar($_POST['brand'], $_POST['model'], $_POST['price'], $_POST['user']);
                            } else {
                                http_response_code(401);
                                return json_encode(
                                    array(
                                        'success' => false,
                                        'message' => 'Erreur de session',
                                    ),
                                    JSON_UNESCAPED_UNICODE
                                );
                            }
                        }
                    }
                }
            }

            break;
        case 'buyCar':
            if (isset($_POST['user'])) {
                if (isset($_POST['car'])) {
                    if ($session->get('pk')) {
                        $car->buyCar($_POST['user'], $_POST['car']);
                    } else {
                        http_response_code(401);
                        echo json_encode(
                            array(
                                'success' => false,
                                'message' => 'Erreur de session',
                            ),
                            JSON_UNESCAPED_UNICODE
                        );
                    }
                }
            }
            break;
        case 'sellCar':
            if (isset($_POST['user'])) {
                if (isset($_POST['car'])) {
                    if ($session->get('pk')) {
                        $car->sellCar($_POST['user'], $_POST['car']);
                    } else {
                        http_response_code(401);
                        echo json_encode(
                            array(
                                'success' => false,
                                'message' => 'Erreur de session',
                            ),
                            JSON_UNESCAPED_UNICODE
                        );
                    }
                }
            }
            break;
        case 'logout':
            session_unset();
            if (session_destroy()) {
                echo json_encode(
                    array(
                        'success' => true,
                        'message' => 'Session destroy : SUCCESS',
                    ),
                    JSON_UNESCAPED_UNICODE
                );
            } else {
                echo json_encode(
                    array(
                        'success' => false,
                        'message' => 'Session destroy : ERROR',
                    ),
                    JSON_UNESCAPED_UNICODE
                );
            }
            break;
        case 'getUserInfos':
            if (isset($_POST['user'])) {
                $user->ctrlGetUserInfos($_POST['user']);
            }
            break;
    }
}
