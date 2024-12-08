<?php

class IniciController extends Controller
{

	// Processem les dades. pot ser que ens passin o no paràmetres.
	public function process($params)
	{   
		// Verificar si l'usuari està actiu
		$this->verificarUsuariActiu();

		$activitatMNG = new ActivitatManager();
		$activitatLlista = $activitatMNG->selectAll();
		
		if (is_array($activitatLlista)) {
			$this->data['activitatLlista'] = $activitatLlista;
		} else {
			$this->data['activitatLlista'] = [];
		}
		
		$this->twig = 'inici.html';
	}
}?>	
