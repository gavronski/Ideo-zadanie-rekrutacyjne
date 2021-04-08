<?php 

declare(strict_types=1);

require_once('Tree.php');

class Database 
{
          private PDO $conn;
      
          public array $categories ;
          public array $structure = [];
          public string $order ;

          public function __construct(string $order)
          {
                    // (pierwszy wiersz tabeli 1,0,tekst)
                    $this->conn = new PDO("mysql:host=localhost;dbname=tree","root","");
                    $this->categories = $this->getCategories($order);
                    $this->order = $order;

                    
          }
       
          public function addCategory(string $newCategory ,string $parentId):void
          {
            // jeżeli kategoria do której chcę dodać nową kategorię , nie należy do rodziców to dodaj nową kategorię
            if(!array_key_exists($parentId,array_flip($this->getParents()))){

                $categoryName = $this->conn->quote($newCategory);
                $query = "INSERT INTO categoriestree(id,parent_id,text) VALUES('',$parentId,$categoryName)";
                $this->conn->exec($query);

            }else{

              // jeżeli kategoria do której chcę dodać nową kategorię należy do rodziców to wybierz teksty dzieci dla tego węzła
              $query = "SELECT text FROM categoriestree WHERE parent_id = $parentId";
              $result = $this->conn->query($query);
              $parentText = $result->fetch(PDO::FETCH_ASSOC);
              // sprawdź czy w węźle jest dziecko z takim tekstem
              if(!array_key_exists($newCategory,array_flip($parentText))){

                $categoryName = $this->conn->quote($newCategory);
                $query = "INSERT INTO categoriestree(id,parent_id,text) VALUES('',$parentId,$categoryName)";
                $this->conn->exec($query);
              }else{

                echo 'This text exists in this category!';
              }
            }
          }

        

          private function getCategories(string $order): array
          {
                    
                    $query = "SELECT * FROM categoriestree ORDER BY text $order ";
                    $stm = $this->conn->query($query);
                    $result = $stm->fetchAll(PDO::FETCH_ASSOC);
                    return $result;
          }   
       
          
          public function delete(string $id):void 
          {
            // jeżeli wybrana kategoria nie jest rodzicem to usuń
                   if(empty($this->getParentChildren()[(int) $id])){
               
                              $id1 = (int) $id;
                              $query = "DELETE FROM categoriestree WHERE id = $id1 ";
                              $result = $this->conn->query($query);

                    }else{
                      // jeżeli jest rodzicem to przejdź po dzieciach i wykonaj na nich metodę delete

                              $children = $this->pathToDelete($id);
                              foreach($children as $key => $value){
                                        $this->delete($value);
                              }
                    }
          
          }

          //  zwraca id dzieci wybranej kategorii do usunięcia 
          private function pathToDelete(string $id):array
          {
                    
                    $data = $this->getCategories($this->order);
                    $children = [];
                    
                   
                    foreach($data as $row){
                             if($id == $row['parent_id']){
                                        $children[] = $row['id'];
                             }
                    }
                    if($id != '1'){
                              $idArray = [$id];
                              $mergeArray = array_merge($idArray,$children);
                    }else{
                              $mergeArray = $children;
                    }
                    
                    return array_reverse($mergeArray);
          }
        

          public function editCategory(string $editDataString):void
          {
                    $editDataArray  = explode('|',$editDataString);

                    $id = $this->conn->quote($editDataArray[0]);
                    $text = $this->conn->quote($editDataArray[1]);

                    $query = "UPDATE categoriestree SET text = $text WHERE id = $id";
                    $result = $this->conn->exec($query);



          }

          public function move(string $idMove, string $idMoveTo):void
          {
                    $data = $this->getCategories($this->order);

                    foreach($data as $row){
                              if($idMove == $row['id']){
                                        $rowMove = $row;
                              }
                              if($idMoveTo == $row['id']){
                                        $rowMoveTo = $row;
                              }
                              
                    }
                    if($rowMove['id'] != $rowMoveTo['parent_id']){

                          
                              $query = "UPDATE categoriestree SET parent_id = $idMoveTo  WHERE id = $idMove";
                              $result = $this->conn->exec($query);
          
                    }


          }
         public function getParents():array
         {
                    $query = "SELECT parent_id FROM categoriestree ";
                    $result = $this->conn->query($query);
                    $data = $result->fetchAll(PDO::FETCH_ASSOC);
                    $parents = [];
                    foreach($data as $parent){
                              $parents[] = $parent['parent_id'];
                    }

                    return array_values($parents);
         }

        //  struktura parent_id - id (dzieci)
        private function getParentChildren():array
        {

          $query = "SELECT * FROM categoriestree ";
          $result = $this->conn->query($query);
          $data = $result->fetchAll(PDO::FETCH_ASSOC);
          $parentChildren = [];
          

          foreach($data as $id){
                    $children = [];
                    foreach($data as $row){
                              if($id['id'] == $row['parent_id']){
                                        $children[] = $row['id'];
                              }
                    }
                    $parentChildren[$id['id']] = $children;
          }
          return $parentChildren;

        }
      
     
}