<?php
class Organitzador
{
    // Camps de la base de dades
    private $idUsuari;
    private $idActivitat;
    private $rol;

    // Constructor
    public function __construct($valors = null)
    {
        if ($valors === null) {
            $this->idUsuari = null;
            $this->idActivitat = null;
            $this->rol = null;
        } else if (is_array($valors)) {
            if (isset($valors["idUsuari"])) $this->idUsuari = $valors["idUsuari"];
            if (isset($valors["idActivitat"])) $this->idActivitat = $valors["idActivitat"];
            if (isset($valors["rol"])) $this->rol = $valors["rol"];
        }
    }

    // Getters i setters
    public function getIdUsuari()
    {
        return $this->idUsuari;
    }

    public function setIdUsuari($idUsuari)
    {
        if (isset($idUsuari)) $this->idUsuari = $idUsuari;
    }

    public function getIdActivitat()
    {
        return $this->idActivitat;
    }

    public function setIdActivitat($idActivitat)
    {
        if (isset($idActivitat)) $this->idActivitat = $idActivitat;
    }

    public function getRol()
    {
        return $this->rol;
    }

    public function setRol($rol)
    {
        if (isset($rol)) $this->rol = $rol;
    }

    // Mètode __toString per representar l'objecte com a cadena
    public function __toString()
    {
        return "Organitzador [idUsuari=$this->idUsuari, idActivitat=$this->idActivitat, rol=$this->rol]";
    }
}
?>
