<?php 
    if (isset($_SESSION['msg'])) { 
        
        $msg = $_SESSION['msg'];
      
        $msg_type = isset($_SESSION['msg_type']) ? $_SESSION['msg_type'] : 'msg';

         echo"
         <script> 
        alertify.set('notifier','position', 'top-right');
        alertify.$msg_type('$msg');
       
         </script>
         ";

         // Clear session message
        unset($_SESSION['msg']);
        unset($_SESSION['msg_type']);
    } ?>