<?php

class ActivitatController extends Controller
{
    public function process($params)
    {
        $tipusActivitatMNG = new TipusActivitatManager();
        $this->data['llistaTipus'] = $tipusActivitatMNG->selectAll();
        $espaiMNG = new EspaiManager();
        $this->data['llistaEspai'] = $espaiMNG->selectAll();

        $this->twig = "activitat.html";
    }
}
?>