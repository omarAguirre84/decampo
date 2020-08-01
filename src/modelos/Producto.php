<?php

class Producto {
    public $id;
    public $nombre;
    public $precio_pesos;
    public $precio_dollar;

    const DOLLAR = 130;
    public $error;

    public function __construct() {

    }

    /**
     * @return Producto[]
     */
    public function listar() {
        $rta = [];
        $sql = <<<SQL
            SELECT 
                   id,nombre,precio_pesos
            FROM productos;
SQL;
        try {
            $db = new Db();
            $db = $db->connectDB();
            $resultado = $db->query($sql);

            if ($resultado->rowCount() > 0) {
                $productos = $resultado->fetchAll(PDO::FETCH_ASSOC);
                foreach ($productos as $prod) {
                    $rta[$prod['id']] = $this->load($prod);
                }
            }
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
        }
        return $rta;
    }

    public function alta() {
        $sql = <<<SQL
                INSERT INTO productos (nombre, precio_pesos)
                VALUES (:nombre, :precio_pesos)
SQL;
        try {
            $db = new Db();
            $db = $db->connectDB();
            $resultado = $db->prepare($sql);
            $params = [
                ':nombre' => $this->nombre,
                ':precio_pesos' => $this->precio_pesos
            ];
            $resultado->execute($params);
            $this->id = $db->lastInsertId();
            return $this->id;

        } catch (PDOException $e) {
            $this->error = $e->getMessage();
        }
    }

    public function baja() {
        $sql = <<<SQL
                DELETE FROM productos
                WHERE id= :id
SQL;
        try {
            $db = new Db();
            $db = $db->connectDB();
            $resultado = $db->prepare($sql);
            $params = [':id' => $this->id];
            return $resultado->execute($params);

        } catch (PDOException $e) {
            $this->error = $e->getMessage();
        }
    }

    /**
     * @param int $id
     * @return Producto
     */
    public static function obtener($id = null) {
        $rta = new self();
        if (!is_null($id)) {
            $sql = <<<SQL
            SELECT id,nombre,precio_pesos FROM productos WHERE id = {$id}
SQL;
            try {
                $db = new Db();
                $db = $db->connectDB();
                $resultado = $db->query($sql);
                $resultado = $resultado->fetchAll(PDO::FETCH_ASSOC);
                if (sizeof($resultado) > 0) {
                    return $rta->load($resultado[0]);
                }
            } catch (PDOException $e) {
                $rta->error = $e->getMessage();
            }
            return null;
        }
        return $rta;
    }

    /**
     * @return bool
     */
    public function modificar() {
        $sql = <<<SQL
                UPDATE productos SET
                  nombre = :nombre,
                  precio_pesos = :precio_pesos
                WHERE id = :id
SQL;
        try {
            $db = new Db();
            $db = $db->connectDB();
            $resultado = $db->prepare($sql);
            $params = [
                ':id' => $this->id,
                ':nombre' => $this->nombre,
                ':precio_pesos' => $this->precio_pesos
            ];
            return $resultado->execute($params);

        } catch (PDOException $e) {
            $this->error = $e->getMessage();
        }
    }

    /**
     * @param array $item
     * @return Producto
     */
    private function load($item) {
        $res = new self();
        if (!empty($item)) {
            $res->id = $item['id'];
            $res->nombre = $item['nombre'];
            $res->precio_pesos = $item['precio_pesos'];
            $res->precio_dollar = round($res->precio_pesos / self::DOLLAR, 3);
        }
        return $res;
    }
}