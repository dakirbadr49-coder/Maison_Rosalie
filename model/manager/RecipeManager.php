<?php
//model/manager/RecipeManager.php
declare(strict_types=1);
namespace model\manager;
use model\abstract\AbstractManager;
use model\mapping\RecipeMapping;

class RecipeManager extends AbstractManager{
    
    public function getRecipesForMenu():array{
        $sql ="SELECT id, title,slug
        FROM recipes
        ORDER BY id ASC";
        try{
            $query=$this->connect->query($sql);
        }catch(\Exception $e){
            die($e->getMessage());
        }
        $recipes = [];

        foreach ($query->fetchAll() as $row) {

            $recipes[] = new RecipeMapping($row);

        }

        return $recipes;

    }
}
