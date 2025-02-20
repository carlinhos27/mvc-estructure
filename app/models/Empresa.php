<?php
class Empresa extends Model
{
    protected $table = 'empresas'; // Nombre de la tabla
    protected $fillable = ['nombre', 'email', 'telefono', 'direccion', 'plan']; // Campos permitidos
    protected $softDelete = false;

    // Opcional: Método específico para obtener todos los clientes
    public function createEmpresa($data)
    {
        return $this->insert($data);
    }
}
