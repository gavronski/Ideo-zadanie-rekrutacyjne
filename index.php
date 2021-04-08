<?php 

session_start();

require_once('Database.php');
require_once('Tree.php');


if($_SESSION['sortOrder'] != null){
       $database = new Database($_SESSION['sortOrder']);
       $tree = new Tree($_SESSION['sortOrder']);
       $tree->buildTreeStructure();
       $view = $tree->displayTree();

}else{
       $_SESSION['sortOrder'] = '';
       $database = new Database($_SESSION['sortOrder']);
       $tree = new Tree($_SESSION['sortOrder']);
       $tree->buildTreeStructure();
       $view = $tree->displayTree();

}



if(!empty($_POST['confirm']) && !empty($_POST['newCategoryName'])
                    && !empty($_POST['idParent'])){
                     
                     $database->addCategory($_POST['newCategoryName'],$_POST['idParent']);
                     header("Refresh:0");
                     
                     
                    
                    
}

if(isset($_POST['confirmDel'])){
       $database->delete($_POST['deleteElement']);
       header("Refresh:0");
      
}
if(isset($_POST['sort'])){
            
            
              $_SESSION['sortOrder'] = $_POST['order'];
              $database->order = $_SESSION['sortOrder'];
               header("Refresh:0");


}

if(isset($_POST['save'])){
       $database->editCategory($_POST['save']);
       header("Refresh:0");
       }
       
       

if(isset($_POST['acceptMove'])){
       $database->move($_POST['moveId'],$_POST['moveIdTo']);
       header("Refresh:0");
       

}


?>

<!DOCTYPE html>
<html lang="en">
<head>
          <meta charset="UTF-8">
          <meta http-equiv="X-UA-Compatible" content="IE=edge">
          <meta name="viewport" content="width=device-width, initial-scale=1.0">
          <title>Document</title>
          <link rel="stylesheet" href="style.css">
          <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
          

         
          
          
         
</head>
<body>
      
          <form method='post' id='form' >
          

          <input type="text" name='newCategoryName' id='newCategoryName' readonly="readonly">
          <input type="text" name='idParent'  id='idParent'>
       


          <input type="text" name='move' id='move' readonly="readonly"> 
          <input type="text" name='moveTo'  id='moveTo' readonly="readonly"><br><br>


          <input type="text" name='deleteElementName' id="deleteElementName" readonly="readonly">
          <input type="text" name='deleteElement' id="deleteElement">


          Show in order: <select name="order" id="order">
                 <option value="asc" >A-Z</option>
                 <option value="desc">Z-A</option>
                 <option value="">my order</option>

                 <input type="submit" name='sort' value='sort' id='sort'><br><br>

          </select>
 
          <?php echo $view;?>

          
          </form>

          <script src="script.js"></script>
          
</body>

</html>