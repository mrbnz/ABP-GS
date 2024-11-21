<?php
	//
	// fitxer de dades
	//
	
	//creem una classe on hi guardem les dades de l'alumne
	class Alumne
	{
		var $id;
		var $dni;
		var $nom;
		var $poblacio;
		var $telefon;
		var $actiu;
		
		function __construct($valors=null)
		{
			if ($valors == null) {
				$this->dni = "<DNI>";
				$this->nom = "<Nom>";
				$this->poblacio = "<Municipi>";
				$this->telefon	= "<Telèfon>";
				$this->actiu = True;
			}
			else {
				if (is_array($valors)) {
					if (isset($valors["id"])) $this->id = $valors["id"];
					if (isset($valors["dni"])) $this->dni = $valors["dni"];
					if (isset($valors["nom"])) $this->nom = $valors["nom"];
					if (isset($valors["poblacio"])) $this->poblacio = $valors["poblacio"];
					if (isset($valors["telefon"])) $this->telefon = $valors["telefon"];
					if (isset($valors["actiu"])) $this->actiu = $valors["actiu"]; else  $this->actiu = 0;
				}
			}
		}
		public function Assignar($dni,$nom,$poblacio,$telefon,$actiu)
		{
			$this->dni = $dni;
			$this->nom = $nom;
			$this->poblacio = $poblacio;
			$this->telefon	= $telefon;
			$this->actiu = $actiu;
		}
		public function getAlumne($parametre = null) {
			return array(
				"id" =>$this->id,
				"dni" =>$this->dni,
				"nom" => $this->nom,
				"poblacio" => $this->poblacio,
				"telefon" => $this->telefon,
				"actiu" => $this->actiu
			);
		}
		public function getNom() {
			return ($this->nom);
		}
			
	}
?>