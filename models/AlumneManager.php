<?php
class AlumneManager extends Alumne {
	/**
	 * Returns an alumne from the database by a URL
	 * @param string $url The URL
	 * @return array|false The article or false if not found
	 */
	public function selectAlumneBD($url=null)
	{
		$resposta = null;
		if ($url != null) {
			try {
				$consulta = (BdD::$connection)->prepare('
					SELECT `id`, `dni`, `nom`, `poblacio`, `telefon`, `actiu`
					FROM `alumne`
					WHERE `id` = :id');
				$consulta->bindParam('id',$url);
				$qFiles = $consulta->execute();
				if ($qFiles > 0) {
					$consulta->setFetchMode(PDO::FETCH_ASSOC); 
					$result = $consulta->fetchAll();
					foreach($result as $fila) {
						$resposta = $fila;
					}
					$this->id = $resposta["id"];
					$this->nom = $resposta["nom"];
					$this->dni = $resposta["dni"];
					$this->poblacio = $resposta["poblacio"];
					$this->telefon = $resposta["telefon"];
					$this->actiu = $resposta["actiu"];
					$resposta = $this;
				}
			} catch(PDOException $e) {
				echo "Error: " . $e->getMessage();
			}
		}
		return $resposta;
	}

	/**
	 * Returns a list of all alumnes in the database
	 * @return array All the alumnes in the database
	 */
	public function selectAlumnesBD()
	{
		$resposta = null;
		try {
			$consulta = (BdD::$connection)->prepare('
				SELECT `id`, `dni`, `nom`, `poblacio`, `telefon`, `actiu`
				FROM `alumne`
				ORDER BY `nom` ASC
			');
			$qFiles = $consulta->execute();
			if ($qFiles > 0) {
				$consulta->setFetchMode(PDO::FETCH_ASSOC); 
				$result = $consulta->fetchAll();
				foreach($result as $fila) {
					$resposta[] = new Alumne($fila);
				}
			}
		} catch(PDOException $e) {
			echo "Error: " . $e->getMessage();
		}
		return $resposta;
	}
	public function updateBD()
	{
		$qFiles = 0;
		try {
			$consulta = (BdD::$connection)->prepare("
				UPDATE alumne 
				SET `dni` = :dni, `nom` = :nom, `poblacio` = :poblacio, `telefon` = :telefon, `actiu` = :actiu
				WHERE  `id` = :id
			");
			$consulta->bindParam('id',$this->id);
			$consulta->bindParam('dni',$this->dni);
			$consulta->bindParam('nom',$this->nom);
			$consulta->bindParam('poblacio',$this->poblacio);
			$consulta->bindParam('telefon',$this->telefon);
			$consulta->bindParam('actiu',$this->actiu);

			$qFiles = $consulta->execute();
		} catch(PDOException $e) {
			echo "Error: " . $e->getMessage();
		}
		return $qFiles;
	}
	public function insertBD()
	{
		$qFiles = 0;
		try {
			$consulta = (BdD::$connection)->prepare("
				INSERT INTO alumne(`dni`,`nom`,`poblacio`,`telefon`,`actiu`)
				VALUES (:dni,:nom,:poblacio,:telefon,:actiu)
			");
			$consulta->bindParam('dni',$this->dni);
			$consulta->bindParam('nom',$this->nom);
			$consulta->bindParam('poblacio',$this->poblacio);
			$consulta->bindParam('telefon',$this->telefon);
			$consulta->bindParam('actiu',$this->actiu);

			$qFiles = $consulta->execute();
			$this->id = (BdD::$connection)->lastInsertId();
		} catch(PDOException $e) {
			echo "Error: " . $e->getMessage();
		}
		
		return $qFiles;
	}
	public function deleteBD()
	{
		$qFiles = 0;
		try {
			$consulta = (BdD::$connection)->prepare("
				DELETE
				FROM alumne 
				WHERE  `id` = :id
			");
			$consulta->bindParam('id',$this->id);

			$qFiles = $consulta->execute();
			$this->id = null;
		} catch(PDOException $e) {
			echo "Error: " . $e->getMessage();
		}
		
		return $qFiles;
	}
}
?>