<?php
class ActivitatManager extends Activitat {
    public function selectAll() {
		$resposta = null;
			try {
				$consulta = (BdD::$connection)->prepare(
					'SELECT * FROM `activitat`'
					);
				$qFiles = $consulta->execute();
				if ($qFiles > 0) {
					$consulta->setFetchMode(PDO::FETCH_ASSOC); 
					$resposta = $consulta->fetchAll();
				}
			} catch(PDOException $e) {
				echo "***Error***: " . $e->getMessage();
			}
		return $resposta;
	}
    public function getActivitatById($id)
    {
        try {
            $consulta = (BdD::$connection)->prepare('
                SELECT 
					a.id, 
					a.nom, 
					a.descripcio_breu, 
					a.descripcio, 
					a.data, 
					a.places_totals, 
					a.places_ocupades, 
					a.preu, 
					e.nom AS espai_nom, 
					e.ubicacio AS espai_ubicacio, 
					e.capacitat AS espai_capacitat, 
					e.descripcio AS espai_descripcio
				FROM 
					activitat a
				JOIN 
					espai e ON a.id_espai = e.id
				WHERE 
					a.id = :id
            ');
            $consulta->bindValue(':id', $id, PDO::PARAM_INT);
            $consulta->execute();
            $resultat = $consulta->fetch(PDO::FETCH_ASSOC);
            if (!$resultat) {
                echo "***Debug***: No s'ha trobat l'activitat amb id: " . $id;
            }
            return $resultat;
        } catch (PDOException $e) {
            echo "***Error***: " . $e->getMessage();
            return null;
        }
    }
}
?>