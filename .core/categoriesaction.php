<?php 

class CategoriesAction{

    // метод для добавления новой категории
    public static function AddCategories() : array {
        if ('POST' != $_SERVER['REQUEST_METHOD']){
            return [];
        }
        
        $action = isset($_POST['action']) ? $_POST['action'] : '';
        if('AddCategories' != $action){
            return [];
        }
  
        $errors = CategoriesLogic::AddCategories($_POST['CategoryName'] ?? '', $_POST['IdCategoryParent'] ?? '');
        if (!count($errors)){   
            header('Location: ' . $_SERVER['PHP_SELF'] . '?success=y');
            die();       
        }

        return $errors;
    }

    // метод удаления категории
    public static function DeleteCategories() {
        if ('POST' != $_SERVER['REQUEST_METHOD']){
            return [];
        }
        
        $action = isset($_POST['action']) ? $_POST['action'] : '';
        if('DeleteCategories' != $action){
            return [];
        }

        $errors = CategoriesLogic::DeleteCategories($_POST['IDcategory'] ?? '');
        if (!count($errors)){   
            header('Location: ' . $_SERVER['PHP_SELF'] . '?success=y');
            die();       
        }

        return $errors;
 
    }


}


?>