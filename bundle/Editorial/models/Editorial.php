<?php
	//
	// fitxer de dades
	//
	
	//creem una classe on hi guardem les dades de l'editorial
	class Editorial
	{
		var $idEditorial;
		var $nomEditorial;
		var $provincia;
		var $municipi;
		var $web;
		var $email;
		var $telefon;
		
		function __construct($valors=null)
		{
			if ($valors == null) {
				$this->nomEditorial = "<nomEditorial>";
				$this->provincia = "<provincia>";
				$this->municipi = "<Municipi>";
				$this->web = "<web>";
				$this->email = "<email>";
				$this->telefon	= "<Telèfon>";
			}
			else {
				if (is_array($valors)) {
					if (isset($valors["idEditorial"])) $this->idEditorial = $valors["idEditorial"];
					if (isset($valors["nomEditorial"])) $this->nomEditorial = $valors["nomEditorial"];
					if (isset($valors["provincia"])) $this->provincia = $valors["provincia"];
					if (isset($valors["municipi"])) $this->municipi = $valors["municipi"];
					if (isset($valors["web"])) $this->web = $valors["web"];
					if (isset($valors["email"])) $this->email = $valors["email"];
					if (isset($valors["telefon"])) $this->telefon = $valors["telefon"];
				}
			}
		}
		public function Assignar($nomEditorial,$provincia,$municipi,$telefon,$email)
		{
			$this->nomEditorial = $nomEditorial;
			$this->provincia = $provincia;
			$this->municipi = $municipi;
			$this->web = $web;
			$this->email = $email;
			$this->telefon	= $telefon;
		}
		public function getEditorial($parametre = null) {
			return array(
				"idEditorial" =>$this->idEditorial,
				"nomEditorial" =>$this->nomEditorial,
				"provincia" => $this->provincia,
				"municipi" => $this->municipi,
				"web" => $this->web,
				"email" => $this->email,
				"telefon" => $this->telefon
			);
		}
		public function getNom() {
			return ($this->nomEditorial);
		}
			
	}
?>