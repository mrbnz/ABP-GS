<?php

class ActivitatController extends Controller
{
    public function process($params)
    {
        if (isset($params[0]) && is_numeric($params[0])) {
            $this->mostraActivitat($params[0]);
        } else {
            $this->mostraActivitats();
            $this->mostraFiltres();
            $this->twig = "activitat.html";
        }
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

    public function mostraActivitat($id)
    {
        $activitatMNG = new ActivitatManager();
        $activitat = $activitatMNG->getActivitatById($id);
        
        if ($activitat) {
            $this->data['activitat'] = $activitat;
            $this->twig = "detall_activitat.html"; // Assegura't de tenir aquesta plantilla
        } else {
            $this->data['error'] = "Activitat no trobada.";
            $this->twig = "activitat.html";
        }
    }
}
?>