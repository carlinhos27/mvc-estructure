<?php
class User extends Model
{
    protected $table = 'users';
    protected $fillable = ['name', 'email', 'password', 'role_id',  'empresa_id'];

    public function create($data)
    {
        if (isset($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT); // Hashea la contraseña
        }
        return $this->insert($data);
    }

}