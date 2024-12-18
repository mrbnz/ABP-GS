<?php

class UsuariController extends Controller
{
    public function process($params)
    {

        //filtre seguretat per si usuari update
        $this->verificarSessioUsuari();

        if (!$this->EstaLogat()) {
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
                $this->logout();
                break;
            case 'editarPerfil':
                $this->editarPerfil();
                break;
            case 'updateProfile':
                $this->updateProfile();
                break;
            case 'canviarContrasenya':
                $this->mostrarCanviarContrasenya();
                break;
            case 'deleteUser':
                $this->deleteUser();
                break;
            default:
                $this->mostrarPanell($params);
                break;
        }
    }

    private function mostrarPanell($params)
    {
        $usuariMng = new UsuariManager();
        $userId = $_SESSION['username'] ?? null;
        if ($userId) {
            $usuari = $usuariMng->getUserById($userId);
            $this->data['usuari'] = $usuari;
            // $this->data['debug'] = "ID d'usuari obtingut de la sessió: " . $userId;
        } else {
            $this->data['error'] = "No s'ha proporcionat un ID d'usuari vàlid.";
        }
        $this->twig = 'menu_usuari.html';
    }

    private function veureInfo()
    {
        $usuariMng = new UsuariManager();
        $username = $_SESSION['username'] ?? null;
        if ($username) {
            $usuari = $usuariMng->getUserByUsername($username);
            if ($usuari) {
                $this->data['usuari'] = $usuari;
                $this->twig = 'perfil_usuari.html';
                // $this->data['success'] = "Usuari trobat: " . $usuari['nom_usuari'];
            } else {
                $this->data['error'] = "Usuari no trobat.";
                $this->twig = 'menu_usuari.html';
            }
        } else {
            $this->data['error'] = "Usuari no trobat.";
            $this->twig = 'menu_usuari.html';
        }
    }

    private function updatePassword()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuariMng = new UsuariManager();
            $username = $_SESSION['username'] ?? null;
            $currentPassword = $_POST['currentPassword'] ?? null;
            $newPassword = $_POST['newPassword'] ?? null;
            $confirmPassword = $_POST['confirmPassword'] ?? null;

            if ($username && $currentPassword && $newPassword && $confirmPassword) {
                if ($newPassword === $confirmPassword) {
                    // Obtenir l'usuari per ID
                    $usuari = $usuariMng->getUserByUsername($username);
                    
                    if ($usuari) {
                        if (!empty($usuari['contrassenya'])) {
                            if ($usuari && password_verify($currentPassword, $usuari['contrassenya'])) {
                                // Actualitzar la contrasenya
                                if ($usuariMng->updatePassword($usuari['id'], $currentPassword, $newPassword)) {
                                    $this->data['success'] = "Contrasenya actualitzada correctament.";
                                } else {
                                    $this->data['error'] = "Error en actualitzar la contrasenya.";
                                }
                            } else {
                                $this->data['error'] = "Contrasenya actual incorrecta.";
                            }
                        } else {
                            $this->data['error'] = "L'usuari no té una contrasenya registrada.";
                        }
                    } else {
                        $this->data['error'] = "Usuari no trobat.";
                    }
                } else {
                    $this->data['error'] = "Les noves contrasenyes no coincideixen.";
                }
            } else {
                $this->data['error'] = "Falten dades!";
            }

            $this->twig = 'canviar_contrasenya.html';
        } else {
            $this->twig = 'canviar_contrasenya.html';
        }
    }

    private function editarPerfil()
    {
        $usuariMng = new UsuariManager();
        $username = $_SESSION['username'] ?? null;
        if ($username) {
            $usuari = $usuariMng->getUserByUsername($username);
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
            $username = $_SESSION['username'] ?? null;
            $nomUsuari = $_POST['nomUsuari'] ?? null;
            $email = $_POST['email'] ?? null;
            $telefon = $_POST['telefon'] ?? null;
            $dni = $_POST['dni'] ?? null;
            $dataNaixement = $_POST['data_naixement'] ?? null;
            $nom = $_POST['nom'] ?? null;
            $cognoms = $_POST['cognoms'] ?? null;

            if ($username && $nomUsuari && $email && $telefon && $dni && $dataNaixement && $nom && $cognoms) {
                if ($usuariMng->updateUserByUsername($username, $nomUsuari, $email, $telefon, $dni, $dataNaixement, $nom, $cognoms)) {
                    $this->data['success'] = "Perfil actualitzat correctament.";
                    $this->redirect("inici"); // Redirigeix a la pàgina d'inici
                } else {
                    $this->data['error'] = "Error en actualitzar el perfil.";
                }
            } else {
                $this->data['error'] = "Falten dades!";
            }
            $this->editarPerfil();
        }
    }

    private function mostrarCanviarContrasenya()
    {
        $this->twig = 'canviar_contrasenya.html';
    }

} 