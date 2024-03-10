<?php

class WrkTransaction
{
    private $connexion;
    function __construct()
    {

    }
    public function createTransactionInDB($user, $car, $type, $connexion)
    {
        date_default_timezone_set('Europe/Paris');
        $currentDate = date('Y-m-d H:i:s');


        $query = "INSERT INTO db_151.t_transaction (type, date, fk_car, fk_user) VALUES (:type, :date, :fk_car, :fk_user)";
        $params = [
            'type' => $type,
            'date' => $currentDate,
            'fk_car' => $car,
            'fk_user' => $user,
        ];
        $connexion->executeQuery($query, $params);
		http_response_code(200);
        return [
            'success' => true,
            'message' => 'Transaction créée avec succès.',
        ];
    }
}
