<?php

class IniciController extends Controller
{

	
	// Processem les dades. pot ser que ens passin o no paràmetres.
	public function process($params)
	{   
		//filtre seguretat per si usuari update
		//$this->verificarSessioUsuari();

		$activitatMNG = new ActivitatManager();
		$activitatLlista = $activitatMNG->selectAll();
		
		if (is_array($activitatLlista)) {
			$this->data['activitatLlista'] = $activitatLlista;
			$this->data['success'] = "Activitats carregades correctament.";
		} else {
			$this->data['activitatLlista'] = [];
			$this->data['multimediaLlista'] = []; // Assegurem que la llista de multimèdia estigui buida
			$this->data['error'] = "No s'han trobat activitats.";
		}
		
		$this->twig = 'inici.html';
	}
}
?>	