<?php 

class CategoriesLogic{

    // метод для добавления новой категории
    public static function AddCategories(?string $CategoryName, ?string $IdCategoryParent) : array {
        $errorMessage = ['success' => false, 'message' => ' '];

        // Проверка наименования категории
        if(!isset($CategoryName) || empty($CategoryName)){
            $errorMessage['message'] .= "<br>" . 'Ошибка ввода наименования категории';
        }

        // Проверка выбора категории
        if(!is_numeric($IdCategoryParent) || !isset($IdCategoryParent) ){
            $errorMessage['message'] .= "<br>" . 'Ошибка выбора категории';
        } 
        
        if($errorMessage['message'] !== ' '){
            return $errorMessage;
        }

        // Защита от SQL-инъекций
        $CategoryName = htmlspecialchars($CategoryName);
        $IdCategoryParent = htmlspecialchars($IdCategoryParent);

        // Вызов метода Add из CategoriesTable        
        $result = CategoriesTable::Add($CategoryName, $IdCategoryParent);

        $query = $result->fetchAll();

        if(!count($query)){
            return [];
        }
 
        return $query;

    }

    //метод удаления категории
    public static function DeleteCategories(?string $IDcategory) : array {
        $errorMessage = ['success' => false, 'message' => ' '];

        // Проверка наименования категории
        if(!is_numeric($IDcategory)){
            $errorMessage['message'] .= "<br>" . 'Ошибка получения id';
        }

        if($errorMessage['message'] !== ' '){
            return $errorMessage;
        }

        // Защита от SQL-инъекций
        $IDcategory = htmlspecialchars($IDcategory);

        // Вызов метода Del из CategoriesTable        
        $result = CategoriesTable::Del($IDcategory);

        $query = $result->fetchAll();

        if(!count($query)){
            return [];
        }
 
        return $query;
    }

}

?>