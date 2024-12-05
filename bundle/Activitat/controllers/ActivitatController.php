<?php

class ActivitatController extends Controller
{
    public function process($params)
    {
        $this->mostraActivitats();
        $this->mostraFiltres();
        
        $this->twig = "activitat.html";
    }

    public function mostraFiltres (){
        $tipusActivitatMNG = new TipusActivitatManager();
        $this->data['llistaTipus'] = $tipusActivitatMNG->selectAll();
        $espaiMNG = new EspaiManager();
        $this->data['llistaEspai'] = $espaiMNG->selectAll();
    }

    public function mostraActivitats(){
        $activitatMNG = new ActivitatManager();
		$activitatLlista = $activitatMNG->selectAll();
		
		if (is_array($activitatLlista)) {
			$this->data['activitatLlista'] = $activitatLlista;
		} else {
			$this->data['activitatLlista'] = [];
		}
    }
    public function filtrarActivitats(){
        
    }
}
?>