<?php require_once "controllerUserData.php"; ?>
<!DOCTYPE html>
<html>
  <head>
    <title>Payroll News and Announcements</title>
    <link rel="stylesheet" href="news-style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css">
  </head>
  <body>
  <?php 
$mysqli = new mysqli('bsu-info.tech', 'u455679702_cps', 'OpK3RKh]!h9', 'u455679702_cps') or die(mysqli_error($mysqli)); 
  include('includes/header.php');
  $query = mysqli_query($mysqli, "SELECT * FROM tblposts");

  while ($res = mysqli_fetch_array($query)) {
    $id = $res['id'];
  }

  $pid = intval($_GET['nid']);
  $mysqli->query("UPDATE tblposts SET Views = Views + 1 WHERE id='$pid'");
    
  ?>
 <div class="container">
     
<div class="row" style="margin-top: 4%">
<div class="col-md-8">

<!-- Blog Post -->
<?php
$query=mysqli_query($mysqli,"SELECT tblposts.PostTitle as posttitle,tblposts.PostImage,tblposts.PostDetails as postdetails,tblposts.PostingDate as postingdate,tblposts.PostUrl as url FROM tblposts WHERE tblposts.id='$pid'");
while ($row=mysqli_fetch_array($query)) {
?>

<div class="card mb-4" style="margin-left: 200px;">

  <div class="card-body">
    <h2 class="card-title"><?php echo htmlentities($row['posttitle']);
    $post_title = ($row['posttitle']);

    ?></h2>
   <b> Posted on </b><?php echo htmlentities($row['postingdate']);?></p>
      <hr />

<img class="img-fluid rounded" src="postimages/<?php echo htmlentities($row['PostImage']);?>" alt="<?php echo htmlentities($row['posttitle']);?>">

    <p class="card-text"><?php 
$pt=$row['postdetails'];
    echo  (substr($pt,0));?></p>
   
  </div>
  <div class="card-footer text-muted">
   
 
  </div>
</div>
<?php } ?>






</div>
 <!-- Sidebar Widgets Column -->
 <?php include('includes/sidebar.php');?>
</div>
</div>
   
         
  </body>
</html>