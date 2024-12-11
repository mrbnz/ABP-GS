<?php

class OrganitzadorController extends Controller
{
    public function process($params)
    {
        switch ($params[0]) {
            case 'assignar':
                $this->assignarOrganitzador($params[1], $params[2]);
                break;
            default:
                $this->twig = 'error.html';
                break;
        }
    }

    private function assignarOrganitzador($idActivitat, $idUsuari)
    {
        $organitzadorMNG = new OrganitzadorManager();
        if ($organitzadorMNG->assignarOrganitzador($idActivitat, $idUsuari)) {
            $this->data['success'] = "Organitzador assignat correctament.";
        } else {
            $this->data['error'] = "Error en assignar l'organitzador.";
        }
        $this->twig = 'assignar_organitzador.html';
    }
} 