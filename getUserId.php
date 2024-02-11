<?php

require_once 'components/common.php';
require_once 'components/common_utils.php';
class User {
  public function getCurrentUserId() {
    return $_SESSION['user_id'];
  }
}

$user = new User(); // Create an instance of the User class
$user_id = $user->getCurrentUserId(); // Call the getCurrentUserId() method

echo $user_id; // Return the user_id as the response
?>
