<?php
// app/models/RolePermission.php

class RolePermission extends Model
{
    protected $table = 'role_permissions'; // Nombre de la tabla en la base de datos
    protected $fillable = ['role_id', 'permission_id', 'empresa_id']; // Campos que pueden ser llenados

    // Asignar permisos a un rol
    public function assignPermissionsToRole($roleId, $permissions)
    {
        // Insertamos todos los permisos asociados al rol
        foreach ($permissions as $permissionId) {
            $data = [
                'role_id' => $roleId,
                'permission_id' => $permissionId
            ];
            $this->insert($data); // Usamos el método `insert` de Model.php
        }
    }

    // Obtener permisos de un rol específico
    public function getPermissionsByRoleId($roleId)
    {
        return $this->where(['role_id' => $roleId]); // Usamos el método `where` de Model.php
    }

    // Eliminar todos los permisos de un rol
    public function removePermissionsFromRole($roleId)
    {
        return $this->execute("DELETE FROM {$this->table} WHERE role_id = :role_id", ['role_id' => $roleId]);
    }

    /**
     * Eliminar un permiso de un rol
     *
     * @param int $roleId
     * @param int $permissionId
     * @return bool
     */
    public function removePermissionFromRole($roleId, $permissionId)
    {
        // Utilizamos el método `where` para buscar la relación entre el rol y el permiso
        $permissions = $this->where([
            'role_id' => $roleId,
            'permission_id' => $permissionId
        ]);

        // Si encontramos la relación, la eliminamos
        if ($permissions) {
            return $this->delete($permissions[0]['id']);  // Usamos el id para eliminar la relación
        }

        return false;  // Si no se encuentra la relación, devolvemos false
    }
}
