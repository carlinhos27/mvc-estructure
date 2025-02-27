<?php
class Model
{
    protected $db;
    protected $table = '';
    protected $fillable = [];
    protected $softDelete = true;

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

    public function all()
    {
        $sql = "SELECT * FROM {$this->table}";
        if ($this->softDelete) {
            $sql .= " WHERE deleted_at IS NULL";
        }
        return $this->fetchAll($sql);
    }

    public function find($id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id";
        if ($this->softDelete) {
            $sql .= " AND deleted_at IS NULL";
        }
        return $this->fetch($sql, ['id' => $id]);
    }

    public function insert($data)
    {
        $columns = implode(", ", array_keys($data));
        $values = ":" . implode(", :", array_keys($data));

        $sql = "INSERT INTO " . $this->table . " ($columns) VALUES ($values)";
        return $this->execute($sql, $data) ? $this->lastInsertId() : false;
    }

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

    public function delete($id)
    {
        if ($this->softDelete) {
            $sql = "UPDATE {$this->table} SET deleted_at = NOW() WHERE id = :id AND deleted_at IS NULL";
        } else {
            $sql = "DELETE FROM {$this->table} WHERE id = :id";
        }
        return $this->execute($sql, ['id' => $id]);
    }

    public function restore($id)
    {
        if (!$this->softDelete) {
            throw new Exception("Restore is not available for models without soft delete.");
        }
        $sql = "UPDATE {$this->table} SET deleted_at = NULL WHERE id = :id";
        return $this->execute($sql, ['id' => $id]);
    }

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

        // Verificar si softDelete está habilitado y si la columna 'deleted_at' existe
        if ($this->softDelete && isset($this->tableColumns['deleted_at'])) {
            $sql = "SELECT * FROM {$this->table} $where AND deleted_at IS NULL";
        } else {
            $sql = "SELECT * FROM {$this->table} $where";
        }

        // Llamar al método fetchAll para ejecutar la consulta
        return $this->fetchAll($sql, $params);
    }


    // RELACIONES
    public function hasOne($relatedModel, $foreignKey, $localKey = 'id')
    {
        $related = new $relatedModel();
        return $related->where([$foreignKey => $this->$localKey])[0] ?? null;
    }

    public function hasMany($relatedModel, $foreignKey, $localKey = 'id')
    {
        $related = new $relatedModel();
        return $related->where([$foreignKey => $this->$localKey]);
    }

    public function belongsTo($relatedModel, $foreignKey, $ownerKey = 'id')
    {
        $related = new $relatedModel();
        return $related->where([$ownerKey => $this->$foreignKey])[0] ?? null;
    }
}
