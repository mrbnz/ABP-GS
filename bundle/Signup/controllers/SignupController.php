<?php

class SignupController extends Controller
{
    public function process($params)
    {
        if (isset($_SESSION['username'])) {
            $this->data['missatge'] = "Ja estàs logat com a " . $_SESSION['username'] . ". No pots registrar-te de nou.";
			$this->redirect("");
            return;
        }

        if ($_POST) {
            $nom_usuari = filter_input(INPUT_POST, 'nom_usuari', FILTER_SANITIZE_STRING);
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $contrasenya = $_POST["contrasenya"];
            $confirmar_contrasenya = $_POST["confirmar_contrasenya"];
            $telefon = filter_input(INPUT_POST, 'telefon', FILTER_SANITIZE_STRING);
            $dni = filter_input(INPUT_POST, 'dni', FILTER_SANITIZE_STRING);
            $nom = filter_input(INPUT_POST, 'nom', FILTER_SANITIZE_STRING);
            $cognoms = filter_input(INPUT_POST, 'cognoms', FILTER_SANITIZE_STRING);
            $data_naixement = filter_input(INPUT_POST, 'data_naixement', FILTER_SANITIZE_STRING);

            echo "Dades rebudes: Usuari: $nom_usuari, Email: $email, Telèfon: $telefon, DNI: $dni, Nom: $nom, Cognoms: $cognoms, Data de naixement: $data_naixement<br>";

            if ($nom_usuari && $email && $contrasenya && $confirmar_contrasenya && $telefon && $dni && $nom && $cognoms && $data_naixement) {
                echo "Totes les dades són presents.<br>";
                if ($contrasenya === $confirmar_contrasenya) {
                    echo "Les contrasenyes coincideixen.<br>";
                    $UsuariMng = new UsuariManager();
                    $hashedPassword = password_hash($contrasenya, PASSWORD_BCRYPT);
                    if ($UsuariMng->registrar($nom_usuari, $email, $hashedPassword, $telefon, $dni, $data_naixement, $nom, $cognoms)) {
                        echo "Registre exitós per l'usuari: $nom_usuari<br>";
                        $this->login($nom_usuari);
                        $this->redirect("");
                        $this->data['success'] = "Registre exitós per l'usuari: $nom_usuari";
                    } else {
                        echo "Error en el registre per l'usuari: $nom_usuari<br>";
                        $this->data['error'] = "Error en el registre per l'usuari: $nom_usuari";
                        $this->twig = "signup.html";
                    }
                } else {
                    echo "Les contrasenyes no coincideixen!<br>";
                    $this->data['error'] = "Les contrasenyes no coincideixen!";
                    $this->twig = "signup.html";
                }
            } else {
                echo "Falten dades!<br>";
                $this->data['error'] = "Falten dades!";
                $this->twig = "signup.html";
            }
        } else {
            $this->twig = "signup.html";
        }

        $this->data['debug'] = "Totes les dades són presents.";
        $this->data['debug'] = "Les contrasenyes coincideixen.";
    }
} 