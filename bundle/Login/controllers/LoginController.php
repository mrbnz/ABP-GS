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
			//$this->data['debug'] = "S'ha cridat Logout";
			$this->logout();
		}

		// Si estem logats ja
		if ($this->EstaLogat()) {
			//$this->data['debug'] = "L'usuari ja està logat";
			if (isset($_SESSION['username'])) {
				//$this->data['debug'] .= "<script>console.log('Ja estàs logat com a " . $_SESSION['username'] . "');</script>";
			} else {
				//$this->data['debug'] .= "<script>console.log('No s'ha pogut determinar l'usuari logat.');</script>";
			}
			$this->redirect("");
		} else {
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				$nom_usuari = isset($_POST["usuari"]) ? trim($_POST["usuari"]) : null;
				$contrasenya = isset($_POST["contrasenya"]) ? $_POST["contrasenya"] : null;
				$recorda = isset($_POST["recorda"]) ? $_POST["recorda"] : null;

				if ($nom_usuari && $contrasenya) {
					$UsuariMng = new UsuariManager();
					if ($UsuariMng->verificar($nom_usuari, $contrasenya)) {
						$this->data['success'] = "Login exitós per l'usuari: " . htmlspecialchars($nom_usuari, ENT_QUOTES, 'UTF-8');
						$this->login($nom_usuari);

						// Si l'usuari ha marcat "Recorda'm", crea una cookie
						if ($recorda) {
							setcookie("session_username", $nom_usuari, time() + (86400 * 30), "/", "", false, true);
							error_log("Cookie 'session_username' establerta a: " . $nom_usuari);
						} else {
							// Si no s'ha marcat, s'elimina la cookie si existeix
							if (isset($_COOKIE["session_username"])) {
								setcookie("session_username", "", time() - 3600, "/", "", false, true);
								error_log("Cookie 'session_username' eliminada.");
							}
						}

						$this->redirect(""); // Redirigeix a la pàgina principal
					} else {
						$this->data['error'] = "Login fallit per l'usuari: " . htmlspecialchars($nom_usuari, ENT_QUOTES, 'UTF-8');
						$this->twig = "login.html";
					}
				} else {
					$this->data['error'] = "Falten dades per al login";
					$this->twig = "login.html";
				}
			} else {
				// Passa el nom d'usuari des de la cookie si existeix
				$this->data['savedUsername'] = isset($_COOKIE["session_username"]) ? htmlspecialchars($_COOKIE["session_username"], ENT_QUOTES, 'UTF-8') : '';
				$this->twig = "login.html";
			}
		}
	}

	public function logout()
	{
		//$this->data['debug'] = "S'ha cridat el mètode logout";
		$UsuariMng = new UsuariManager();
		$UsuariMng->tancar();
		//$this->data['debug'] = "S'ha cridat Logout";
		// Elimina la cookie de username
		if (isset($_COOKIE["session_username"])) {
			setcookie("session_username", "", time() - 3600, "/", "", false, true);
		}
		$this->redirect("");
	}
}