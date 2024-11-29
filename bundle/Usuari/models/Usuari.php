<?php
	//
	// fitxer de dades
	//
	
	class Usuari
	{
		//camps de dades
		var $id;
		var $nom;
		var $contrasenya;
		
		//constructor de si pasem valors al crear objecte
		function __construct($valors=null)
		{
			if ($valors == null) {
				$this->id = null;
				$this->nom = null;
				$this->contrasenya = null;

			}
			else {
				if (is_array($valors)) {
					if (isset($valors["id"])) $this->id = $valors["id"];
					if (isset($valors["nom"])) $this->nom = $valors["nom"];
					if (isset($valors["contrasenya"])) $this->contrasenya = $valors["contrasenya"];
				}
			}
		}
	}
?>