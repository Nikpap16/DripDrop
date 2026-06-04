<?php
session_start(); 
session_unset(); // Αδειάζει όλες τις μεταβλητές
session_destroy(); // Καταστρέφει τη συνεδρία τελείως

// Ανακατεύθυνση στην αρχική σελίδα
header("Location: index.php");
exit();
?>