<?php
// app/models/Permission.php

class Permission extends Model {
    protected $table = 'permissions'; // Nombre de la tabla en la base de datos
    protected $fillable = ['module', 'view', 'create', 'edit', 'delete']; // Campos que pueden ser llenados

    // Obtener todos los permisos
    public function getAllPermissions() {
        return $this->all(); // Usamos el método `all` de Model.php
    }

    // Obtener permiso por su ID
    public function getPermissionById($id) {
        return $this->find($id); // Usamos el método `find` de Model.php
    }

    // Crear un permiso
    public function createPermission($data) {
        return $this->insert($data); // Usamos el método `insert` de Model.php
    }

    // Actualizar un permiso
    public function updatePermission($id, $data) {
        return $this->update($id, $data); // Usamos el método `update` de Model.php
    }

    // Eliminar un permiso
    public function deletePermission($id) {
        return $this->delete($id); // Usamos el método `delete` de Model.php
    }
}
