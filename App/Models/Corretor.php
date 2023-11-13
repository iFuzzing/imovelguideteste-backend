<?php

namespace App\Models;

class CorretorModel{
    private $id, $name, $cpf, $creci;

    public function getId(){
        return $this->id;
    }

    public function getName(){
        return $this->name;
    }

    public function getCpf(){
        return $this->cpf;
    }

    public function getCreci(){
        return $this->creci;
    }


    public function setId($id){
        $this->id = $id;
    }

    public function setName($name){
        if(strlen($name) < 2 || strlen($name) > 64){
          return throw new \Exception("O nome deve ter entre 2 e 62 caracteres", 1);
        }

        // TODO: função para melhor validão desse nome
        $this->name = $name;
    }

    public function setCpf($cpf){
        $clearCpf = str_replace("-", "", str_replace(".","", $cpf));
        if(strlen($clearCpf) != 11){
            return throw new \Exception("CPF inválido", 2);
        }

        // TODO: função para melhor validão desse CPF
        $this->cpf = $clearCpf;
    }

    public function setCreci($creci){
        if(strlen($creci) < 2 || strlen($creci) > 8){
            return throw new \Exception("Creci inválido");
        }

        // TODO: função para melhor validão desse CRECI
        $this->creci = $creci;
    }


}

?>