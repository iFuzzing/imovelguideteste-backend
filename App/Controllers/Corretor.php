<?php

namespace App\Controllers;

require 'App/Models/PDODB.php';
use App\Models\CorretorModel;

class CorretorController{
    public static function create(CorretorModel $corretor){
        $sql = "INSERT INTO corretores (name, cpf, creci) VALUES (?, ?, ?)";
        $stmt = \App\Models\PDODB::getPDODB()->prepare($sql);
        $stmt->bindValue(1, $corretor->getName());
        $stmt->bindValue(2, $corretor->getCpf());
        $stmt->bindValue(3, $corretor->getCreci());

        $stmt->execute();
    }

    public static function read(){
        $sql = "SELECT * FROM corretores";
        $stmt = \App\Models\PDODB::getPDODB()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function update(CorretorModel $corretor){
        $sql = "UPDATE corretores SET name = ?, cpf = ?, creci = ? WHERE id = ?";
        $stmt = \App\Models\PDODB::getPDODB()->prepare($sql);
        $stmt->bindValue(1, $corretor->getName());
        $stmt->bindValue(2, $corretor->getCpf());
        $stmt->bindValue(3, $corretor->getCreci());
        $stmt->bindValue(4, $corretor->getId());
        $stmt->execute(); 
    }

    public static function delete($id){
        $sql = "DELETE FROM corretores WHERE id = ?";
        $stmt = \App\Models\PDODB::getPDODB()->prepare($sql);
        $stmt->bindValue(1, $id);
        $stmt->execute();
        $count = $stmt->rowCount();
        if($count == 0){
            return throw new \Exception("Nada para deletar", 0);
        }
    }
}