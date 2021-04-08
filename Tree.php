<?php 

declare(strict_types=1);

require_once('Database.php');

class Tree
{
          private string $category;
          private array $structure = [];
          private Database $db;
      
          public function __construct(string $order)
          {
                   
                    $this->db = new Database($order);
                    
          }
         
       
          public  function buildTreeStructure():void
          {         

                    $data = $this->db->categories ;
                    
                    
                    foreach($data as $parent){
                           $children = [];
                           if(!array_key_exists($parent['parent_id'],$this->structure)){
                                  foreach($data as $row){
                                   //       do tablicy klucz-id rodzica przypisz wiersze jego dzieci
                                         if($parent['parent_id'] == $row['parent_id']){
                                                $this->structure[$parent['parent_id']][] = $row ;
                                         }
                                  }
                                  
             
                           }
                          
                    
                    }
                    
                    
          }

          public function displayTree(int $n = 0):string
    
          {
                 
                    if(isset($this->structure[$n])){
                              $html = "<ul>";
                              foreach($this->structure[$n] as $item){
                                   //   jeżeli item['id'] znajduje się w tablicy z rodzicami 
                                     if(array_key_exists($item['id'],array_flip($this->db->getParents())) ){
                                          $html .= "<li class='items'>
                                         
                                          <button class='show'>+</button><button class='hide'>-</button><span class='text'>".htmlentities($item['text'])."</span>
                                          <button class='addCat' data-idAddCategory='{$item['id']}'>add</button>
                                          <button class='delete' data-idDel='{$item['id']}'>delete</button>
                                          <button class='edit' data-idEdit='{$item['id']}'>edit</button>
                                          <button class='move' data-idMove='{$item['id']}'>move</button>
                                          <button class='moveTo' data-idMoveTo='{$item['id']}'>moveTo</button></li>";
                                          $html .= $this->displayTree((int)$item['id']);
                                         
                                          $html .= "</li>";

                                     }else{

                                     $html .= "<li class='items'><span class='text'>".htmlentities($item['text'])."</span>
                                     <button class='addCat' data-idAddCategory='{$item['id']}'>add</button>
                                     <button class='delete' data-idDel='{$item['id']}'>delete</button>
                                     <button class='edit' data-idEdit='{$item['id']}'>edit</button>
                                     <button class='move' data-idMove='{$item['id']}'>move</button>
                                     <button class='moveTo' data-idMoveTo='{$item['id']}'>moveTo</button></li>";
                                     $html .= $this->displayTree((int)$item['id']);
                                    
                                     $html .= "</li>";
                                     }
                
                              }
                              $html .= "</ul>";
                              return $html;
                       }
                       return "";
          }
          
        
}