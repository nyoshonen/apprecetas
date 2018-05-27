<?php
namespace App\DataAccess;
use PDO;

class _DataAccess
{
    private $pdo;

    private $maintable;

    public function __construct(PDO $pdo, $table)
    {
        $this->pdo       = $pdo;
        $this->maintable = $table;
    }
	
	public function clonarPlato($id_plato) {
		$sql = "SELECT * FROM platos WHERE id=".intval($id_plato);
		$stmt_plato_principal = $this->pdo->prepare($sql);
		$stmt_plato_principal->execute();
        if ($stmt_plato_principal) {
            $row = $stmt_plato_principal->fetch(\PDO::FETCH_ASSOC);
			// CLONAR PLATO
			$plato_clonado_nombre  = $row['nombre'].' (copia)';
			$sql = "INSERT INTO platos SET nombre=:nombre, id_plato_original=:id_plato_original";
			$stmt_clonado = $this->pdo->prepare($sql);
			$stmt_clonado->bindValue(':nombre',$plato_clonado_nombre);
			$stmt_clonado->bindValue(':id_plato_original',$id_plato);
			$stmt_clonado->execute();
			$plato_clonado_id = $this->pdo->lastInsertId();
			if ($plato_clonado_id > 0) {
				$sql_ingredientes = "SELECT * FROM platos_ingredientes WHERE (id_plato=:id_plato)";
				$stmt_ingredientes = $this->pdo->prepare($sql_ingredientes);
				$stmt_ingredientes->bindValue(':id_plato',$id_plato);
				$stmt_ingredientes->execute();
				if ($stmt_ingredientes) {
					while ($row = $stmt_ingredientes->fetch(\PDO::FETCH_ASSOC)) {
						$sql_ingrediente = "INSERT INTO platos_ingredientes SET id_plato=:id_plato, id_ingrediente=:id_ingrediente";
						$stmt_ingrediente = $this->pdo->prepare($sql_ingrediente);
						$stmt_ingrediente->bindValue(':id_plato',$plato_clonado_id);
						$stmt_ingrediente->bindValue(':id_ingrediente',$row['id_ingrediente']);
						$stmt_ingrediente->execute();
					}
				}
				$sql = "SELECT * FROM platos WHERE id=".intval($plato_clonado_id);
				$stmt_plato_clonado = $this->pdo->prepare($sql);
				$stmt_plato_clonado->execute();
				if ($stmt_plato_clonado) {
					$result = array();
					$row = $stmt_plato_clonado->fetch(\PDO::FETCH_ASSOC);
					$result[] = $row;
				}
			}
        }
		else {
			$result = null;
		}
		return $result;
	}
	
    public function getAlergenos($id_plato)
    {
        $sql = "SELECT alergenos.* 
				FROM platos 
				INNER JOIN platos_ingredientes ON (platos_ingredientes.id_plato = platos.id) 
				INNER JOIN ingredientes_alergenos ON (ingredientes_alergenos.id_ingrediente = platos_ingredientes.id_ingrediente) 
				INNER JOIN alergenos ON (alergenos.id = ingredientes_alergenos.id_alergeno) 
				WHERE (platos.id = ".intval($id_plato).")
				GROUP BY alergenos.id 
				ORDER BY alergenos.nombre ASC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        if ($stmt) {
            $result = array();
            while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
                $result[] = $row;
            }
        } 
		else {
        	$result = null;
        }
        return $result;
    }
	
    public function getPlatos($id_alergeno)
    {
        $sql = "SELECT platos.* 
				FROM platos 
				INNER JOIN platos_ingredientes ON (platos.id = platos_ingredientes.id_plato) 
				INNER JOIN ingredientes_alergenos ON (ingredientes_alergenos.id_ingrediente = platos_ingredientes.id_ingrediente)
				WHERE (ingredientes_alergenos.id_alergeno = ".intval($id_alergeno).")
				GROUP BY platos.id 
				ORDER BY platos.nombre ASC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        if ($stmt) {
            $result = array();
            while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
                $result[] = $row;
            }
        } 
		else {
        	$result = null;
        }
        return $result;
    }

    public function getAll($path, $arrparams)
    {
        $table = $this->maintable != '' ? $this->maintable : $path;
        $orderby = "";
        if (in_array($table,array('alergenos','ingredientes','platos'))) {
			$orderby = " ORDER BY nombre ASC ";
		}
        $stmt = $this->pdo->prepare('SELECT * FROM '.$table.$orderby);
        $stmt->execute();
        if ($stmt) {
            $result = array();
            while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
                $result[] = $row;
            }
        } 
		else {
        	$result = null;
        }
        return $result;
    }

    public function get($path, $args)
    {
        $table = $this->maintable != '' ? $this->maintable : $path;
		$where = "";
		foreach ($args as $campo => $valor) {
			$where .= " AND (".$campo."=".intval($valor).") ";
		}
        $sql = "SELECT * FROM ". $table . " WHERE ( (1=1) ".$where." )";		
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':' . implode(',', array_flip($args)), implode(',', $args));
        $stmt->execute();
        if ($stmt) {
			$result = array();
            while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
                $result[] = $row;
            }
        } 
		else {
        	$result = null;
        }
        return $result;
    }

    public function add($path, $request_data)
    {
        $table = $this->maintable != '' ? $this->maintable : $path;
        if ($request_data == null) {
            return false;
        }
        $sets = 'SET ';
        foreach($request_data as $key => $value){
            $sets = $sets . $key . ' = :' . $key . ', ';
        }
        $sets = rtrim($sets, ", ");
        $sql = "INSERT INTO ". $table .' '.$sets;
        $stmt = $this->pdo->prepare($sql);
        foreach ($request_data as $key => $value){
            $stmt->bindValue(':'.$key,$request_data[$key]);
        }
		$stmt->execute();
		$result = array();
		$result[] = $this->pdo->lastInsertId();
        return $result;
    }

    public function update($path, $args, $request_data)
    {
        $table = $this->maintable != '' ? $this->maintable : $path;
        if ($request_data == null || !isset($args[implode(',', array_flip($args))])) {
            return false;
        }
        $sets = 'SET ';
        foreach($request_data as $key => $value){
            $sets = $sets . $key . ' = :' . $key . ', ';
        }
        $sets = rtrim($sets, ", ");
        $sql = "UPDATE ". $table . ' ' . $sets . ' WHERE ' . implode(',', array_flip($args)) . ' = :' . implode(',', array_flip($args));
        $stmt = $this->pdo->prepare($sql);
        foreach($request_data as $key => $value){
            $stmt->bindValue(':' . $key,$request_data[$key]);
        }
        $stmt->bindValue(':' . implode(',', array_flip($args)), implode(',', $args));
        $stmt->execute();
      	return ($stmt->rowCount() == 1) ? true : false;
    }

    public function delete($path, $args)
    {
        $table = $this->maintable != '' ? $this->maintable : $path;
        $sql = "DELETE FROM ". $table . ' WHERE ' . implode(',', array_flip($args)) . ' = :' . implode(',', array_flip($args));
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':' . implode(',', array_flip($args)), implode(',', $args));
        $stmt->execute();
      	return ($stmt->rowCount() > 0) ? true : false;
    }
}
