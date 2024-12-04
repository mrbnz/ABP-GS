<?php
class TipusActivitat
{
    // Camps de la base de dades
    private $id;
    private $nom;
    private $descripcio;

    // Constructor
    public function __construct($valors = null)
    {
        if ($valors === null) {
            $this->id = null;
            $this->nom = null;
            $this->descripcio = null;
        } else if (is_array($valors)) {
            if (isset($valors["id"])) $this->id = $valors["id"];
            if (isset($valors["nom"])) $this->nom = $valors["nom"];
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
        return "TipusActivitat [id=$this->id, nom=$this->nom, descripcio=$this->descripcio]";
    }
}
?>
