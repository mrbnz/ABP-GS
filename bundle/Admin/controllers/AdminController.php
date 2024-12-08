<?php

class AdminController extends Controller
{
    public function process($params)
    {
        // Verificar si l'usuari està actiu
		$this->verificarUsuariActiu();

        $usuariMng = new UsuariManager();

        // Comprovar si l'usuari és administrador
        if (!$usuariMng->esAdmin()) {
            $this->redirect('login');
        }

        // Determinar l'acció a realitzar
        $action = $params[0] ?? 'dashboard';

        if (!isset($_SESSION['username'])) {
            $this->redirect('login');
            return;
        }

        switch ($action) {
            case 'edit_user':
                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['userId'])) {
                    $userId = $_POST['userId'];
                    if (!isset($userId) || !is_numeric($userId)) {
                        echo "ID no vàlid.";
                        return null;
                    }
                    $user = $usuariMng->getUserById($userId);
                    if ($user) {
                        $this->data['user'] = $user;
                    } else {
                        $this->data['error'] = "Usuari no trobat.";
                    }
                }
                $this->twig = 'edit_user.html';
                break;
            case 'update_user':
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $userId = $_POST['userId'] ?? null;
                    $nomUsuari = $_POST['nomUsuari'] ?? null;
                    $email = $_POST['email'] ?? null;
                    $telefon = $_POST['telefon'] ?? null;
                    $dni = $_POST['dni'] ?? null;
                    $dataNaixement = $_POST['data_naixement'] ?? null;
                    $nom = $_POST['nom'] ?? null;
                    $cognoms = $_POST['cognoms'] ?? null;
                    $administrador = $_POST['administrador'] ?? null;

                    if ($userId && $nomUsuari && $email && $telefon && $dni && $dataNaixement && $nom && $cognoms && $administrador !== null) {
                        if ($usuariMng->updateUser($userId, $nomUsuari, $email, $telefon, $dni, $dataNaixement, $nom, $cognoms, $administrador)) {
                            error_log("Usuari actualitzat correctament.");
                        } else {
                            error_log("Error en actualitzar l'usuari.");
                        }
                    } else {
                        echo "Falten dades!";
                    }
                    $this->twig = 'edit_user.html';
                }
                break;
            case 'edit_activity':
                $this->twig = 'edit_activity.html';
                break;
            case 'assign_activity':
                $this->twig = 'assign_activity.html';
                break;
            case 'delete_user':
                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['userId'])) {
                    $userId = $_POST['userId'];
                    // Comprovar si l'usuari que s'intenta eliminar és el que està loguejat
                    if ($userId == $_SESSION['username']) {
                        echo "No es pot eliminar l'usuari que està loguejat.";
                    } else {
                        if ($usuariMng->deleteUser($userId)) {
                            echo "Usuari eliminat correctament.";
                        } else {
                            error_log("Error en eliminar l'usuari.");
                        }
                    }
                }
                $this->twig = 'delete_user.html';
                break;
            case 'config':
                $this->twig = 'config.html';
                break;
            case 'view_users':
                $users = $usuariMng->getAllUsers();
                if ($users) {
                    $this->data['users'] = $users;
                } else {
                    $this->data['error'] = "No s'han pogut obtenir els usuaris.";
                }
                $this->twig = 'view_users.html';
                break;
            default:
                $this->twig = 'admin.html';
                break;
        }
    }
}?> 
