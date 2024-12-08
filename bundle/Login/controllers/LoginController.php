<?php

/**
 * Gestiona les sol·licituds d'Inici
 * Class LoginController
 */
class LoginController extends Controller
{
	public function process($params)
	{
		//echo "S'ha cridat el mètode process a LoginController<br>";

		// Si hem cridat a Logout
		if (isset($params[0]) && ($params[0] == "logout")) {
			echo "S'ha cridat Logout<br>";
			$this->logout();
		}

		// Si estem logats ja
		if ($this->EstaLogat()) {
			echo "L'usuari ja està logat<br>";
			if (isset($_SESSION['username'])) {
				echo "<script>console.log('Ja estàs logat com a " . $_SESSION['username'] . "');</script>";
			} else {
				echo "<script>console.log('No s'ha pogut determinar l'usuari logat.');</script>";
			}
			$this->data['debug'] = "L'usuari ja està logat";
			$this->redirect("");
		} else {
			if ($_POST) {
				$nom_usuari = isset($_POST["usuari"]) ? trim($_POST["usuari"]) : null;
				$contrasenya = isset($_POST["contrasenya"]) ? $_POST["contrasenya"] : null;


				if ($nom_usuari && $contrasenya) {
					$UsuariMng = new UsuariManager();
					if ($UsuariMng->verificar($nom_usuari, $contrasenya)) {
						echo "Login exitós per l'usuari: " . $nom_usuari . "<br>";
						$this->login($nom_usuari);
						$this->data['success'] = "Login exitós per l'usuari: " . $nom_usuari;
						$this->redirect("");
					} else {
						echo "Login fallit per l'usuari: " . $nom_usuari . "<br>";
						$this->data['error'] = "Login fallit per l'usuari: " . $nom_usuari;
						$this->twig = "login.html";
					}
				} else {
					echo "Falten dades per al login<br>";
					$this->data['error'] = "Falten dades per al login";
					$this->twig = "login.html";
				}
			} else {
				echo "User no logat, enviem a login<br>";
				$this->data['debug'] = "User no logat, enviem a login";
				$this->twig = "login.html";
			}
		}
	}

	public function logout()
	{
		echo "S'ha cridat el mètode logout<br>";
		$UsuariMng = new UsuariManager();
		$UsuariMng->tancar();
		$this->data['debug'] = "S'ha cridat Logout";
		$this->redirect("hola");
	}
}