<?php

class Empresa extends Model {
    protected $table = 'empresas';
    protected $fillable = ['nombre', 'email', 'telefono', 'direccion', 'plan'];

    public function createEmpresa($data){
        return $this->insert($data);
    }


}