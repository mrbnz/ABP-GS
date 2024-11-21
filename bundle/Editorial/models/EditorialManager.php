<?php
class EditorialManager extends Editorial {
	/**
	 * Returns an editorial from the database by a URL
	 * @param string $url The URL
	 * @return array|false The article or false if not found
	 */
	public function selectEditorialBD($url=null)
	{
		$resposta = null;
		if ($url != null) {
			try {
				$consulta = (BdD::$connection)->prepare('
					SELECT `idEditorial`, `nomEditorial`, `provincia`, `municipi`, `web`, `email`, `telefon`
					FROM `editorial`
					WHERE `idEditorial` = :idEditorial');
				$consulta->bindParam('idEditorial',$url);
				$qFiles = $consulta->execute();
				if ($qFiles > 0) {
					$consulta->setFetchMode(PDO::FETCH_ASSOC); 
					$result = $consulta->fetchAll();
					foreach($result as $fila) {
						$resposta = $fila;
					}
					$this->idEditorial = $resposta["idEditorial"];
					$this->provincia = $resposta["provincia"];
					$this->nomEditorial = $resposta["nomEditorial"];
					$this->municipi = $resposta["municipi"];
					$this->web = $resposta["web"];
					$this->email = $resposta["email"];
					$this->telefon = $resposta["telefon"];
					$resposta = $this;
				}
			} catch(PDOException $e) {
				echo "Error: " . $e->getMessage();
			}
		}
		return $resposta;
	}

	/**
	 * Returns a list of all editorials in the database
	 * @return array All the editorials in the database
	 */
	public function selectEditorialsBD()
	{
		$resposta = null;
		try {
			$consulta = (BdD::$connection)->prepare('
				SELECT `idEditorial`, `nomEditorial`, `provincia`, `municipi`, `web`, `email`, `telefon`
				FROM `editorial`
				ORDER BY `nomEditorial` ASC
			');
			$qFiles = $consulta->execute();
			if ($qFiles > 0) {
				$consulta->setFetchMode(PDO::FETCH_ASSOC); 
				$result = $consulta->fetchAll();
				foreach($result as $fila) {
					$resposta[] = new Editorial($fila);
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
				UPDATE editorial 
				SET `nomEditorial` = :nomEditorial, `provincia` = :provincia, `municipi` = :municipi, `web` = :web, `email` = :email, `telefon` = :telefon
				WHERE  `idEditorial` = :idEditorial
			");
			$consulta->bindParam('idEditorial',$this->idEditorial);
			$consulta->bindParam('nomEditorial',$this->nomEditorial);
			$consulta->bindParam('provincia',$this->provincia);
			$consulta->bindParam('municipi',$this->municipi);
			$consulta->bindParam('web',$this->web);
			$consulta->bindParam('email',$this->email);
			$consulta->bindParam('telefon',$this->telefon);

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
				INSERT INTO editorial(`nomEditorial`,`provincia`,`municipi`,`web`,`email`,`telefon`)
				VALUES (:nomEditorial,:provincia,:municipi,:web,:email,:telefon)
			");
			$consulta->bindParam('nomEditorial',$this->nomEditorial);
			$consulta->bindParam('provincia',$this->provincia);
			$consulta->bindParam('municipi',$this->municipi);
			$consulta->bindParam('web',$this->web);
			$consulta->bindParam('email',$this->email);
			$consulta->bindParam('telefon',$this->telefon);

			$qFiles = $consulta->execute();
			$this->idEditorial = (BdD::$connection)->lastInsertId();
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
				FROM editorial 
				WHERE  `idEditorial` = :idEditorial
			");
			$consulta->bindParam('idEditorial',$this->idEditorial);

			$qFiles = $consulta->execute();
			$this->idEditorial = null;
		} catch(PDOException $e) {
			echo "Error: " . $e->getMessage();
		}
		
		return $qFiles;
	}
}
?>