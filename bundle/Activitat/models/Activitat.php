<?php
class Activitat
{
    // Camps de la base de dades
    private $id;
    private $idEspai;
    private $nom;
    private $descripcioBreu;
    private $descripcio;
    private $data;
    private $placesTotals;
    private $placesOcupades;
    private $preu;

    // Constructor
    public function __construct($valors = null)
    {
        if ($valors === null) {
            $this->id = null;
            $this->idEspai = null;
            $this->nom = null;
            $this->descripcioBreu = null;
            $this->descripcio = null;
            $this->data = null;
            $this->placesTotals = null;
            $this->placesOcupades = null;
            $this->preu = null;
        } else if (is_array($valors)) {
            if (isset($valors["id"]))$this->id = $valors["id"];
            if (isset($valors["idEspai"]))$this->idEspai = $valors["idEspai"] ?? null;
            if (isset($valors["nom"]))$this->nom = $valors["nom"] ?? null;
            if (isset($valors["descripcioBreu"]))$this->descripcioBreu = $valors["descripcioBreu"] ?? null;
            if (isset($valors["descripcio"]))$this->descripcio = $valors["descripcio"] ?? null;
            if (isset($valors["data"]))$this->data = $valors["data"] ?? null;
            if (isset($valors["placesTotals"]))$this->placesTotals = $valors["placesTotals"] ?? null;
            if (isset($valors["placesOcupades"]))$this->placesOcupades = $valors["placesOcupades"] ?? null;
            if (isset($valors["preu"]))$this->preu = $valors["preu"] ?? null;
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

    public function getIdEspai()
    {
        return $this->idEspai;
    }

    public function setIdEspai($idEspai)
    {
        if (isset($idEspai)) $this->idEspai = $idEspai;
    }

    public function getNom()
    {
        return $this->nom;
    }

    public function setNom($nom)
    {
        if (isset($nom)) $this->nom = $nom;
    }

    public function getDescripcioBreu()
    {
        return $this->descripcioBreu;
    }

    public function setDescripcioBreu($descripcioBreu)
    {
        if (isset($descripcioBreu)) $this->descripcioBreu = $descripcioBreu;
    }

    public function getDescripcio()
    {
        return $this->descripcio;
    }

    public function setDescripcio($descripcio)
    {
        if (isset($descripcio)) $this->descripcio = $descripcio;
    }

    public function getData()
    {
        return $this->data;
    }

    public function setData($data)
    {
        if (isset($data)) $this->data = $data;
    }

    public function getPlacesTotals()
    {
        return $this->placesTotals;
    }

    public function setPlacesTotals($placesTotals)
    {
        if (isset($placesTotals)) $this->placesTotals = $placesTotals;
    }

    public function getPlacesOcupades()
    {
        return $this->placesOcupades;
    }

    public function setPlacesOcupades($placesOcupades)
    {
        if (isset($placesOcupades)) $this->placesOcupades = $placesOcupades;
    }

    public function getPreu()
    {
        return $this->preu;
    }

    public function setPreu($preu)
    {
        if (isset($preu)) $this->preu = $preu;
    }

    // Mètode __toString per representar l'objecte com a cadena
    public function __toString()
    {
        return "Activitat [id=$this->id, idEspai=$this->idEspai, nom=$this->nom, descripcioBreu=$this->descripcioBreu, descripcio=$this->descripcio, data=$this->data, placesTotals=$this->placesTotals, placesOcupades=$this->placesOcupades, preu=$this->preu]";
    }
}
?>
