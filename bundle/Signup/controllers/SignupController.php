<?php

class SignupController extends Controller
{
    public function process($params)
    {

        $this->data['debug'] = "";

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

            $this->data['debug'] .= " Totes les dades són presents.";
            $this->data['debug'] .= " Les contrasenyes coincideixen.";

            $this->data['debug'] = "Dades rebudes: Usuari: $nom_usuari, Email: $email, Telèfon: $telefon, DNI: $dni, Nom: $nom, Cognoms: $cognoms, Data de naixement: $data_naixement";

            if ($nom_usuari && $email && $contrasenya && $confirmar_contrasenya && $telefon && $dni && $nom && $cognoms && $data_naixement) {
                $this->data['debug'] .= " Totes les dades són presents.";
                if ($contrasenya === $confirmar_contrasenya) {
                    $this->data['debug'] .= " Les contrasenyes coincideixen.";
                    $UsuariMng = new UsuariManager();

                    // Validar si el nom d'usuari ja existeix
                    if ($UsuariMng->comprovarUsuariExistent($nom_usuari)) {
                        $this->data['error'] = "El nom d'usuari '$nom_usuari' ja està en ús.";
                        $this->twig = "signup.html";
                        return;
                    }

                    $hashedPassword = password_hash($contrasenya, PASSWORD_BCRYPT);
                    if ($UsuariMng->registrar($nom_usuari, $email, $hashedPassword, $telefon, $dni, $data_naixement, $nom, $cognoms)) {
                        $this->data['success'] = "Registre exitós per l'usuari: $nom_usuari";
                        $this->login($nom_usuari);
                        $this->redirect("");
                    } else {
                        $this->data['error'] = "Error en el registre per l'usuari: $nom_usuari";
                        $this->twig = "signup.html";
                    }
                } else {
                    $this->data['error'] = "Les contrasenyes no coincideixen!";
                    $this->twig = "signup.html";
                }
            } else {
                $this->data['error'] = "Falten dades!";
                $this->twig = "signup.html";
            }
        } else {
            $this->twig = "signup.html";
        }

        $this->data['debug'] .= " Totes les dades són presents.";
        $this->data['debug'] .= " Les contrasenyes coincideixen.";
    }
} 