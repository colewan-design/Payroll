<?php
$mysqli = new mysqli('bsu-info.tech', 'u455679702_cps', 'OpK3RKh]!h9', 'u455679702_cps') or die(mysqli_error($mysqli));

if(isset($_POST['postId'])) {
  $post_id = $_POST['postId'];

  // increment the like count in the database using a prepared statement
  $stmt = $mysqli->prepare("UPDATE tblposts SET like_count = like_count + 1 WHERE id = ?");
  $stmt->bind_param("i", $post_id);
  $stmt->execute();
  $stmt->close();
}
?>
