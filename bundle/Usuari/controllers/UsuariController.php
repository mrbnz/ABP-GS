<?php

class UsuariController extends Controller
{
    public function process($params)
    {
        if (!isset($_SESSION['username'])) {
            $this->redirect('login');
            return;
        }
    
        $action = $params[0] ?? 'panell';
    
        switch ($action) {
            case 'veureInfo':
                $this->veureInfo();
                break;
            case 'updatePassword':
                $this->updatePassword();
                break;
            case 'logout':
                $this->logout(); // Crida al mètode logout del controlador base
                break;
            case 'editarPerfil':
                $this->editarPerfil();
                break;
            default:
                $this->mostrarPanell($params);
                break;
        }
    }
    private function mostrarPanell($params)
    {
        $usuariMng = new UsuariManager();
        $userId = $_SESSION['username'] ?? null; // Obtenim l'ID d'usuari de la sessió
        if ($userId) {
            $usuari = $usuariMng->getUserById($userId);
            $this->data['usuari'] = $usuari;
            $this->data['debug'] = "ID d'usuari obtingut de la sessió: " . $userId;
        } else {
            $this->data['error'] = "No s'ha proporcionat un ID d'usuari vàlid.";
        }
        $this->twig = 'menu_usuari.html';
    }

    private function veureInfo()
    {
        $usuariMng = new UsuariManager();
        $userId = $_SESSION['username'] ?? null; // Obtenim l'ID d'usuari de la sessió
        if ($userId) {
            $usuari = $usuariMng->getUserById($userId);
            if ($usuari) {
                $this->data['usuari'] = $usuari;
                $this->twig = 'perfil_usuari.html';
            } else {
                $this->data['error'] = "Usuari no trobat.";
                $this->twig = 'menu_usuari.html';
            }
        } else {
            $this->data['error'] = "No s'ha pogut obtenir la informació de l'usuari.";
            $this->twig = 'menu_usuari.html';
        }
    }

    private function updatePassword()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $currentPassword = $_POST['current_password'];
            $newPassword = $_POST['new_password'];
            $confirmPassword = $_POST['confirm_password'];
            // Lógica para actualizar la contraseña
            // Asegúrate de validar y actualizar la contraseña de manera segura
        }
    }

    private function editarPerfil()
    {
        $usuariMng = new UsuariManager();
        $userId = $_SESSION['username'] ?? null; // Obtenim l'ID d'usuari de la sessió
        if ($userId) {
            $usuari = $usuariMng->getUserById($userId);
            if ($usuari) {
                $this->data['usuari'] = $usuari;
                $this->twig = 'editar_perfil.html';
            } else {
                $this->data['error'] = "Usuari no trobat.";
                $this->twig = 'menu_usuari.html';
            }
        } else {
            $this->data['error'] = "No s'ha pogut obtenir la informació de l'usuari.";
            $this->twig = 'menu_usuari.html';
        }
    }

    private function updateProfile()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuariMng = new UsuariManager();
            $userId = $_SESSION['username'] ?? null;
            $nomUsuari = $_POST['nomUsuari'] ?? null;
            $email = $_POST['email'] ?? null;
            $telefon = $_POST['telefon'] ?? null;
            $dni = $_POST['dni'] ?? null;
            $dataNaixement = $_POST['data_naixement'] ?? null;
            $nom = $_POST['nom'] ?? null;
            $cognoms = $_POST['cognoms'] ?? null;

            if ($userId && $nomUsuari && $email && $telefon && $dni && $dataNaixement && $nom && $cognoms) {
                $novenoArgumento = 'valor_por_defecto'; // Asegúrate de definir el noveno argumento necesario
                if ($usuariMng->updateUser($userId, $nomUsuari, $email, $telefon, $dni, $dataNaixement, $nom, $cognoms, $novenoArgumento)) {
                    $this->data['success'] = "Perfil actualitzat correctament.";
                } else {
                    $this->data['error'] = "Error en actualitzar el perfil.";
                }
            } else {
                $this->data['error'] = "Falten dades!";
            }
            $this->editarPerfil();
        }
    }
} 