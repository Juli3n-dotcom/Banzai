$(document).ready(function () {

    /*
 * --> Add Langage
 * 
 * # Ouverture du Modal d'ajout
 * 
 * ## Gestion de l"oublie du nom 
 * Désactivation du BTN si le champs du nom est manquant
 * 
 * ### traitement Ajax de l'ajout
 */

  // # modal d'ajout categorie
  $('#add_lang_modal').on('click', function () {
    $('#addmodal').modal('show');
  });


  // ## Gestion de l"oublie du nom
  $('#add_name_lang').blur(function(){

    if( $(this).val().length === 0 ) {
      $('#addlangBtn').prop("disabled", true).addClass('disabledBtn').removeClass('addBtn');
           
    }else{
      $('#addlangBtn').prop("disabled", false).removeClass('disabledBtn').addClass('addBtn');
    }
  });

  // ### ajout langage ajax
  $("#add_lang").on('submit', function(e){

    e.preventDefault();

    $.ajax({

      type: 'POST',
      url: 'assets/scripts/langages/add_lang_script.php',
      data: new FormData(this),
      dataType: 'json',
      contentType: false,
      cache: false,
      processData:false,
      success: function(data){

        if(data.status == true){    
          
          $('#add_lang').trigger("reset");
          $('#notif').html(data.notif);
          $('#addmodal').modal('hide');
          $('#lang_table').html(data.resultat); 
                                    
        }else{
    
          $('#notif').html(data.notif); 

        } 

      }
    });
  });


    /*
 * --> Delete Langage
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

      $('#deletecat').prop("disabled", false).removeClass('disabledBtn').addClass('deleteBtn');

    } else {

      $('#deletecat').prop("disabled", true).addClass('disabledBtn').removeClass('deleteBtn');

    }
  });

  // ### delete langage ajax
  $('#delete_lang').on('submit', function(e){
    e.preventDefault();
    delete_cat();

    function delete_cat(){

      var id = $('#delete_id').val();
      var img = $('#delete_img').val();
      var confirme = $('#confirmedelete').val();
      var parameters = "id="+id + '&img=' + img + '&confirmedelete=' + confirme;

        
      $.post('assets/scripts/langages/delete_langage_script.php', parameters, function(data){
        if(data.status == true){  

          $('#delete_lang').trigger("reset");
          $('#notif').html(data.notif);
          $('#deletemodal').modal('hide');
          $('#lang_table').html(data.resultat); 
                
        }else{

          $('#notif').html(data.notif); 

        } 
                
      }, 'json');
    }

  });

/*
 * --> Update langage
 * 
 * # Ouverture du Modal d'edition
 * 
 * ## view logo if change
 * 
 * ### traitement Ajax de la modification
 */


// # Ouverture du Modal de vue
$(document).on('click','.editbtn', function(){  
  var lang_id = $(this).attr("id");  

  $.ajax({  
       url:"assets/scripts/langages/update_modal.php",  
       method:"post",  
       data:{lang_id:lang_id},  
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

// ### update langage ajax
$(document).on('submit', '#update_lang', function(e){
    e.preventDefault();

    $.ajax({

      type: 'POST',
      url: 'assets/scripts/langages/update_lang_script.php',
      data: new FormData(this),
      dataType: 'json',
      contentType: false,
      cache: false,
      processData:false,
      success: function(data){

        if(data.status == true){    

          $('#add_lang').trigger("reset");
          $('#notif').html(data.notif);
          $('#editmodal').modal('hide');
          $('#lang_table').html(data.resultat); 
                                    
        }else{
        
          $('#notif').html(data.notif); 

        } 

      }
    });


});

/*
 * --> View langage
 * 
 * # Ouverture du Modal de vue
 *
 */

// # Ouverture du Modal de vue
$(document).on('click','.viewbtn', function(){  
    var lang_id = $(this).attr("id");  

    $.ajax({  
         url:"assets/scripts/langages/view_langage_script.php",  
         method:"post",  
         data:{lang_id:lang_id},  
         success:function(data){  
              $('#lang_detail').html(data);  
              $('#viewmodal').modal("show");  
         }  
    });  
});  

    
});

