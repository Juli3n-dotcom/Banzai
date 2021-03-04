$(document).ready(function (){

/*
 * --> Add Post
 * 
 * # Ouverture du Modal d'ajout
 * 
 * ## Gestion de l"oublie du nom 
 * Désactivation du BTN si le champs du nom est manquant
 * 
 * ### traitement Ajax de l'ajout
 */

// # modal d'ajout categorie
$('#add_post_modal').on('click', function () {
    $('#addmodal').modal('show');
});

// ## Gestion de l"oublie du nom
$('#add_titre_post').blur(function(){

    if( $(this).val().length === 0 ) {
  
      $('#addPostBtn').prop("disabled", true).addClass('disabledBtn').removeClass('addBtn');
             
    }else{
  
      $('#addPostBtn').prop("disabled", false).removeClass('disabledBtn').addClass('addBtn');
  
    }
  
  });

// ### ajout category ajax
$("#add_post").on('submit', function(e){

    e.preventDefault();

    $.ajax({

      type: 'POST',
      url: 'assets/scripts/posts/add_post_script.php',
      data: new FormData(this),
      dataType: 'json',
      contentType: false,
      cache: false,
      processData:false,
      success: function(data){

        if(data.status == true){    
          
          $('#add_post').trigger("reset");
          $('#notif').html(data.notif);
          $('#addmodal').modal('hide');
          $('#posts_table').html(data.resultat); 
          $('#cards').html(data.cards); 
                                    
        }else{
          
          $('#notif').html(data.notif); 

        } 

      }
    });
});

/*
 * --> View Post
 * 
 * # Ouverture du Modal de vue
 *
 */

// # Ouverture du Modal de vue
$(document).on('click','.viewbtn', function(){  
  var post_id = $(this).attr("id");  

  $.ajax({  
       url:"assets/scripts/posts/view_post_script.php",  
       method:"post",  
       data:{post_id:post_id},  
       success:function(data){  
            $('#post_detail').html(data);  
            $('#viewmodal').modal("show");  
       }  
  });  
});  


 /*
 * --> Delete post
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
  $('#delete_img').val(data[1]);
  
});


// ## confirmation de la validation de suppression
$('#confirmedelete').on('click', function () {
  if ($(this).is(':checked')) {

    $('#deletepost').prop("disabled", false).removeClass('disabledBtn').addClass('deleteBtn');

  } else {

    $('#deletepost').prop("disabled", true).addClass('disabledBtn').removeClass('deleteBtn');

  }
});


// ### delete cat ajax
$('#delete_post').on('submit', function(e){

  e.preventDefault();
  delete_cat();

  function delete_cat(){

    var id = $('#delete_id').val();
    var img = $('#delete_img').val();
    var confirme = $('#confirmedelete').val();
    var parameters = "id="+id + '&img=' + img + '&confirmedelete=' + confirme;

        
    $.post('assets/scripts/posts/delete_post_script.php', parameters, function(data){

            if(data.status == true){ 

                $('#delete_post').trigger("reset"); 
                $('#notif').html(data.notif);
                $('#deletemodal').modal('hide');
                $('#posts_table').html(data.resultat); 
                $('#cards').html(data.cards); 
                
            }else{

                $('#notif').html(data.notif); 

            } 
                
    }, 'json');

}

});


/*
 * --> Update post
 * 
 * # Ouverture du Modal d'edition
 * 
 * ## traitement Ajax de la modification
 */

 // # Ouverture du Modal de vue
 $(document).on('click','.editbtn', function(){  
  var post_id = $(this).attr("id");  

  $.ajax({  
       url:"assets/scripts/posts/update_modal.php",  
       method:"post",  
       data:{post_id:post_id},  
       success:function(data){  
            $('#update_modal').html(data);  
            $('#editmodal').modal("show");  
       }  
  });  
});  

var reader = new FileReader();
var img;
// ## view logo if change
function readURL(input) {
  if (input.files && input.files[0]) {
      

      reader.onload = function (e) {
          $('#img-logo').attr('src', e.target.result);
          img = e.target.value;
      }

      reader.readAsDataURL(input.files[0]);
  }
}

$(document).on('change',"#new_logo", function (e) {
  readURL(this);
  img = e.target.value;
});

// ### update post ajax
$(document).on('submit', '#update_post', function(e){
  e.preventDefault();

  $.ajax({

    type: 'POST',
    url: 'assets/scripts/posts/update_post_script.php',
    data: new FormData(this),
    dataType: 'json',
    contentType: false,
    cache: false,
    processData:false,
    success: function(data){

      if(data.status == true){    
        
        $('#update_post').trigger("reset");
        $('#notif').html(data.notif);
        $('#editmodal').modal('hide');
        $('#posts_table').html(data.resultat); 
        $('#cards').html(data.cards); 
                                  
      }else{
        
        $('#notif').html(data.notif); 

      } 

    }
    
  });


});


/*
 * --> Update publication
 * 
 * # traitement ajax de la publication a partir du tableau
 * 
 */

 // # traitement de la publication
 $(document).on('click', '.confirmedelete', function(e){
  e.preventDefault();

  $tr = $(this).closest('tr');
  
  let data = $tr.children('td').map(function () {

    return $(this).text()

  }).get();

  var publie = $(this).val();
  
  delete_cat();

  function delete_cat(){

    var id = data[0];
    var parameters = "id="+id + "&publie="+publie;

        
    $.post('assets/scripts/posts/est_publie_update_script.php', parameters, function(data){

            if(data.status == true){ 

                $('#notif').html(data.notif);
                $('#posts_table').html(data.resultat); 
                $('#cards').html(data.cards); 
                
            }else{

                $('#notif').html(data.notif); 

            } 
                
    }, 'json');

}

});

/*
 * --> View all post
 * 
 * # traitement ajax
 * 
 */

$(document).on('click','#all', function(e){  
  e.preventDefault();

  $.ajax({  
       url:"assets/scripts/posts/view_all.php",  
       method:"post",
       dataType: 'json', 
       success:function(data){  

        $('#posts_table').html(data.resultat);  

       }  
  });  
});  

/*
 * --> View all publiés
 * 
 * # traitement ajax
 * 
 */

$(document).on('click','#all_publie', function(e){  
  e.preventDefault();

  $.ajax({  
       url:"assets/scripts/posts/view_publie.php",  
       method:"post",
       dataType: 'json', 
       success:function(data){  

        $('#posts_table').html(data.resultat);  

       }  
  });  
});  

/*
 * --> View all non publiés
 * 
 * # traitement ajax
 * 
 */

$(document).on('click','#non_publie', function(e){  
  e.preventDefault();

  $.ajax({  
       url:"assets/scripts/posts/view_non_publie.php",  
       method:"post",
       dataType: 'json', 
       success:function(data){  

        $('#posts_table').html(data.resultat);  

       }  
  });  
});  


});