<?php
class Multimedia
{
    // Camps de la base de dades
    private $id;
    private $ruta;
    private $tipus;
    private $descripcio;
    private $estat;

    // Constructor
    public function __construct($valors = null)
    {
        if ($valors === null) {
            $this->id = null;
            $this->ruta = null;
            $this->tipus = null;
            $this->descripcio = null;
            $this->estat = null;
        } else if (is_array($valors)) {
            if (isset($valors["id"])) $this->id = $valors["id"];
            if (isset($valors["ruta"])) $this->ruta = $valors["ruta"];
            if (isset($valors["tipus"])) $this->tipus = $valors["tipus"];
            if (isset($valors["descripcio"])) $this->descripcio = $valors["descripcio"];
            if (isset($valors["estat"])) $this->estat = $valors["estat"];
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

    public function getRuta()
    {
        return $this->ruta;
    }

    public function setRuta($ruta)
    {
        if (isset($ruta)) $this->ruta = $ruta;
    }

    public function getTipus()
    {
        return $this->tipus;
    }

    public function setTipus($tipus)
    {
        if (isset($tipus)) $this->tipus = $tipus;
    }

    public function getDescripcio()
    {
        return $this->descripcio;
    }

    public function setDescripcio($descripcio)
    {
        if (isset($descripcio)) $this->descripcio = $descripcio;
    }

    public function getEstat()
    {
        return $this->estat;
    }

    public function setEstat($estat)
    {
        if (isset($estat)) $this->estat = $estat;
    }

    // Mètode __toString per representar l'objecte com a cadena
    public function __toString()
    {
        return "Multimedia [id=$this->id, ruta=$this->ruta, tipus=$this->tipus, descripcio=$this->descripcio, estat=$this->estat]";
    }
}
?>
