<?php 

class CategoriesTable{

    public static function Add(string $CategoryName, string $IdCategoryParent){
        $query = Database::prepare('INSERT INTO `categories` (`name`, `parents`) VALUES (:name, :parents);');
        
        //привязываем параметры
        $query->bindParam(':name', $CategoryName);
        $query->bindParam(':parents', $IdCategoryParent);
                
        if(!$query->execute()){
            throw new PDOException('При добавлении категории возникла ошибка');
        } 

        return $query;         
    }

    public static function Del(string $IDCategory){
        $query = Database::prepare('WITH RECURSIVE q AS (
                                        SELECT id, parents
                                        FROM categories
                                        WHERE id = :ID
                                        UNION ALL
                                        SELECT c.id, c.parents
                                        FROM categories c
                                        JOIN q ON c.parents = q.id
                                    )
                                    DELETE FROM categories WHERE id IN (
                                        SELECT id FROM q
                                    );');
        
        //привязываем параметры
        $query->bindParam(':ID', $IDCategory); 
                
        if(!$query->execute()){
            throw new PDOException('При удаление категории возникла ошибка');
        } 

        return $query;    
        
    }


    public static function GetHtmlMenu() : string {
        $string = '<ul>';
        $data = self::GetTreeMenu();

        foreach($data as $item){
            $string .= self::_buildHtmlMenu($item);
        }

        $string .= '</ul>';
        return $string;        
    }

    // построение html подменю
    private static function _buildHtmlMenu ($category) {
        $menu = '<li><a href="#" title="'. $category['name'] .'">'. $category['name'].'</a>';            
            if(isset($category['childs'])){
                $menu .= '<ul>';
                foreach ($category['childs'] as $child) {
                    $menu .= self::_buildHtmlMenu($child);
                }
                $menu .= '</ul>';
            }
        $menu .= '</li>';
        
        return $menu;
    }
    
    public static function GetOptionMenu() : string {
        $string = '';
        $str = '';
        $data = self::GetTreeMenu();

        foreach($data as $item){
            $string .= self::_buildOptionMenu($item, $str);
        } 
        return $string;        
    }

    // построение option меню
    private static function _buildOptionMenu ($category, $str) {
        $menu = '';
    
         // Включаем первоначальную категорию в вывод
        if($category['parents'] == 0){
            $menu .= '<option value="'.$category['id'].'">'.$category['name'].'</option>';
        }else{
            $menu .= '<option value="'.$category['id'].'">'.$str.''.$category['name'].'</option>';
        }
        
        // Обходим дочерние элементы
        if (isset($category['childs']) && is_array($category['childs'])) {
            foreach ($category['childs'] as $item) {
                $str .= '&emsp;';
                $menu .= self::_buildOptionMenu($item, $str);
            }
        }
        return $menu;    
    }

    // функция получения дерева меню
    public static function GetTreeMenu() {
        $query = Database::prepare('SELECT * FROM `categories`');
        $query->execute();

        $treeArray = array();
        while($row = $query->fetch(PDO::FETCH_ASSOC)){
            $treeArray[$row['id']] = $row;
        }
 
        $tree = array();

        foreach ($treeArray as $id => &$node) {    
            //Если нет вложений
            if (!$node['parents']){
                $tree[$id] = &$node;
            }else{ 
                //Если есть потомки то перебераем массив
                $treeArray[$node['parents']]['childs'][$id] = &$node;
            }
        }

        return $tree;
    }
    
}


?>


