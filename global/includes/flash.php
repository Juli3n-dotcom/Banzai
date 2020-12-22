<?php foreach (recupererFlash() as $messages): ?>

<div id="toats" class="notif alert-<?= $messages['type'];?>">
    <div class="toats_headers">
        <a class="toats_die">
            X
        </a>
            <h5><i class="fas fa-exclamation-circle"></i> Notification :</h5>
    </div>
    <div class="toats_core">
        <p>
        <?= $messages['message'];?>
        </p>
    </div>          
</div>

<script>
    setTimeout(function(){ document.querySelector(".notif").remove();}, 4000 );

    document.querySelector(".toats_die").addEventListener("click", ()=>{
        document.querySelector(".notif").remove();
    });
</script>

<?php endforeach ?> 