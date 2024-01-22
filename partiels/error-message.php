<?php
    session_start();
    /*Si le session existe, affiche le message d'erreur qu'il contient*/
    if(isset($_SESSION['message'])) {
        echo "
        <div class='alert'>
            <span class='closebtn' onclick='this.parentElement.style.display='none';'></span>
            ".$_SESSION['message']."
        </div>";
    } 
?>