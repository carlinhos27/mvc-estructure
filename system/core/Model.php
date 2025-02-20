<?php
class Model
{
    protected $db;
    protected $table = ''; // Nombre de la tabla
    protected $fillable = []; // Campos permitidos
    protected $softDelete = true; // 🚀 Soft Delete opcional

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function query($sql, $params = [])
    {
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute($params);
            return $stmt;
        } catch (PDOException $e) {
            throw new Exception("Database query error: " . $e->getMessage());
        }
    }

    public function fetch($sql, $params = [])
    {
        return $this->query($sql, $params)->fetch(PDO::FETCH_ASSOC);
    }

    public function fetchAll($sql, $params = [])
    {
        return $this->query($sql, $params)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function execute($sql, $params = [])
    {
        try {
            $stmt = $this->db->prepare($sql);
            return $stmt->execute($params);
        } catch (PDOException $e) {
            throw new Exception("Database execute error: " . $e->getMessage());
        }
    }

    public function lastInsertId()
    {
        return $this->db->lastInsertId();
    }

    // 🔹 Obtener todos los registros (con o sin Soft Delete)
    public function all()
    {
        $sql = "SELECT * FROM {$this->table}";
        if ($this->softDelete) {
            $sql .= " WHERE deleted_at IS NULL";
        }
        return $this->fetchAll($sql);
    }

    // 🔹 Obtener un registro por ID (con o sin Soft Delete)
    public function find($id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id";
        if ($this->softDelete) {
            $sql .= " AND deleted_at IS NULL";
        }
        return $this->fetch($sql, ['id' => $id]);
    }

    // 🔹 Insertar un registro
    public function insert($data)
    {
        var_dump($data);  // Depuración
        $fields = array_intersect_key($data, array_flip($this->fillable));
        if (empty($fields)) {
            throw new Exception("No valid fields provided for insertion.");
        }

        $columns = implode(', ', array_keys($fields));
        $placeholders = implode(', ', array_map(fn($col) => ":$col", array_keys($fields)));

        $sql = "INSERT INTO {$this->table} ($columns) VALUES ($placeholders)";
        $this->execute($sql, $fields);
        return $this->lastInsertId();
    }


    // 🔹 Actualizar un registro
    public function update($id, $data)
    {
        $fields = array_intersect_key($data, array_flip($this->fillable));
        if (empty($fields)) {
            throw new Exception("No valid fields provided for update.");
        }

        $setClause = implode(', ', array_map(fn($col) => "$col = :$col", array_keys($fields)));
        $fields['id'] = $id;

        $sql = "UPDATE {$this->table} SET $setClause WHERE id = :id";
        if ($this->softDelete) {
            $sql .= " AND deleted_at IS NULL";
        }
        return $this->execute($sql, $fields);
    }

    // 🔹 Eliminar un registro (Soft Delete si está habilitado, Hard Delete si no)
    public function delete($id)
    {
        if ($this->softDelete) {
            $sql = "UPDATE {$this->table} SET deleted_at = NOW() WHERE id = :id AND deleted_at IS NULL";
        } else {
            $sql = "DELETE FROM {$this->table} WHERE id = :id";
        }
        return $this->execute($sql, ['id' => $id]);
    }

    // 🔹 Restaurar un registro eliminado (Solo si Soft Delete está activado)
    public function restore($id)
    {
        if (!$this->softDelete) {
            throw new Exception("Restore is not available for models without soft delete.");
        }
        $sql = "UPDATE {$this->table} SET deleted_at = NULL WHERE id = :id";
        return $this->execute($sql, ['id' => $id]);
    }

    // 🔹 Búsqueda por condiciones (con o sin Soft Delete)
    public function where($conditions = [])
    {
        $where = "";
        $params = [];

        if (!empty($conditions)) {
            $where = "WHERE ";
            foreach ($conditions as $key => $value) {
                $where .= "$key = :$key AND ";
                $params[$key] = $value;
            }
            $where = rtrim($where, "AND ");
        }

        if ($this->softDelete) {
            $sql = "SELECT * FROM {$this->table} $where AND deleted_at IS NULL";
        } else {
            $sql = "SELECT * FROM {$this->table} $where";
        }

        return $this->fetchAll($sql, $params);
    }
}
