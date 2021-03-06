$(document).ready(function () {

/*
 * --> Add Category
 * 
 * # Ouverture du Modal d'ajout
 * 
 * ## Gestion de l"oublie du nom 
 * Désactivation du BTN si le champs du nom est manquant
 * 
 * ### traitement Ajax de l'ajout
 */

// # modal d'ajout categorie
$('#add_cat_modal').on('click', function () {

  $('#addmodal').modal('show');

});


// ## Gestion de l"oublie du nom
$('#add_name_cat').blur(function(){

  if( $(this).val().length === 0 ) {

    $('#addCatBtn').prop("disabled", true).addClass('disabledBtn').removeClass('addBtn');
           
  }else{

    $('#addCatBtn').prop("disabled", false).removeClass('disabledBtn').addClass('addBtn');

  }

});

// ### ajout category ajax
  $("#add_cat").on('submit', function(e){

    e.preventDefault();

    $.ajax({

      type: 'POST',
      url: 'assets/scripts/categories/add_categorie_script.php',
      data: new FormData(this),
      dataType: 'json',
      contentType: false,
      cache: false,
      processData:false,
      success: function(data){

        if(data.status == true){    
         
          $('#add_cat').trigger("reset");
          $('#notif').html(data.notif);
          $('#addmodal').modal('hide');
          $('#categories_table').html(data.resultat); 
                                    
        }else{
            
          $('#notif').html(data.notif); 

        } 

      }
    });
  });


    

    /*
 * --> Delete Category
 * 
 * # Ouverture du Modal de suppresion
 * 
 * ## Gestion de la confirmation de suppression
 * Désactivation du BTN si l'utilisateur n'a pas confirmé la suppression
 * 
 * ### traitement Ajax de la suppression
 */


// # modal delete langage
$(document).on('click','.deletebtn', function () {

  $('#deletemodal').modal('show');
  
  $tr = $(this).closest('tr');
  
  let data = $tr.children('td').map(function () {

    return $(this).text()

  }).get();
  
  $('#delete_id').val(data[0]);
  
});


// ## confirmation de la validation de suppression
$('#confirmedelete').on('click', function () {
  if ($(this).is(':checked')) {

    $('#deletecat').prop("disabled", false).removeClass('disabledBtn').addClass('deleteBtn');

  } else {

    $('#deletecat').prop("disabled", true).addClass('disabledBtn').removeClass('deleteBtn');

  }
});


// ### delete cat ajax
$('#delete_cat').on('submit', function(e){

  e.preventDefault();
  delete_cat();

  function delete_cat(){

    var id = $('#delete_id').val();
    var confirme = $('#confirmedelete').val();
    var parameters = "id="+id + '&confirmedelete=' + confirme;

        
    $.post('assets/scripts/categories/delete_categorie_script.php', parameters, function(data){

            if(data.status == true){ 

                $('#delete_cat').trigger("reset"); 
                $('#notif').html(data.notif);
                $('#deletemodal').modal('hide');
                $('#categories_table').html(data.resultat); 
                
            }else{

                $('#notif').html(data.notif); 

            } 
                
    }, 'json');

}

});


/*
 * --> Update Category
 * 
 * # Ouverture du Modal d'edition
 * 
 * ## changement de logo - > affichage de la div
 * 
 * ### traitement Ajax de la modification
 */

 // # Ouverture du Modal de vue
$(document).on('click','.editbtn', function(){  
  var cat_id = $(this).attr("id");  

  $.ajax({  
       url:"assets/scripts/categories/update_modal.php",  
       method:"post",  
       data:{cat_id:cat_id},  
       success:function(data){  
            $('#update_modal').html(data);  
            $('#editmodal').modal("show");  
       }  
  });  
});  

// ## changement de logo
$(document).on('click', '#changeIcone', function(e){
  
  $('#div_new_logo').toggleClass('dnone');
  $('.hiddenFileInput').toggleClass('plus').toggleClass('minus')
  
})


// ### update cat ajax
$(document).on('submit', '#update_cat', function(e){
  e.preventDefault();

  $.ajax({

    type: 'POST',
    url: 'assets/scripts/categories/update_categorie_script.php',
    data: new FormData(this),
    dataType: 'json',
    contentType: false,
    cache: false,
    processData:false,
    success: function(data){

      if(data.status == true){    
        
        $('#add_cat').trigger("reset");
        $('#notif').html(data.notif);
        $('#editmodal').modal('hide');
        $('#categories_table').html(data.resultat); 
                                  
      }else{
       
        $('#notif').html(data.notif); 

      } 

    }
    
  });


});

/*
 * --> View Category
 * 
 * # Ouverture du Modal de vue
 *
 */

// # Ouverture du Modal de vue
$(document).on('click','.viewbtn', function(){  
    var cat_id = $(this).attr("id");  

    $.ajax({  
         url:"assets/scripts/categories/view_categorie_script.php",  
         method:"post",  
         data:{cat_id:cat_id},  
         success:function(data){  
              $('#cat_detail').html(data);  
              $('#viewmodal').modal("show");  
         }  
    });  
});  

    
});

