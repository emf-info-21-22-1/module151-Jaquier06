<?php

class WrkUser
{
	private $connexion;
	function __construct()
	{
		$this->connexion = Connexion::getInstance();
	}

	public function selectUser($username, $password, $session)
	{
		$query = "SELECT * FROM t_user WHERE username = :username";
		$params = array("username" => htmlspecialchars($username));
		$response = $this->connexion->selectSingleQuery($query, $params);
		$obj = new User();
		if ($response) {
			$obj->initFromDb($response);
			$bool = password_verify($password, $response['password']);
			if ($bool) {
				http_response_code(200);
				echo json_encode(
					array(
						'success' => true,
						'message' => 'Utilisateur connecté',
						'username' => $obj->getUsername(),
						'pk' => $obj->getPKUser(),
						'money' => $obj->getMoney()
					),
					JSON_UNESCAPED_UNICODE
				);
				$session->set('pk', $obj->getPKUser());
			} else {
				http_response_code(401);
				echo json_encode(
					array(
						'success' => false,
						'message' => 'Identifiants incorrects !'
					),
					JSON_UNESCAPED_UNICODE
				);
			}
		} else {
			http_response_code(401);
			echo json_encode(
				array(
					'success' => false,
					'message' => 'Identifiants incorrects !'
				),
				JSON_UNESCAPED_UNICODE
			);
		}
	}

	public function createUser($username, $password, $session)
	{
		$query = "SELECT * FROM t_user WHERE username=:username";
		$params = array("username" => $username);
		$isUsernameTaken = $this->connexion->selectSingleQuery($query, $params);
		if (!$isUsernameTaken) {
			$query = "INSERT INTO t_user (username, password) VALUES (:username, :password)";
			$password = htmlspecialchars($password);
			$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
			$params = array('username' => htmlspecialchars($username), 'password' => $hashedPassword);
			$this->connexion->executeQuery($query, $params);
			$pkUser = $this->connexion->getLastId('t_user');
			http_response_code(200);
			$response = array(
				'success' => true,
				'pk' => $pkUser,
				'money' => 0,
				'username' => $username
			);
			$session->set('pk', $pkUser);
		} else {
			http_response_code(401);
			$response = array(
				'success' => false,
				'message' => "Ce nom d'utilisateur n'est pas disponible"
			);
		}
		header('Content-Type: application/json; charset=utf-8');
		echo json_encode($response, JSON_UNESCAPED_UNICODE);
		return $response;
	}

	public function getUserInfos($pkUser)
	{
		$query = "SELECT * FROM t_user WHERE pk_user = :pkUser";
		$params = array("pkUser" => $pkUser);
		$response = $this->connexion->selectSingleQuery($query, $params);

		if ($response) {
			$obj = new User();
			$obj->initFromDb($response);

			http_response_code(200);
			echo json_encode(
				array(
					'success' => true,
					'message' => 'Attributs de l\'utilisateur récupérés',
					'username' => $obj->getUsername(),
					'pk' => $obj->getPKUser(),
					'money' => $obj->getMoney()
				),
				JSON_UNESCAPED_UNICODE
			);
		} else {
			http_response_code(404);
			echo json_encode(
				array(
					'success' => false,
					'message' => 'Utilisateur non trouvé'
				),
				JSON_UNESCAPED_UNICODE
			);
		}
	}

}