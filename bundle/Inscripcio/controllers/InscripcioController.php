<?php

class InscripcioController extends Controller
{
    public function process($params)
    {
        switch ($params[0]) {
            case 'afegir':
                $this->afegirInscripcio($params[1], $params[2]);
                break;
            default:
                $this->twig = 'error.html';
                break;
        }
    }

    private function afegirInscripcio($idActivitat, $idUsuari)
    {
        $inscripcioMNG = new InscripcioManager();
        if ($inscripcioMNG->afegirInscripcio($idActivitat, $idUsuari)) {
            $this->data['success'] = "Inscripció entrada correctament.";
        } else {
            $this->data['error'] = "Error en entrar l'inscripció.";
        }
        $this->twig = 'gestionar_inscripcions.html';
    }
} 