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
            default:
                $this->mostrarPanell();
                break;
        }
    }

    private function mostrarPanell()
    {
        $this->twig = 'panell_usuari.html';
    }

    private function veureInfo()
    {
        $usuariMng = new UsuariManager();
        $usuari = $usuariMng->getUserById($_SESSION['username']);
        $this->data['usuari'] = $usuari;
        $this->twig = 'perfil_usuari.html';
    }

    private function updatePassword()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $currentPassword = $_POST['current_password'];
            $newPassword = $_POST['new_password'];
            $confirmPassword = $_POST['confirm_password'];
            // Lógica para actualizar la contraseña
        }
    }
} 