<?php
// récupération des membres de la team
function getMember(PDO $pdo):array
{
  $req=$pdo->query(
     'SELECT *
       FROM team'
  );
  $memberTeam = $req->fetchAll(PDO::FETCH_ASSOC);
  return $memberTeam;
}


// Notification de success | error | warning | info
// function notif(string $class, string $message){
//   $output = '<div id="toats" class="notif alert-'. $class.'">';
//     $output .= '<div class="toats_headers">';
//       $output .= '<a class="toats_die">X</a>';
//       $output .= '<h5><i class="fas fa-exclamation-circle"></i> Notification :</h5>';
//   $output .= '</div>';

//     $output .= '<div class="toats_core">
//                 <p>'.$message.'</p>
//                 </div>';
//   $output .= '</div>';

//   $output .= '<script>
//                 setTimeout(function(){ document.querySelector(".notif").remove();}, 4000 );

//                 document.querySelector(".toats_die").addEventListener("click", ()=>{
//                 document.querySelector(".notif").remove();
//               });
//             </script>';
//   return $output;
// }

function notif(string $class, string $message){
$output = '<div class="notification">';
  $output .= '<div class="card '.$class.'">';
    $output .= '<div class="content">';
      $output .= '<div class="img"></div>';
      $output .= '<div class="details">';
        $output .= ' <span class="name">'.$class.'</span>';
        $output .= '<p>'.$message.'</p>';
      $output .= '</div>';
    $output .= '</div>';
    $output .= '<span class="close-btn">';
      $output .= '<i class="fas fa-times"></i>';
    $output .= ' </span>';
  $output .= '</div>';
$output .= '</div>';


  $output .= '<script>
  $(document).ready(function (){
      setTimeout(function(){
      $(".notification").addClass("hide");
      $(".notification").removeClass("show");
      },3000);
    $(".close-btn").click(function(){
      $(".notification").addClass("hide");
      $(".notification").removeClass("show"); 
    });
    setTimeout(function(){
      $(".notification").remove();
      },5000);
  })</script>';
      
  return $output;
}


// récupération des logos des categories | langages 
function getImg(PDO $pdo, INT $id)
{
  $data = $pdo->query("SELECT img FROM pics WHERE id_pics = '$id'");
  $photo = $data->fetch(PDO::FETCH_ASSOC);
  return $photo['img'];
}