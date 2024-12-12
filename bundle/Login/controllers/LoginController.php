<?php

/**
 * Gestiona les sol·licituds d'Inici
 * Class LoginController
 */
class LoginController extends Controller
{
	public function process($params)
	{
		//$this->data['debug'] = "S'ha cridat el mètode process a LoginController";

		// Si hem cridat a Logout
		if (isset($params[0]) && ($params[0] == "logout")) {
			$this->data['debug'] = "S'ha cridat Logout";
			$this->logout();
		}

		// Si estem logats ja
		if ($this->EstaLogat()) {
			$this->data['debug'] = "L'usuari ja està logat";
			if (isset($_SESSION['username'])) {
				$this->data['debug'] .= "<script>console.log('Ja estàs logat com a " . $_SESSION['username'] . "');</script>";
			} else {
				$this->data['debug'] .= "<script>console.log('No s'ha pogut determinar l'usuari logat.');</script>";
			}
			$this->redirect("");
		} else {
			if ($_POST) {
				$nom_usuari = isset($_POST["usuari"]) ? trim($_POST["usuari"]) : null;
				$contrasenya = isset($_POST["contrasenya"]) ? $_POST["contrasenya"] : null;
				$recorda = isset($_POST["recorda"]) ? $_POST["recorda"] : null;

				if ($nom_usuari && $contrasenya) {
					$UsuariMng = new UsuariManager();
					if ($UsuariMng->verificar($nom_usuari, $contrasenya)) {
						$this->data['success'] = "Login exitós per l'usuari: " . $nom_usuari;
						$this->login($nom_usuari);

						// Si l'usuari ha marcat "Recorda'm", crea una cookie
						if ($recorda) {
							setcookie("session_username", $nom_usuari, time() + (86400 * 30), "/"); // Cookie per 30 dies
						}

						$this->redirect("");
					} else {
						$this->data['error'] = "Login fallit per l'usuari: " . $nom_usuari;
						$this->twig = "login.html";
					}
				} else {
					$this->data['error'] = "Falten dades per al login";
					$this->twig = "login.html";
				}
			} else {
				$this->data['debug'] = "User no logat, enviem a login";
				$this->twig = "login.html";
			}
		}
	}

	public function logout()
	{
		$this->data['debug'] = "S'ha cridat el mètode logout";
		$UsuariMng = new UsuariManager();
		$UsuariMng->tancar();
		$this->data['debug'] = "S'ha cridat Logout";
		$this->redirect("hola");
	}
}