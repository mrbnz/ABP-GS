<?php

class SignupController extends Controller
{
    public function process($params)
    {
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

            if ($nom_usuari && $email && $contrasenya && $confirmar_contrasenya && $telefon && $dni && $nom && $cognoms && $data_naixement) {
                if ($contrasenya === $confirmar_contrasenya) {
                    $UsuariMng = new UsuariManager();
                    $hashedPassword = password_hash($contrasenya, PASSWORD_BCRYPT);
                    if ($UsuariMng->registrar($nom_usuari, $email, $hashedPassword, $telefon, $dni, $data_naixement, $nom, $cognoms, $es_admin)) {
                        $this->login($nom_usuari);
                        $this->redirect("");
                    } else {
                        $this->data["missatge"] = "Error en el registre!";
                        $this->twig = "signup.html";
                    }
                } else {
                    $this->data["missatge"] = "Les contrasenyes no coincideixen!";
                    $this->twig = "signup.html";
                }
            } else {
                $this->data["missatge"] = "Falten dades!";
                $this->twig = "signup.html";
            }
        } else {
            $this->twig = "signup.html";
        }
    }
} 