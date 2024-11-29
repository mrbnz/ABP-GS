<?php

/**
 * Gestiona les sol·licituds de Cotxes
 * Class CotxesController
 */
class LoginController extends Controller
{
	public function process($params)
	{
		// Si hem cridat a Logout
		if (isset($params[0]) && ($params[0]=="logout"))
			$this->logout();

		// Si estem logats ja
		if ($this->EstaLogat())
		{
			$this->redirect("");
			echo "<div class='alert alert-info'>Ja estàs logat com a " . $_SESSION['username'] . ".</div>";
		}
		else
		{
			if ($_POST)
			{
				$nom_usuari = isset($_POST["usuari"]) ? trim($_POST["usuari"]) : null;
				$contrasenya = isset($_POST["contrasenya"]) ? $_POST["contrasenya"] : null;

				if ($nom_usuari && $contrasenya) {
					$UsuariMng = new UsuariManager();
					if ($UsuariMng->verificar($nom_usuari, $contrasenya)) {
						$this->login($nom_usuari);
						$this->redirect("");
					} else {
						error_log("Login fallit per usuari: " . $nom_usuari);
						$this->data["missatge"] = "Usuari o contrasenya incorrecte!";
						$this->twig = "login.html";
					}
				} else {
					$this->data["missatge"] = "Falten dades!";
					$this->twig = "login.html";
				}
			}
			else
				{
					$this->twig = "login.html";
				}
		}
	}
}
?>