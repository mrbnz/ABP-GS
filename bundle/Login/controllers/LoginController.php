<?php

/**
 * Gestiona les sol·licituds d'Inici
 * Class LoginController
 */
class LoginController extends Controller
{
	public function process($params)
	{
		error_log("Process method called in LoginController");

		// Si hem cridat a Logout
		if (isset($params[0]) && ($params[0] == "logout")) {
			error_log("Logout called");
			$this->logout();
		}

		// Si estem logats ja
		if ($this->EstaLogat()) {
			error_log("User is already logged in");
			if (isset($_SESSION['username'])) {
				echo "<script>console.log('Ja estàs logat com a " . $_SESSION['username'] . "');</script>";
			} else {
				echo "<script>console.log('No s'ha pogut determinar l'usuari logat.');</script>";
			}
			$this->redirect("");
		} else {
			if ($_POST) {
				$nom_usuari = isset($_POST["usuari"]) ? trim($_POST["usuari"]) : null;
				$contrasenya = isset($_POST["contrasenya"]) ? $_POST["contrasenya"] : null;

				error_log("Login attempt for user: " . $nom_usuari);

				if ($nom_usuari && $contrasenya) {
					$UsuariMng = new UsuariManager();
					if ($UsuariMng->verificar($nom_usuari, $contrasenya)) {
						error_log("Login successful for user: " . $nom_usuari);
						$this->login($nom_usuari);
						$this->redirect("");
					} else {
						error_log("Login failed for user: " . $nom_usuari);
						$this->data["missatge"] = "Usuari o contrasenya incorrecte!";
						$this->twig = "login.html";
					}
				} else {
					error_log("Missing data for login");
					$this->data["missatge"] = "Falten dades!";
					$this->twig = "login.html";
				}
			} else {
				$this->twig = "login.html";
			}
		}
	}

	public function logout()
	{
		$UsuariMng = new UsuariManager();
		$UsuariMng->tancar();
		$this->redirect("hola");
	}
}
?>