$('#idParent').hide();
$('#newCategoryName').hide();
//  dodaj
        $('.addCat').click(function(){
          event.preventDefault();
//       input dla nowej kategorii
      $inputAddCategory = $('<input>');
      $inputAddCategory.attr('id','inputAdd');
      $(this).before($inputAddCategory);
      $parentId = $(this).attr('data-idAddCategory');
//       ukryj przycisk add
      $(this).hide();

// dodaj addCategory przycisk
      $confirmAddBttn = $('<button>');
      $confirmAddBttn.attr('class','addInput');
      $confirmAddBttn.text('AddCategory');

// close odrzuca proces dodawania
      $close = $('<button>');
      $close.text('close');


      $inputAddCategory.after($confirmAddBttn);
      $confirmAddBttn.after($close);
      $inputAddCategory.text('Add new category');
      $close.nextAll().hide();
       
      

      $confirmAddBttn.click(function(){
                 event.preventDefault();

                 if($('#inputAdd').val() == ''){
                        alert('You can not add empty field!');
                        location.reload();

                 }else{

                        $('#newCategoryName').attr('value',$('#inputAdd').val());
                     //    przypisanie id rodzica 
                        $('#idParent').attr('value',$parentId);
                        $('#newCategoryName').show();

                        $confirm = $('<input>');
                        $confirm.attr('type','submit');
                        $confirm.attr('name','confirm');
                        $confirm.attr('value','confirm');
                        $confirm.attr('class','confirm');

                        $('#idParent').after($confirm);

                        $confirm.after($close);
                        $(this).hide();
                        $inputAddCategory.hide();
                 }
                
         
          
      });

// usuń
   });
   $('#deleteElement').hide();
   $('#deleteElementName').hide();


   $('.delete').each(function(){
          if($(this).attr('data-idDel') == '1'){
                 $(this).hide();
          }
   });
          
       $('.delete').click(function(){
          event.preventDefault();
   
         
          $deleteElement = $('#deleteElement');
       //     przypisanie id węzła lub liścia
          $delId = $(this).attr('data-idDel');
          $deleteElement.attr('value',$delId);
        
       
       //  potwierdzenie usunięcia
          $confirmDel = $('<button>');
          $confirmDel.text('delete');
          $confirmDel.attr('name','confirmDel');
          $confirmDel.attr('value','confirmDel');
          
          $category = $(this).parent().children('span').text();
          $('#deleteElementName').val($category);
          $('#deleteElementName').show();
          $('#deleteElementName').before('Delete');
          
       //   odrzuć proces usuwania
          $close = $('<button>');
          $close.text('close');
          $deleteElement.after($close);
          $deleteElement.after($confirmDel);
          $deleteElement.after('Are you sure ?');


       });

       // edytuj
       $('.edit').click(function(){
                         event.preventDefault();
                          $thisId = $(this).attr('data-idEdit');
                          
                          $input = $('<input>');
                          $category = $(this).parent().children('span').text();
                         
                          $input.val($category);
                          $save = $('<button>');
                          $save.text('save');
                          $save.attr('name','save');

                          
                          //   odrzuć proces usuwania
                          $close = $('<button>');
                          $close.text('close');

                          

                          $(this).after($input);
                          
                          $input.after($close);
                          $input.after($save);

                          $close.next().hide();
                          $input.prev().prev().hide();

                          $(this).hide();
                          $(this).prev().prev().hide();
                          $(this).parent().children('span').hide();
                          
                          $save.click(function(){
                               
                            //  przypisz id elementu który ma byc edytowany i jego nową wartość 

                               $idCategory = $thisId + '|' + $input.val();
                               $save.attr('value',$idCategory);
                          });


                 
                        
                        });

              // przenieś
                 $('.moveTo').hide();
                 $('.move').hide();
                 $('#moveTo').hide();
                 $('#move').hide();


                 $('.move').each(function(){
                        if($(this).attr('data-idMove') != '1'){
                               $(this).show();
                        }
                 });
                 $('.move').click(function(){
                        event.preventDefault();

                        $closeMoveProcess = $('<button>');
                        $closeMoveProcess.text('CLOSE MOVE PROCESS');
                        $('#form').before($closeMoveProcess);
                        $closeMoveProcess.click(function(){
                            location.reload();
                        });

                        $idElementMove = $(this).attr('data-idMove');
                        $moveText = $(this).parent().children('span').text();
                       
                        $('#move').attr('value',$moveText);
                        $idElementMoveBox = $('<input>');
                        $idElementMoveBox.attr('name','moveId');
                        $idElementMoveBox.attr('value',$idElementMove);

                        $('#move').after($idElementMoveBox);
                        $idElementMoveBox.hide();


                        $('#move').before('Move');
                        $('#move').show();
              // nie może przenieść do samego siebie i dzieci
                        $('.moveTo').each(function() {
                         if($(this).attr('data-idMoveTo') != $idElementMove){
                                $(this).show();
                         }
                                                    });

                     //   ukryj potomków elementu do przeniesienia
                            $(this).parent().next('ul').hide();
                         
                     
                     //   ukryj rozwiń/zwiń przyciki
                       if($(this).parent().children('.hide')){
                        $(this).parent().children('.hide').hide();
                       }
                       if($(this).parent().children('.show')){
                        $(this).parent().children('.show').hide();

                       }
                       
                        $('.move').hide();

                        $('.moveTo').click(function(){
                               event.preventDefault();
                            //    przypisuje id elementu do którego ma zostać przeniesiony węzeł/liść
                               $idElementMoveTo = $(this).attr('data-idMoveTo');
                               $moveToText = $(this).parent().children('span').text();
                               $('#moveTo').attr('value',$moveToText);
 

                              
                               $idElementMoveToBox = $('<input>');
                               $idElementMoveToBox.attr('name','moveIdTo');
                               $idElementMoveToBox.attr('value',$idElementMoveTo);
                               $('#moveTo').after($idElementMoveToBox);
                               $idElementMoveToBox.hide();


                               $acceptMoveBttn = $('<input>');
                               $acceptMoveBttn.attr('class','confrim');

                               $acceptMoveBttn.attr('type','submit');
                               $acceptMoveBttn.attr('name','acceptMove');
                               $acceptMoveBttn.attr('value','accept');

                               
                               $idElementMoveToBox.after($acceptMoveBttn);

                               $closeBttn = $('<button>');
                               $closeBttn.text('close');

                               $acceptMoveBttn.after($closeBttn);

                        
                               $idElementMoveToBox.after('Are you sure to move an element?');
                            
                               $('#moveTo').before('to');
                               $('#moveTo').show();


                               $('#moveTo').attr('value',$moveToText);
                               $('.moveTo').hide();

                        });
                        


                 });
              //  rozwmiń węzły
                 $('.show').hide();
                 $('.show').click(function(){
                        event.preventDefault();
                        $(this).parent().next('ul').show();
   
                        $(this).next().show();
                        $(this).hide();
                       
                       
                        


                 });
              //    zwiń węzły
                 $('.hide').click(function(){
                        event.preventDefault();
                        $(this).parent().next('ul').hide();
   
                        $(this).prev().show();
                        $(this).hide();
                       
                       
                        


                 });