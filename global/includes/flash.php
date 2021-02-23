<?php foreach (recupererFlash() as $messages): ?>
<div id="notif">
<div class="notification">
  <div class="card <?= $messages['type'];?>">
    <div class="content">
      <div class="img"></div>
      <div class="details">
         <span class="name"><?= $messages['type'];?></span>
        <p><?= $messages['message'];?></p>
      </div>
    </div>
    <span class="close-btn">
      <i class="fas fa-times"></i>
     </span>
  </div>
</div>
</div>

<script>
   
      setTimeout(function(){
      document.querySelector(".notification").classList.add("hide");
      document.querySelector(".notification").classList.remove("show");
      },3000);
    document.querySelector('.close-btn').addEventListener("click", ()=>{
      document.querySelector(".notification").classList.add("hide");
      document.querySelector(".notification").classList.remove("show"); 
    });
    setTimeout(function(){
      document.querySelector(".notification").remove();
      },5000);
  
</script>

<?php endforeach ?> 