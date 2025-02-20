<?php
class User extends Model
{
    protected $table = 'users'; // Nombre de la tabla en la base de datos
    protected $fillable = ['empresa_id', 'name', 'email', 'password', 'role', 'status']; // Campos que se pueden llenar

    // Método para crear un nuevo usuario
    public function createUser($data)
    {
        return $this->insert($data);
    }

    // Método para verificar si el email ya está registrado
    public function findByEmail($email)
    {
        return $this->where(['email' => $email]);
    }
}
