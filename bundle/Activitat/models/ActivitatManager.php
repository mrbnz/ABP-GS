<?php
class ActivitatManager extends Activitat {
    public function selectAll() {
		$resposta = null;
			try {
				$consulta = (BdD::$connection)->prepare(
					'SELECT 
						a.*,
						e.nom AS espai_nom,
						e.ubicacio AS espai_ubicacio,
						e.capacitat AS espai_capacitat,
						e.descripcio AS espai_descripcio,
						m.ruta AS imatge
					FROM 
						activitat a
					LEFT JOIN 
						espai e ON a.id_espai = e.id
					LEFT JOIN 
						activitat_multimedia am ON a.id = am.id_activitat
					LEFT JOIN 
						multimedia m ON am.id_multimedia = m.id'
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
                a.preu, 
                a.id_espai, 
                a.id_tipus_activitat, 
                e.nom AS espai_nom, 
                e.ubicacio AS espai_ubicacio, 
                e.capacitat AS espai_capacitat, 
                e.descripcio AS espai_descripcio,
                m.ruta AS imatge
            FROM 
                activitat a
            JOIN 
                espai e ON a.id_espai = e.id
            LEFT JOIN 
                activitat_multimedia am ON a.id = am.id_activitat
            LEFT JOIN 
                multimedia m ON am.id_multimedia = m.id
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
    public function addActivitat($nom, $descripcioBreu, $descripcio, $data, $placesTotals, $preu, $idEspai, $idOrganitzador, $idTipusActivitat)
    {
        try {
            $consulta = (BdD::$connection)->prepare('
                INSERT INTO activitat (
                    nom, 
                    descripcio_breu, 
                    descripcio, 
                    data, 
                    places_totals, 
                    preu, 
                    id_espai,
                    id_tipus_activitat
                ) VALUES (
                    :nom,
                    :descripcio_breu,
                    :descripcio,
                    :data,
                    :places_totals,
                    :preu,
                    :id_espai,
                    :id_tipus_activitat
                )
            ');
            
            $consulta->bindValue(':nom', $nom, PDO::PARAM_STR);
            $consulta->bindValue(':descripcio_breu', $descripcioBreu, PDO::PARAM_STR);
            $consulta->bindValue(':descripcio', $descripcio, PDO::PARAM_STR);
            $consulta->bindValue(':data', $data, PDO::PARAM_STR);
            $consulta->bindValue(':places_totals', $placesTotals, PDO::PARAM_INT);
            $consulta->bindValue(':preu', $preu, PDO::PARAM_STR);
            $consulta->bindValue(':id_espai', $idEspai, PDO::PARAM_INT);
            $consulta->bindValue(':id_tipus_activitat', $idTipusActivitat, PDO::PARAM_INT);
            
            if ($consulta->execute()) {
                return (BdD::$connection)->lastInsertId();
            }
        } catch(PDOException $e) {
            echo "***Error***: " . $e->getMessage();
        }
        return false;
    }
    public function addActivitatMultimedia($idActivitat, $idMultimedia)
    {
        try {
            $consulta = (BdD::$connection)->prepare('
                INSERT INTO activitat_multimedia (id_activitat, id_multimedia)
                VALUES (:id_activitat, :id_multimedia)
            ');
            $consulta->bindValue(':id_activitat', $idActivitat, PDO::PARAM_INT);
            $consulta->bindValue(':id_multimedia', $idMultimedia, PDO::PARAM_INT);
            return $consulta->execute();
        } catch (PDOException $e) {
            echo "***Error***: " . $e->getMessage();
            return false;
        }
    }
    public function updateActivitat($id, $nom, $descripcio, $descripcioBreu, $data, $placesTotals, $preu)
    {
        try {
            $consulta = (BdD::$connection)->prepare('
                UPDATE activitat 
                SET nom = :nom, descripcio = :descripcio, descripcio_breu = :descripcio_breu, data = :data, places_totals = :places_totals, preu = :preu
                WHERE id = :id
            ');
            $consulta->bindValue(':id', $id, PDO::PARAM_INT);
            $consulta->bindValue(':nom', $nom, PDO::PARAM_STR);
            $consulta->bindValue(':descripcio', $descripcio, PDO::PARAM_STR);
            $consulta->bindValue(':descripcio_breu', $descripcioBreu, PDO::PARAM_STR);
            $consulta->bindValue(':data', $data, PDO::PARAM_STR);
            $consulta->bindValue(':places_totals', $placesTotals, PDO::PARAM_INT);
            $consulta->bindValue(':preu', $preu, PDO::PARAM_STR);
            return $consulta->execute();
        } catch (PDOException $e) {
            echo "***Error***: " . $e->getMessage();
            return false;
        }
    }
    public function getActivitatsAmbRelacions()
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
                a.id_tipus_activitat,
                a.id_espai,
                t.nom AS tipus_nom,
                e.nom AS espai_nom, 
                e.ubicacio AS espai_ubicacio, 
                e.capacitat AS espai_capacitat, 
                e.descripcio AS espai_descripcio,
                m.ruta AS imatge
            FROM 
                activitat a
            JOIN 
                espai e ON a.id_espai = e.id
            JOIN 
                tipus_activitat t ON a.id_tipus_activitat = t.id
            LEFT JOIN 
                activitat_multimedia am ON a.id = am.id_activitat
            LEFT JOIN 
                multimedia m ON am.id_multimedia = m.id 
        ');
        
        
        $consulta->execute();
        $resultat = $consulta->fetchAll(PDO::FETCH_ASSOC);  
        
        if (!$resultat) {
            echo "***Debug***: No s'han trobat activitats.";
        }
        
        return $resultat;
    } catch (PDOException $e) {
        echo "***Error***: " . $e->getMessage();
        return null;
    }
}

}
?>