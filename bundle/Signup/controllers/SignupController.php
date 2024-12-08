<?php

class SignupController extends Controller
{
    public function process($params)
    {
        if (isset($_SESSION['username'])) {
            echo "Ja estàs logat com a " . htmlspecialchars($_SESSION['username'], ENT_QUOTES, 'UTF-8') . ". No pots registrar-te de nou.";
            $this->redirect("");
            return;
        }

        if ($_POST) {
            $nom_usuari = htmlspecialchars(trim($_POST["nom_usuari"]), ENT_QUOTES, 'UTF-8');
            $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
            $contrasenya = $_POST["contrasenya"];
            $confirmar_contrasenya = $_POST["confirmar_contrasenya"];
            $telefon = htmlspecialchars(trim($_POST["telefon"]), ENT_QUOTES, 'UTF-8');
            $dni = htmlspecialchars(trim($_POST["dni"]), ENT_QUOTES, 'UTF-8');
            $nom = htmlspecialchars(trim($_POST["nom"]), ENT_QUOTES, 'UTF-8');
            $cognoms = htmlspecialchars(trim($_POST["cognoms"]), ENT_QUOTES, 'UTF-8');
            $data_naixement = htmlspecialchars($_POST["data_naixement"], ENT_QUOTES, 'UTF-8');
            
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