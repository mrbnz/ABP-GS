<?php

class SignupController extends Controller
{
    public function process($params)
    {
        if (isset($_SESSION['username'])) {
            echo "Ja estàs logat com a " . $_SESSION['username'] . ". No pots registrar-te de nou.";
            //$this->data["missatge"] = "Ja estàs logat. No pots registrar-te de nou.";
			$this->redirect("");
            return;
        }

        if ($_POST) {
            $nom_usuari = trim($_POST["nom_usuari"]);
            $email = trim($_POST["email"]);
            $contrasenya = $_POST["contrasenya"];
            $confirmar_contrasenya = $_POST["confirmar_contrasenya"];
            $telefon = trim($_POST["telefon"]);
            $dni = trim($_POST["dni"]);
            $nom = trim($_POST["nom"]);
            $cognoms = trim($_POST["cognoms"]);
            $data_naixement = $_POST["data_naixement"];
            $es_admin = isset($_POST["es_admin"]) ? 1 : 0;

            echo "Dades rebudes: Usuari: $nom_usuari, Email: $email, Telèfon: $telefon, DNI: $dni, Nom: $nom, Cognoms: $cognoms, Data de naixement: $data_naixement<br>";

            if ($nom_usuari && $email && $contrasenya && $confirmar_contrasenya && $telefon && $dni && $nom && $cognoms && $data_naixement) {
                echo "Totes les dades són presents.<br>";
                if ($contrasenya === $confirmar_contrasenya) {
                    echo "Les contrasenyes coincideixen.<br>";
                    $UsuariMng = new UsuariManager();
                    $hashedPassword = password_hash($contrasenya, PASSWORD_BCRYPT);
                    if ($UsuariMng->registrar($nom_usuari, $email, $hashedPassword, $telefon, $dni, $data_naixement, $nom, $cognoms, $es_admin)) {
                        echo "Registre exitós per l'usuari: $nom_usuari<br>";
                        $this->login($nom_usuari);
                        $this->redirect("");
                    } else {
                        echo "Error en el registre per l'usuari: $nom_usuari<br>";
                        $this->data["missatge"] = "Error en el registre!";
                        $this->twig = "signup.html";
                    }
                } else {
                    echo "Les contrasenyes no coincideixen!<br>";
                    $this->data["missatge"] = "Les contrasenyes no coincideixen!";
                    $this->twig = "signup.html";
                }
            } else {
                echo "Falten dades!<br>";
                $this->data["missatge"] = "Falten dades!";
                $this->twig = "signup.html";
            }
        } else {
            $this->twig = "signup.html";
        }
    }
} 