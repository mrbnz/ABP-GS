<?php
class MultimediaManager
{
    public function addMultimedia($ruta, $tipus, $descripcio, $estat)
    {
        try {
            $consulta = (BdD::$connection)->prepare('
                INSERT INTO multimedia (ruta, tipus, descripcio, estat)
                VALUES (:ruta, :tipus, :descripcio, :estat)
            ');
            $consulta->bindValue(':ruta', $ruta, PDO::PARAM_STR);
            $consulta->bindValue(':tipus', $tipus, PDO::PARAM_STR);
            $consulta->bindValue(':descripcio', $descripcio, PDO::PARAM_STR);
            $consulta->bindValue(':estat', $estat, PDO::PARAM_STR);
            $consulta->execute();
            return BdD::$connection->lastInsertId();
        } catch (PDOException $e) {
            echo "***Error***: " . $e->getMessage();
            return false;
        }
    }
}
?>
