<?php
include('./config/include.php');

class UsuariManager extends Usuari
{

	public function selectUn()
	{
		$resposta = null;
		try {
			$consulta = (BdD::$connection)->prepare('
					SELECT *
					FROM usuaris
					WHERE `id` = :id
				');
			$consulta->bindParam('id', $this->id);
			$consulta->execute();
			if ($consulta->rowCount() > 0) {
				$consulta->setFetchMode(PDO::FETCH_ASSOC);
				$resposta = $consulta->fetch();
				$this->nom = $resposta["nom"];
				$this->contrasenya = $resposta["contrasenya"];
			}
		} catch (PDOException $e) {
			echo "***Error***: " . $e->getMessage();
		}
		return $resposta;
	}

	public function verificar($nom_usuari, $contrasenya)
	{
		if (isset($_SESSION['username'])) {
			echo "<div class='alert alert-info'>Ja estàs logat com a " . $_SESSION['username'] . ".</div>";
			return true;
		} else {
			try {
				$consulta = (BdD::$connection)->prepare('
					SELECT contrassenya
					FROM usuari
					WHERE nom_usuari = :nom_usuari
				');

				$consulta->bindValue(':nom_usuari', $nom_usuari);
				$consulta->execute();
				$resultado = $consulta->fetch(PDO::FETCH_ASSOC);

				if ($resultado && password_verify($contrasenya, $resultado["contrassenya"])) {
					$_SESSION['username'] = $nom_usuari;
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

	public function Login() {
		// Implementació del mètode Login
		// Aquí pots afegir la lògica necessària per al login
	}

	public function registrar($nom_usuari, $email, $contrasenya, $telefon, $dni, $data_naixement, $nom, $cognoms, $es_admin)
	{
		try {
			$consulta = (BdD::$connection)->prepare('
				INSERT INTO usuari (nom_usuari, email, contrassenya, telefon, dni, data_naixement, nom, cognoms, administrador)
				VALUES (:nom_usuari, :email, :contrasenya, :telefon, :dni, :data_naixement, :nom, :cognoms, :administrador)
			');

			$consulta->bindValue(':nom_usuari', $nom_usuari);
			$consulta->bindValue(':email', $email);
			$consulta->bindValue(':contrasenya', $contrasenya);
			$consulta->bindValue(':telefon', $telefon);
			$consulta->bindValue(':dni', $dni);
			$consulta->bindValue(':data_naixement', $data_naixement);
			$consulta->bindValue(':nom', $nom);
			$consulta->bindValue(':cognoms', $cognoms);
			$consulta->bindValue(':administrador', $es_admin);
			$consulta->execute();

			return true;
		} catch (PDOException $e) {
			echo "***Error***: " . $e->getMessage();
			return false;
		}
	}
}
