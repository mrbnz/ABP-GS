<?php
include('./config/include.php');

class UsuariManager extends Usuari
{
	private $data = [];

	public function verificar($nom_usuari, $contrasenya)
	{
		if (isset($_SESSION['username'])) {
			error_log("Ja estàs logat com a " . $_SESSION['username'] . ".");
			return true;
		} else {
			try {
				$consulta = BdD::$connection->prepare('
					SELECT contrassenya, administrador
					FROM usuari
					WHERE nom_usuari = :nom_usuari
				');

				$consulta->bindValue(':nom_usuari', $nom_usuari);
				$consulta->execute();
				$resultado = $consulta->fetch(PDO::FETCH_ASSOC);

				if ($resultado && password_verify($contrasenya, $resultado["contrassenya"])) {
					$_SESSION['username'] = $nom_usuari;
					$_SESSION['is_admin'] = $resultado['administrador']; // Guardar si és administrador
					return true;
				} else {
					error_log("Error: Contrasenya incorrecta per l'usuari " . $nom_usuari);
					$this->data['error'] = "Contrasenya incorrecta.";
					return false;
				}
			} catch (PDOException $e) {
				error_log("***Error***: " . $e->getMessage());
				return false;
			}
		}
	}

	public function tancar()
	{
		try {
			session_unset();
			session_destroy();
		} catch (PDOException $e) {
			error_log("***Error***: " . $e->getMessage());
			return false;
		}
	}

	public function registrar($nom_usuari, $email, $hashedPassword, $telefon, $dni, $data_naixement, $nom, $cognoms)
	{
		try {
			$consulta = BdD::$connection->prepare('
				INSERT INTO usuari (nom_usuari, email, contrassenya, telefon, dni, data_naixement, nom, cognoms)
				VALUES (:nom_usuari, :email, :contrassenya, :telefon, :dni, :data_naixement, :nom, :cognoms)
			');
			$consulta->bindParam(':nom_usuari', $nom_usuari);
			$consulta->bindParam(':email', $email);
			$consulta->bindParam(':contrassenya', $hashedPassword);
			$consulta->bindParam(':telefon', $telefon);
			$consulta->bindParam(':dni', $dni);
			$consulta->bindParam(':data_naixement', $data_naixement);
			$consulta->bindParam(':nom', $nom);
			$consulta->bindParam(':cognoms', $cognoms);
			return $consulta->execute();
		} catch (PDOException $e) {
			error_log("***Error en el registre de l'usuari***: " . $e->getMessage());
			return false;
		}
	}

	public function esAdmin()
	{
		// Comprovar si la sessió està iniciada i si l'usuari és administrador
		return isset($_SESSION['is_admin']) && $_SESSION['is_admin'];
	}

	public function getUserById($userId)
	{
		if (!is_numeric($userId)) {
			error_log("***Error***: ID no vàlid.");
			return null;
		}
		try {
			$consulta = (BdD::$connection)->prepare('SELECT id, nom_usuari, email, telefon, dni, DATE_FORMAT(data_naixement, "%Y-%m-%d") as data_naixement, nom, cognoms, administrador FROM `usuari` WHERE id = ?');
			$consulta->execute([$userId]);
			return $consulta->fetch(PDO::FETCH_ASSOC);
		} catch (PDOException $e) {
			error_log("***Error***: " . $e->getMessage());
			return null;
		}
	}

	public function updateUser($userId, $nomUsuari, $email, $telefon, $dni, $dataNaixement, $nom, $cognoms, $administrador)
	{
		try {
			$consulta = (BdD::$connection)->prepare('
				UPDATE usuari SET 
					nom_usuari = :nom_usuari, 
					email = :email, 
					telefon = :telefon, 
					dni = :dni, 
					data_naixement = :data_naixement, 
					nom = :nom, 
					cognoms = :cognoms, 
					administrador = :administrador 
				WHERE id = :id
			');

			$consulta->bindParam(':nom_usuari', $nomUsuari);
			$consulta->bindParam(':email', $email);
			$consulta->bindParam(':telefon', $telefon);
			$consulta->bindParam(':dni', $dni);
			$consulta->bindParam(':data_naixement', $dataNaixement);
			$consulta->bindParam(':nom', $nom);
			$consulta->bindParam(':cognoms', $cognoms);
			$consulta->bindParam(':administrador', $administrador);
			$consulta->bindParam(':id', $userId);

			$consulta->execute();

			error_log("Perfil actualitzat correctament per l'usuari ID: $userId");
			return true;
		} catch (PDOException $e) {
			error_log("***Error en actualitzar el perfil per l'usuari ID: $userId***: " . $e->getMessage());
			return false;
		}
	}

	public function deleteUser($userId)
	{
		try {
			$consulta = (BdD::$connection)->prepare('DELETE FROM usuari WHERE id = :id');
			$consulta->bindParam(':id', $userId);
			$consulta->execute();

			error_log("Usuari ID: $userId eliminat correctament.");
			return true;
		} catch (PDOException $e) {
			error_log("***Error en eliminar l'usuari ID: $userId***: " . $e->getMessage());
			return false;
		}
	}

	public function getAllUsers()
	{
		try {
			$consulta = (BdD::$connection)->prepare('SELECT * FROM usuari');
			$consulta->execute();
			return $consulta->fetchAll(PDO::FETCH_ASSOC);
		} catch (PDOException $e) {
			error_log("***Error en obtenir tots els usuaris***: " . $e->getMessage());
			return false;
		}
	}

	public function updatePassword($userId, $currentPassword, $newPassword)
	{
		try {
			// Obtenir la contrasenya actual de l'usuari
			$user = $this->getUserById($userId);
			if ($user) {
				if (!empty($user['contrassenya'])) {
					if (password_verify($currentPassword, $user['contrassenya'])) {
						// Hashear la nova contrasenya
						$hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
						
						// Actualitzar la contrasenya a la base de dades
						$update = BdD::$connection->prepare('
							UPDATE `usuari` SET contrassenya = :newPassword WHERE id = :id
						');
						$update->bindParam(':newPassword', $hashedPassword, PDO::PARAM_STR);
						$update->bindParam(':id', $userId, PDO::PARAM_INT);
						return $update->execute();
					} else {
						error_log("***Error: Contrasenya actual incorrecta per l'usuari ID: $userId***");
						return false;
					}
				} else {
					error_log("***Error: L'usuari no té una contrasenya registrada.***");
					return false;
				}
			} else {
				error_log("***Error: Usuari no trobat.***");
				return false;
			}
		} catch (PDOException $e) {
			error_log("***Error en actualitzar la contrasenya per l'usuari ID: $userId***: " . $e->getMessage());
			return false;
		}
	}

	public function getUserByUsername($username)
	{
		try {
			$consulta = BdD::$connection->prepare('
				SELECT 
					id, 
					nom_usuari, 
					email, 
					telefon, 
					dni, 
					DATE_FORMAT(data_naixement, "%Y-%m-%d") as data_naixement, 
					nom, 
					cognoms, 
					administrador, 
					contrassenya 
				FROM `usuari` 
				WHERE nom_usuari = ?
			');
			$consulta->execute([$username]);
			return $consulta->fetch(PDO::FETCH_ASSOC);
		} catch (PDOException $e) {
			error_log("***Error***: " . $e->getMessage());
			return null;
		}
	}

	public function comprovarUsuariExistent($nom_usuari)
	{
		try {
			$consulta = (BdD::$connection)->prepare('SELECT COUNT(*) FROM usuari WHERE nom_usuari = :nom_usuari');
			$consulta->bindValue(':nom_usuari', $nom_usuari);
			$consulta->execute();
			$count = $consulta->fetchColumn();
			return $count > 0;
		} catch (PDOException $e) {
			error_log("***Error***: " . $e->getMessage());
			return false;
		}
	}

	public function updateUserByUsername($username, $nomUsuari, $email, $telefon, $dni, $dataNaixement, $nom, $cognoms)
	{
		try {
			$consulta = (BdD::$connection)->prepare('
				UPDATE usuari SET 
					nom_usuari = :nom_usuari, 
					email = :email, 
					telefon = :telefon, 
					dni = :dni, 
					data_naixement = :data_naixement, 
					nom = :nom, 
					cognoms = :cognoms 
				WHERE nom_usuari = :username
			');
			return $consulta->execute([
				':nom_usuari' => $nomUsuari,
				':email' => $email,
				':telefon' => $telefon,
				':dni' => $dni,
				':data_naixement' => $dataNaixement,
				':nom' => $nom,
				':cognoms' => $cognoms,
				':username' => $username
			]);
		} catch (PDOException $e) {
			error_log("***Error***: " . $e->getMessage());
			return false;
		}
	}

	public function selectAllOrganitzadors()
	{
		$resposta = null;
		try {
			$consulta = (BdD::$connection)->prepare(
				'SELECT id, nom FROM usuari WHERE administrador = TRUE' // O qualsevol altra condició per identificar organitzadors
			);
			$consulta->execute();
			$consulta->setFetchMode(PDO::FETCH_ASSOC);
			$resposta = $consulta->fetchAll();
		} catch (PDOException $e) {
			echo "***Error***: " . $e->getMessage();
		}
		return $resposta;
	}
}
