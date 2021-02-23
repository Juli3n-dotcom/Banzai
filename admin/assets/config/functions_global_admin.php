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


// function notif(PDO $pdo, string $class, string $message, int $user)
// {

//   $req = $pdo->prepare(
//     'INSERT INTO notification (
//       class,
//       message,
//       user,
//       date_enregistrement
//     )
//     VALUE(
//      :class,
//      :message,
//      :user,
//      :date)'
//   );
//   $req->bindParam(':class',$class);
//   $req->bindParam(':message',$message);
//   $req->bindParam(':user', $user);
//   $req->bindValue(':date',(new DateTime())->format('Y-m-d H:i:s'));
//   $req->execute();

// }

// Notification de success | error | warning | info
function notif(string $class, string $message){
  $output = '<div id="toats" class="notif alert-'. $class.'">';
    $output .= '<div class="toats_headers">';
      $output .= '<a class="toats_die">X</a>';
      $output .= '<h5><i class="fas fa-exclamation-circle"></i> Notification :</h5>';
  $output .= '</div>';

    $output .= '<div class="toats_core">
                <p>'.$message.'</p>
                </div>';
  $output .= '</div>';

  $output .= '<script>
                setTimeout(function(){ document.querySelector(".notif").remove();}, 4000 );

                document.querySelector(".toats_die").addEventListener("click", ()=>{
                document.querySelector(".notif").remove();
              });
            </script>';
  return $output;
}

// récupération des logos des categories | langages 
function getImg(PDO $pdo, INT $id)
{
  $data = $pdo->query("SELECT img FROM pics WHERE id_pics = '$id'");
  $photo = $data->fetch(PDO::FETCH_ASSOC);
  return $photo['img'];
}