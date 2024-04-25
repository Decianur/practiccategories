<?php 
    require_once ($_SERVER['DOCUMENT_ROOT'] . '/practiccategories/.core/index.php'); 
    $errorsAdd = CategoriesAction::AddCategories();
    $errorsDelete = CategoriesAction::DeleteCategories();
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link href="/practiccategories/bootstrap/bootstrap.css" rel="stylesheet">  
        <link rel="stylesheet" type="text/css" href="/practiccategories/style.css">
        <title>Многокатегорийное меню</title>     
    </head>
    <body>    
        <div class="container flex-column align-items-center">
            <div class="row mt-4">
                <div class="col-4 mb-4">
                    <h2 class="text-center mb-4 mt-4">Текущее дерево категорий</h2>
                    <?php echo CategoriesTable::GetHtmlMenu(); ?>  
                </div>
                <div class="col-4 mb-4">
                    <div class="container">
                        <h2 class="text-center mb-4 mt-4">Добавить категорию</h2>
                        <form method="POST" class="mt-3">
                            <div class="form-group">
                                <label for="CategoryName">Название категории:</label>
                                <input type="text" class="form-control" id="CategoryName" name="CategoryName" required>
                            </div>
                            <div class="form-group">
                                <label for="IdCategoryParent">Выберете место:</label>
                                <select class="form-control" id="IdCategoryParent" name="IdCategoryParent" required>
                                    <option value="0">Корневая категория</option>
                                    <?php echo CategoriesTable::GetOptionMenu(); ?>
                                </select>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary mt-4 text-center" name="action" value="AddCategories">Добавить</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-4 mb-4">
                <div class="container">
                        <h2 class="text-center mb-4 mt-4">Удалить категорию</h2>
                        <form method="POST" class="mt-3">
                            <div class="form-group">
                                <label>Выберите категорию, для удаления: </label>                             
                            </div>
                            <div class="form-group">
                                <label for="IDcategory">Список категорий:</label>
                                <select class="form-control" id="IDcategory" name="IDcategory" required> 
                                    <option value="0">Выберите категорию</option>
                                    <?php echo CategoriesTable::GetOptionMenu(); ?>
                                </select>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-danger mt-4 text-center" name="action" value="DeleteCategories">Удалить</button>
                            </div>
                        </form>
                    </div>
                </div>             
            </div>
        </div>
        <?php 
            // Проверяем наличие ошибок и выводим сообщение об ошибке
            if (isset($errorsAdd['success']) && !$errorsAdd['success'] || isset($errorsDel['success']) && !$errorsDel['success']) {
                ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $errorsAdd['message']; ?>
                    <?php echo $errorsDel['message']; ?>
                </div>
                <?php
            }  
        ?>
    </body>
</html> 