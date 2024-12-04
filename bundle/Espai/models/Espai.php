<?php
class Espai
{
    // Camps de la base de dades
    private $id;
    private $nom;
    private $ubicacio;
    private $capacitat;
    private $descripcio;

    // Constructor
    public function __construct($valors = null)
    {
        if ($valors === null) {
            $this->id = null;
            $this->nom = null;
            $this->ubicacio = null;
            $this->capacitat = null;
            $this->descripcio = null;
        } else if (is_array($valors)) {
            if (isset($valors["id"])) $this->id = $valors["id"];
            if (isset($valors["nom"])) $this->nom = $valors["nom"];
            if (isset($valors["ubicacio"])) $this->ubicacio = $valors["ubicacio"];
            if (isset($valors["capacitat"])) $this->capacitat = $valors["capacitat"];
            if (isset($valors["descripcio"])) $this->descripcio = $valors["descripcio"];
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

    public function getUbicacio()
    {
        return $this->ubicacio;
    }

    public function setUbicacio($ubicacio)
    {
        if (isset($ubicacio)) $this->ubicacio = $ubicacio;
    }

    public function getCapacitat()
    {
        return $this->capacitat;
    }

    public function setCapacitat($capacitat)
    {
        if (isset($capacitat)) $this->capacitat = $capacitat;
    }

    public function getDescripcio()
    {
        return $this->descripcio;
    }

    public function setDescripcio($descripcio)
    {
        if (isset($descripcio)) $this->descripcio = $descripcio;
    }

    // Mètode __toString per representar l'objecte com a cadena
    public function __toString()
    {
        return "Espai [id=$this->id, nom=$this->nom, ubicacio=$this->ubicacio, capacitat=$this->capacitat, descripcio=$this->descripcio]";
    }
}
?>
