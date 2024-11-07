<?php
session_start();
session_unset();  // Unset all session variables
session_destroy();  // Destroy the session
?>

<script type="text/javascript">
    // Clear localStorage
    localStorage.removeItem('userType');
    
    // Redirect to login page
    window.location.href = "login.html";
</script>
