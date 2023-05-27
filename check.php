<?php
if (session_status() == PHP_SESSION_ACTIVE) {
    header("location:https://cps.bsu-info.tech/index.php");
  } else {
    // There is no active session
    header("location:https://cps.bsu-info.tech/login.php");
  }
?>