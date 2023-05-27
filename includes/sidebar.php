<div class="col-md-4" style="padding:0;margin-top:-1.6rem">
  <!-- Side Widget -->
  <div class="card my-4">
    <h5 class="card-header">Recent News</h5>
    <div class="card-body">
      <ul class="list-unstyled mb-0">
        <?php
        $query = mysqli_query($mysqli, "SELECT * FROM tblposts ORDER BY PostingDate DESC LIMIT 5");
        while ($res = mysqli_fetch_array($query)) {
          $id = $res['id'];
          $post_title  = $res['PostTitle'];
          $post_image = $res['PostImage'];
          $post_views = $res['Views'];

          // Increment views count if the post has been viewed
          if (isset($_COOKIE["viewed_post_$id"]) === false) {
            mysqli_query($mysqli, "UPDATE tblposts SET Views=Views+1 WHERE id=$id");
            setcookie("viewed_post_$id", 1, time()+60*60*24); // Set cookie to expire in 24 hours
            $post_views++;
          }
        ?>
        <li class="media mb-3">
          <a href="news-details.php?nid=<?php echo $id; ?>"><img class="mr-3" src="postimages/<?php echo $post_image;?>" alt="<?php echo $post_title;?>" width="100"></a>
          <div class="media-body">
            <h6 class="mt-0 mb-1"><a href="news-details.php?nid=<?php echo $id; ?>"><?php echo $post_title;?></a></h6>
            <small class="text-muted"><?php echo $post_views;?> views</small>
          </div>
        </li>
        <?php } ?>
      </ul>
    </div>
  </div>
</div>
