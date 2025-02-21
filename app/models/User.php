<?php
class User extends Model
{
    protected $table = 'users'; // Nombre de la tabla en la base de datos
    protected $fillable = ['name', 'email', 'password', 'role_id', 'empresa_id']; // Definir los campos llenables
    
    // Si usas timestamps, agrega estas propiedades (en caso contrario, puedes ignorarlas):
    public $timestamps = false; // Desactivar si no usas created_at y updated_at

    // Obtener todos los usuarios
    public function getAllUsers()
    {
        return $this->all(); // Usamos el método `all` de Model.php para obtener todos los usuarios
    }

    // Obtener usuario por su ID
    public function getUserById($id)
    {
        return $this->find($id); // Buscar un usuario por su `id`
    }

    // Obtener el rol del usuario
    public function getRole()
    {
        // Asumimos que `role_id` está ya cargado como parte del modelo
        if (isset($this->role_id)) {
            $roleModel = new Role(); // Instanciamos el modelo `Role`
            return $roleModel->getRoleById($this->role_id); // Devuelve el rol basado en `role_id`
        } else {
            throw new Exception("Role ID not set for this user.");
        }
    }

    // Crear un usuario
    public function createUser($data)
    {
        return $this->insert($data); // Usamos el método `insert` de Model.php para insertar un nuevo registro
    }

    // Actualizar un usuario
    public function updateUser($id, $data)
    {
        return $this->update($id, $data); // Usamos el método `update` de Model.php para actualizar un usuario
    }

    // Eliminar un usuario
    public function deleteUser($id)
    {
        return $this->delete($id); // Usamos el método `delete` de Model.php para eliminar un usuario
    }
}
