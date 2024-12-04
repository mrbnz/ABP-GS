<?php
	
	class Usuari
	{
		// Camps bdd
		private $id;
		private $nom;
		private $email;
		private $telefon;
		private $dataNaixement;
		private $nomUsuari;
		private $contrassenya;
		private $dataCreacio;
		private $administrador;


		// Constructor de si pasem valors al crear objecte
		function __construct($valors=null)
		{
			if ($valors == null) {
				$this->id = null;
				$this->nom = null;
				$this->email = null;
				$this->telefon = null;
				$this->dataNaixement = null;
				$this->nomUsuari = null;
				$this->contrassenya = null;
				$this->dataCreacio = null;
				$this->administrador = null;

			}
			else {
				if (is_array($valors)) {
					if (isset($valors["id"])) $this->id = $valors["id"];
					if (isset($valors["nom"])) $this->nom = $valors["nom"];	
					if (isset($valors["email"])) $this->email = $valors["email"];
					if (isset($valors["telefon"])) $this->telefon = $valors["telefon"];
					if (isset($valors["dataNaixement"])) $this->dataNaixement = $valors["dataNaixement"];	
					if (isset($valors["nomUsuari"])) $this->nomUsuari = $valors["nomUsuari"];	
					if (isset($valors["contrassenya"])) $this->contrassenya = $valors["contrassenya"];
					if (isset($valors["dataCreacio"])) $this->dataCreacio = $valors["dataCreacio"];	
					if (isset($valors["administrador"])) $this->administrador = $valors["administrador"];							
					
				}
			}
		}

		// Getters i setters
		public function getId()
		{	
			return $this->id;
		}
	
		public function setId($id)
		{	
			if (isset($id)) $this->id = $id;
		}
	
		public function getNom()
		{
			return $this->nom;
		}
	
		public function setNom($nom)
		{
			if (isset($nom)) $this->nom = $nom;
		}
	
		public function getEmail()
		{
			return $this->email;
		}
	
		public function setEmail($email)
		{
			if (isset($email)) $this->email = $email;
		}
	
		public function getTelefon()
		{
			return $this->telefon;
		}
	
		public function setTelefon($telefon)
		{
			if (isset($telefon)) $this->telefon = $telefon;
		}
	
		public function getDataNaixement()
		{
			return $this->dataNaixement;
		}
	
		public function setDataNaixement($dataNaixement)
		{
			if (isset($dataNaixement)) $this->dataNaixement = $dataNaixement;
		}
	
		public function getNomUsuari()
		{
			return $this->nomUsuari;
		}
	
		public function setNomUsuari($nomUsuari)
		{
			if (isset($nomUsuari)) $this->nomUsuari = $nomUsuari;
		}
	
		public function getContrassenya()
		{
			return $this->contrassenya;
		}
	
		public function setContrassenya($contrassenya)
		{
			if (isset($contrassenya)) $this->contrassenya = $contrassenya;
		}
	
		public function getDataCreacio()
		{
			return $this->dataCreacio;
		}
	
		public function setDataCreacio($dataCreacio)
		{
			if (isset($dataCreacio)) $this->dataCreacio = $dataCreacio;
		}
	
		public function getAdministrador()
		{
			return $this->administrador;
		}
	
		public function setAdministrador($administrador)
		{
			if (isset($administrador)) $this->administrador = $administrador;
		}

		// Mètode __toString per representar l'objecte com a cadena
		public function __toString()
		{
			return "EditorialISBN [id=$this->id, nom=$this->nom, email=$this->email, telefon=$this->telefon, dataNaixement=$this->dataNaixement, nomUsuari=$this->nomUsuari, contrassenya=$this->contrassenya, dataCreacio=$this->dataCreacio, administrador=$this->administrador]";
		}
	}
?>