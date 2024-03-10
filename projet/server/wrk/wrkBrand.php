<?php
class WrkBrand
{
	private $connexion;

	function __construct()
	{
		$this->connexion = Connexion::getInstance();
	}

	public function getBrandFromDB()
	{
		$query = "SELECT pk_brand, brand FROM t_brand";
		$params = array();
		$response = $this->connexion->selectQuery($query, $params);
		$cars = array();
		foreach ($response as $brandData) {
			$car = new Brand();
			$car->initFromDb($brandData);
			$cars[] = array(
				'pk_brand' => $car->getPKBrand(),
				'name' => $car->getBrand(),
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
}