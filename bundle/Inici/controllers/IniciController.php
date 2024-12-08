<?php

class IniciController extends Controller
{

	// Processem les dades. pot ser que ens passin o no paràmetres.
	public function process($params)
	{   
		$activitatMNG = new ActivitatManager();
		$activitatLlista = $activitatMNG->selectAll();
		
		if (is_array($activitatLlista)) {
			$this->data['activitatLlista'] = $activitatLlista;
		} else {
			$this->data['activitatLlista'] = [];
		}
		
		$this->twig = 'inici.html';
	}


	function mostraTots($missatge=null) {
		$activitatMNG = new ActivitatManager();
		// Seleccionem tots
		$activitatLlista = $activitatMNG->selectAll();
		
		if (is_array($activitatLlista)) { // Comprovar si és un array
			foreach($activitatLlista as $activitat) {
				$this->data['activitatLlista'] = $activitat;
				print_r($activitat);
			}
		} else {
			// Manejar el cas quan no és un array
			echo "No s'han trobat activitats.";
		}
		
		print("<pre>");var_dump($this->data);print("</pre>");
		//$this->twig = 'llistaTots.html';
		if ($missatge)
			$this->data["missatge"] = "Això és un missatge";
	}
}
?>	