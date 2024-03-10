<?php
class WrkCar
{
    private $connexion;
    private $transaction;
    function __construct()
    {
        $this->connexion = Connexion::getInstance();
        $this->transaction = new WrkTransaction();
    }

    public function getCarFromDB()
	{
		$query = "SELECT c.*, b.brand
				  FROM db_151.t_car c
				  LEFT JOIN db_151.t_brand b ON c.fk_brand = b.pk_brand
				  WHERE c.fk_user IS NULL"; // Ajout de la condition
		$params = array();
		$response = $this->connexion->selectQuery($query, $params);
		$cars = array();
		foreach ($response as $carData) {
			$car = new Car();
			$car->initFromDb($carData);
			$cars[] = array(
				'pk_car' => $car->getPKCar(),
				'brand' => $car->getBrand(),
				'model' => $car->getModel(),
				'price' => $car->getPrice()
			);
		}
		$result = json_encode(
			array(
				'success' => true,
				'message' => 'Opération réussie.',
				'cars' => $cars
			),
			JSON_UNESCAPED_UNICODE
		);
		http_response_code(200);
		return $result;
	}

    public function getCarFromUserFromDB($user)
    {
        $query = "SELECT c.*, b.brand
              FROM db_151.t_car c
              LEFT JOIN db_151.t_brand b ON c.fk_brand = b.pk_brand
              WHERE c.fk_user = :user";
        $params = array('user' => $user);
        $response = $this->connexion->selectQuery($query, $params);
        $cars = array();
        foreach ($response as $carData) {
            $car = new Car();
            $car->initFromDb($carData);
            $cars[] = array(
                'pk_car' => $car->getPKCar(),
                'brand' => $car->getBrand(),
                'model' => $car->getModel(),
                'price' => $car->getPrice()
            );
        }
        $result = json_encode(
            array(
                'success' => true,
                'message' => 'Opération réussie.',
                'cars' => $cars
            ),
            JSON_UNESCAPED_UNICODE
        );
		http_response_code(200);
        return $result;
    }
    public function updateBuyingCar($userId, $carId)
    {
        $getUserMoneyQuery = "SELECT money FROM db_151.t_user WHERE pk_user = :userId";
        $getUserMoneyParams = array('userId' => $userId);
        $userData = $this->connexion->selectSingleQuery($getUserMoneyQuery, $getUserMoneyParams);
        $getCarPriceQuery = "SELECT price, fk_user FROM db_151.t_car WHERE pk_car = :carId";
        $getCarPriceParams = array('carId' => $carId);
        $carData = $this->connexion->selectSingleQuery($getCarPriceQuery, $getCarPriceParams);
        $money = $userData['money'];
        $price = $carData['price'];
        $fk_user = $carData['fk_user'];
        if ($fk_user == null) {
            if ($money >= $price) {
                try {
                    $updateCarQuery = "UPDATE db_151.t_car SET fk_user = :userId WHERE pk_car = :carId";
                    $updateCarParams = array('userId' => $userId, 'carId' => $carId);
                    $this->connexion->executeQuery($updateCarQuery, $updateCarParams);
                    $newUserMoney = $money - $price;
                    $updateUserMoneyQuery = "UPDATE db_151.t_user SET money = :newUserMoney WHERE pk_user = :userId";
                    $updateUserMoneyParams = array('newUserMoney' => $newUserMoney, 'userId' => $userId);
                    $this->connexion->executeQuery($updateUserMoneyQuery, $updateUserMoneyParams);
                    $this->transaction->createTransactionInDB($userId, $carId, 0, $this->connexion);
                    http_response_code(200);
                    return json_encode(
                        array(
                            'success' => true,
                            'message' => 'Voiture achetée avec succès.',
                        ),
                        JSON_UNESCAPED_UNICODE
                    );

                } catch (Exception $e) {
                    $this->connexion->rollbackTransaction();
                    http_response_code(401);
                    return json_encode(
                        array(
                            'success' => false,
                            'message' => 'Erreur lors de l\'achat de la voiture.',
                        ),
                        JSON_UNESCAPED_UNICODE
                    );
                }
            } else {
                http_response_code(401);
                return json_encode(
                    array(
                        'success' => false,
                        'message' => 'Fonds insuffisants pour acheter la voiture.',
                    ),
                    JSON_UNESCAPED_UNICODE
                );
            }
        } else {
            http_response_code(401);
            return json_encode(
                array(
                    'success' => false,
                    'message' => 'La voiture n\'est pas disponible à l\'achat ( rafraîchissez la page )',
                ),
                JSON_UNESCAPED_UNICODE
            );
        }
    }

    public function updateSellingCar($userId, $carId)
    {
        $this->connexion->startTransaction();
        $getUserMoneyQuery = "SELECT money, pk_user FROM db_151.t_user WHERE pk_user = :userId";
        $getUserMoneyParams = array('userId' => $userId);
        $userData = $this->connexion->selectSingleQuery($getUserMoneyQuery, $getUserMoneyParams);
        $getCarPriceQuery = "SELECT price, fk_user FROM db_151.t_car WHERE pk_car = :carId";
        $getCarPriceParams = array('carId' => $carId);
        $carData = $this->connexion->selectSingleQuery($getCarPriceQuery, $getCarPriceParams);
        $price = $carData['price'];
        $money = $userData['money'];
        $pk_user = $userData['pk_user'];
        $fk_user = $carData['fk_user'];
        if ($pk_user == $fk_user) {
            try {
                $updateCarQuery = "UPDATE db_151.t_car SET fk_user = null WHERE pk_car = :carId";
                $updateCarParams = array('carId' => $carId);
                $this->connexion->addQueryToTransaction($updateCarQuery, $updateCarParams);
                $newUserMoney = $money + $price;
                $updateUserMoneyQuery = "UPDATE db_151.t_user SET money = :newUserMoney WHERE pk_user = :userId";
                $updateUserMoneyParams = array('newUserMoney' => $newUserMoney, 'userId' => $userId);
                $this->connexion->addQueryToTransaction($updateUserMoneyQuery, $updateUserMoneyParams);
                $this->connexion->commitTransaction();
                $this->transaction->createTransactionInDB($userId, $carId, 1, $this->connexion);
                http_response_code(200);
                return json_encode(
                    array(
                        'success' => true,
                        'message' => 'Voiture vendue avec succès.',
                    ),
                    JSON_UNESCAPED_UNICODE
                );
            } catch (Exception $e) {
                $this->connexion->rollbackTransaction();
                http_response_code(401);
                return json_encode(
                    array(
                        'success' => false,
                        'message' => 'Erreur lors de la vente de la voiture.',
                    ),
                    JSON_UNESCAPED_UNICODE
                );
            }
        } else {
            http_response_code(401);
            return json_encode(
                array(
                    'success' => false,
                    'message' => 'Vous ne possédez pas la voiture ( rafraîchissez la page )',
                ),
                JSON_UNESCAPED_UNICODE
            );
        }
    }

    public function createCarInDB($brand, $model, $price, $user)
    {
        $return = null;
        if (empty($brand) || empty($model) || empty($price) || empty($user)) {
            $return = json_encode(
                array(
                    'success' => false,
                    'message' => 'Tous les champs doivent être renseignés'
                ),
                JSON_UNESCAPED_UNICODE
            );
        }
        $brandQuery = "SELECT pk_brand FROM t_brand WHERE pk_brand = :brand";
        $brandParams = array('brand' => $brand);
        $brandResult = $this->connexion->selectSingleQuery($brandQuery, $brandParams);

        if (!$brandResult) {
            $return = json_encode(
                array(
                    'success' => false,
                    'message' => 'La marque spécifiée n\'existe pas'
                ),
                JSON_UNESCAPED_UNICODE
            );
        }
        $brandId = $brandResult['pk_brand'];
        $insertQuery = "INSERT INTO t_car (fk_brand, model, price, fk_user) VALUES (:fk_brand, :model, :price, :fk_user)";
        $insertParams = array('fk_brand' => $brandId, 'model' => $model, 'price' => $price, 'fk_user' => $user);
        $insertResult = $this->connexion->executeQuery($insertQuery, $insertParams);
        if ($insertResult == 1) {
            $carId = $this->connexion->getLastId('t_car');
            $carDetails = $this->getCarDetails($carId);
            http_response_code(200);
            return json_encode(
                array(
                    'success' => true,
                    'message' => 'Voiture ajoutée avec succès',
                    'car' => $carDetails
                ),
                JSON_UNESCAPED_UNICODE
            );
        } else {
            http_response_code(404);
            return json_encode(
                array(
                    'success' => false,
                    'message' => 'Erreur lors de l\'ajout de la voiture'
                ),
                JSON_UNESCAPED_UNICODE
            );
        }
    }

    private function getCarDetails($carId)
    {
        $carQuery = "SELECT c.pk_car, c.model, c.price, b.brand AS brand_name, u.username AS owner_username
                 FROM t_car c
                 JOIN t_brand b ON c.fk_brand = b.pk_brand
                 LEFT JOIN t_user u ON c.fk_user = u.pk_user
                 WHERE c.pk_car = :pk_car";
        $carParams = array('pk_car' => $carId);
        $carData = $this->connexion->selectSingleQuery($carQuery, $carParams);
        $renamedCarData = array(
            'pk_car' => $carData['pk_car'],
            'model' => $carData['model'],
            'price' => $carData['price'],
            'brand' => $carData['brand_name'],
            'user' => $carData['owner_username']
        );
        return $renamedCarData;
    }
}