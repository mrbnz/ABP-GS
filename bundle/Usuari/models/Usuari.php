<?php
	
	class Usuari
	{
		// Camps bdd
		private $id;
		private $nom;
		private $cognoms;
		private $email;
		private $telefon;
		private $dni;
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
				$this->cognoms = null;
				$this->email = null;
				$this->telefon = null;
				$this->dni = null;
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
					if (isset($valors["cognoms"])) $this->cognoms = $valors["cognoms"];
					if (isset($valors["email"])) $this->email = $valors["email"];
					if (isset($valors["telefon"])) $this->telefon = $valors["telefon"];
					if (isset($valors["dni"])) $this->dni = $valors["dni"];
					if (isset($valors["data_naixement"])) $this->dataNaixement = $valors["data_naixement"];	
					if (isset($valors["nom_usuari"])) $this->nomUsuari = $valors["nom_usuari"];	
					if (isset($valors["contrassenya"])) $this->contrassenya = $valors["contrassenya"];
					if (isset($valors["data_creacio"])) $this->dataCreacio = $valors["data_creacio"];	
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
	
		public function getCognoms()
		{
			return $this->cognoms;
		}
	
		public function setCognoms($cognoms)
		{
			if (isset($cognoms)) $this->cognoms = $cognoms;
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
	
		public function getDni()
		{
			return $this->dni;
		}
	
		public function setDni($dni)
		{
			if (isset($dni)) $this->dni = $dni;
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
			return "EditorialISBN [id=$this->id, nom=$this->nom, cognoms=$this->cognoms, email=$this->email, telefon=$this->telefon, dni=$this->dni, dataNaixement=$this->dataNaixement, nomUsuari=$this->nomUsuari, contrassenya=$this->contrassenya, dataCreacio=$this->dataCreacio, administrador=$this->administrador]";
		}
	}
?>