<?php require_once "controllerUserData.php"; ?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Payroll News and Announcements</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="news-style.css">
   <style>
  .comment-section {
    margin-top: 20px;
  }

  .comment {
    margin-top: 20px;
  }

  .comment .comment-details {
    display: flex;
    flex-direction: row;
    justify-content: space-between;
  }

  .comment .comment-details img {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    margin-right: 10px;
  }

  .comment .comment-details h6 {
    margin: 0;
  }

  .comment .comment-text {
    margin-top: 10px;
  }

  .comment-form {
    margin-top: 20px;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
  }

  .comment-form textarea {
    height: 100px;
    resize: none;
    margin-bottom: 10px;
  }

  .comment-form button {
    margin-top: 10px;
  }

  .close-comment-form {
    display: block;
    text-align: right;
    margin-top: -20px;
    margin-right: -20px;
    cursor: pointer;
  }
</style>

  </head>
  <body>
      <!-- Include jQuery library -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Define likePost function -->
<script>
function likePost(postId) {
  // Send AJAX request to increment like count
  $.ajax({
    url: "like_post.php",
    type: "POST",
    data: { postId: postId },
    success: function(data) {
      // Update like count on button
      var likeBtn = $("button[onclick='likePost(" + postId + ")']");
      var likeCount = parseInt(likeBtn.find(".like_count").text()) + 1;
      likeBtn.find(".like_count").text(likeCount);
    }
  });
}


</script>








    <!-- Navigation -->
    <?php include('includes/header.php');?>

    <!-- Page Content -->
    <div class="container my-4">

      <div class="row">
        <!-- News Feed Column -->
        <div class="col-md-8">
          <div class="card mb-3">
            <div class="card-body">
              <h2 class="card-title">Latest News and Announcements</h2>
              <hr>
              <?php 
                $mysqli = new mysqli('bsu-info.tech', 'u455679702_cps', 'OpK3RKh]!h9', 'u455679702_cps') or die(mysqli_error($mysqli));
                $query = mysqli_query($mysqli, "SELECT * FROM tblposts");
                while ($res = mysqli_fetch_array($query)) {
                  $id = $res['id'];
                  $post_title = $res['PostTitle'];
                  $post_image = $res['PostImage'];
                  $post_date = $res['PostingDate'];
                   $like_count = $res['like_count'];
              ?>
              <!-- Post Card -->
              <div id="card-<?php echo $id; ?>" class="card mb-4">
                <div class="card-header bg-white">
                  <div class="d-flex align-items-center">
                    <img src="src/images/cboo.jpg" alt="User Image" class="rounded-circle me-3" width="50" height="50">
                    <div>
                      <h5 class="card-title mb-0"><?php echo $post_title; ?></h5>
                      <small class="text-muted"><?php echo $post_date; ?></small>
                    </div>
                  </div>
                </div>
                <img class="card-img-top" src="postimages/<?php echo $post_image; ?>" alt="Post Image">
                <div class="card-body">
                  <p class="card-text"></p>
                  <a href="news-details.php?nid=<?php echo $id; ?>" class="btn btn-primary">Read More &rarr;</a>
                </div>
                <div class="card-footer bg-white">
               <div class="d-flex justify-content-between align-items-center">
                  <div class="d-flex align-items-center">
                    <button type="button" class="btn btn-link" onclick="likePost(<?php echo $id; ?>)">
                      <i class="fas fa-thumbs-up"></i> Like <span class="like_count"><?php echo $like_count; ?></span>
                    </button>
                    <button type="button" class="btn btn-link" onclick="showCommentForm(<?php echo $id; ?>)">
                      <i class="fas fa-comment"></i> Comment
                    </button>
                    <div id="comment-form-container-<?php echo $id; ?>" class="comment-form d-none">
                      <form>
                        <textarea class="form-control" placeholder="Add a comment..."></textarea>
                        <button type="submit" class="btn btn-primary">Comment</button>
                      </form>
                      <div class="close-comment-form" onclick="hideCommentForm(<?php echo $id; ?>)">
                        <i class="fas fa-times"></i>
                      </div>
                    </div>
                  </div>
                  <small class="text-muted"> 1 comment</small>
                </div>
                </div>
              </div>
              <!-- End Post Card -->
              <?php } ?>
            </div>
          </div>
        </div>
        <!-- End News Feed Column -->
           <!-- Start Sidebar Column -->
      <div class="col-md-4">
        <!-- Start Popular Posts Widget -->
        <div class="card mb-4">
          <h5 class="card-header">Popular Posts</h5>
          <div class="card-body">
            <div class="list-group">
              <?php
                $query_popular = mysqli_query($mysqli, "SELECT * FROM tblposts ORDER BY Views DESC LIMIT 5");
                while ($res_popular = mysqli_fetch_array($query_popular)) {
                  $post_title = $res_popular['PostTitle'];
                  $post_id = $res_popular['id'];
              ?>
              <a href="news-details.php?nid=<?php echo $post_id; ?>" class="list-group-item"><?php echo $post_title; ?></a>
              <?php } ?>
            </div>
          </div>
        </div>
        <!-- End Popular Posts Widget -->

        <!-- Start Categories Widget -->
        <div class="card mb-4">
          <h5 class="card-header">Categories</h5>
          <div class="card-body">
            <div class="list-group">
              <?php
                $query_categories = mysqli_query($mysqli, "SELECT * FROM tblcategories");
                while ($res_categories = mysqli_fetch_array($query_categories)) {
                  $category_title = $res_categories['CategoryName'];
                  $category_id = $res_categories['id'];
              ?>
              <a href="category-posts.php?cid=<?php echo $category_id; ?>" class="list-group-item"><?php echo $category_title; ?></a>
              <?php } ?>
            </div>
          </div>
        </div>
        <!-- End Categories Widget -->

        <!-- Start Tags Widget -->
        <div class="card mb-4">
          <h5 class="card-header">Tags</h5>
          <div class="card-body">
            <div class="tag-cloud">
              <?php
                $query_tags = mysqli_query($mysqli, "SELECT DISTINCT PostTags FROM tblposts WHERE PostTags <> ''");
                while ($res_tags = mysqli_fetch_array($query_tags)) {
                  $tags = explode(",", $res_tags['PostTags']);
                  foreach ($tags as $tag) {
              ?>
              <a href="#" class="tag"><?php echo $tag; ?></a>
              <?php } } ?>
            </div>
          </div>
        </div>
        <!-- End Tags Widget -->
      </div>
      <!-- End Sidebar Column -->
    </div>
    <!-- End News Feed and Sidebar Row -->
  </div>
  <!-- End News Feed and Sidebar Container -->
</main>

<!-- Start Footer -->
<?php include('includes/footer.php'); ?>
<!-- End Footer -->



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>