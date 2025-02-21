<?php
// app/models/Role.php

class Role extends Model {
    protected $table = 'roles'; // Nombre de la tabla en la base de datos
    protected $fillable = ['name', 'description', 'empresa_id']; // Campos que pueden ser llenados

    // Método para crear un rol (usando el método `insert` del modelo base)
    public function createRole($data) {
        // Validamos los datos antes de insertarlos
        return $this->insert($data); // Utilizamos el método `insert()` para crear el rol
    }

    // Método para actualizar un rol (usando el método `update` del modelo base)
    public function updateRole($id, $data) {
        return $this->update($id, $data); // Método de Model.php que maneja la actualización
    }

    // Método para eliminar un rol (usando el método `delete` del modelo base)
    public function deleteRole($id) {
        return $this->delete($id); // Método de Model.php que maneja la eliminación
    }

    
    public function getRoleById($role_id)
    {
        return $this->find($role_id); // Usamos el método `find` de Model.php para obtener el rol por ID
    }

    // Obtener todos los roles
    public function getAllRoles() {
        return $this->all(); // Usamos el método `all` de Model.php
    }

    // Método para buscar roles por condiciones específicas (usando el método `where` del modelo base)
    public function getRolesByCondition($conditions) {
        return $this->where($conditions); // Método de Model.php para buscar con condiciones
    }
}
