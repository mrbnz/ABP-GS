<?php
include('./config/include.php');

class UsuariManager extends Usuari
{

	public function verificar($nom_usuari, $contrasenya)
	{
		if (isset($_SESSION['username'])) {
			echo "<div class='alert alert-info'>Ja estàs logat com a " . $_SESSION['username'] . ".</div>";
			return true;
		} else {
			try {
				$consulta = (BdD::$connection)->prepare('
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
					echo "<script>alert('Contrasenya incorrecta');</script>";
					return false;
				}
			} catch (PDOException $e) {
				echo "***Error***: " . $e->getMessage();
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
			echo "***Error***: " . $e->getMessage();
			return false;
		}
	}

	public function registrar($nom_usuari, $email, $contrasenya, $telefon, $dni, $data_naixement, $nom, $cognoms)
	{
		try {
			$consulta = (BdD::$connection)->prepare('
				INSERT INTO usuari (nom_usuari, email, contrassenya, telefon, dni, data_naixement, nom, cognoms)
				VALUES (:nom_usuari, :email, :contrasenya, :telefon, :dni, :data_naixement, :nom, :cognoms)
			');

			$consulta->bindValue(':nom_usuari', $nom_usuari);
			$consulta->bindValue(':email', $email);
			$consulta->bindValue(':contrasenya', $contrasenya);
			$consulta->bindValue(':telefon', $telefon);
			$consulta->bindValue(':dni', $dni);
			$consulta->bindValue(':data_naixement', $data_naixement);
			$consulta->bindValue(':nom', $nom);
			$consulta->bindValue(':cognoms', $cognoms);
			$consulta->execute();

			return true;
		} catch (PDOException $e) {
			echo "***Error***: " . $e->getMessage();
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
			$consulta = (BdD::$connection)->prepare('SELECT * FROM `usuari` WHERE id = ?');
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

			echo "Actualització executada correctament.\n";
			return true;
		} catch (PDOException $e) {
			echo "***Error***: " . $e->getMessage() . "\n";
			return false;
		}
	}

	public function deleteUser($userId)
	{
		try {
			$consulta = (BdD::$connection)->prepare('DELETE FROM usuari WHERE id = :id');
			$consulta->bindParam(':id', $userId);
			$consulta->execute();

			echo "Usuari eliminat correctament.\n";
			return true;
		} catch (PDOException $e) {
			echo "***Error***: " . $e->getMessage() . "\n";
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
			echo "***Error***: " . $e->getMessage();
			return false;
		}
	}

	public function updatePassword($userId, $currentPassword, $newPassword)
	{
		try {
			$consulta = (BdD::$connection)->prepare('SELECT contrasenya FROM `usuari` WHERE id = :id');
			$consulta->bindParam(':id', $userId, PDO::PARAM_INT);
			$consulta->execute();
			$user = $consulta->fetch(PDO::FETCH_ASSOC);

			if (password_verify($currentPassword, $user['contrasenya'])) {
				$hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
				$update = (BdD::$connection)->prepare('UPDATE `usuari` SET contrasenya = :newPassword WHERE id = :id');
				$update->bindParam(':newPassword', $hashedPassword, PDO::PARAM_STR);
				$update->bindParam(':id', $userId, PDO::PARAM_INT);
				return $update->execute();
			} else {
				return false;
			}
		} catch (PDOException $e) {
			echo "***Error***: " . $e->getMessage();
			return false;
		}
	}
}
