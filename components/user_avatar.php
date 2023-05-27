<div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
           <?php if($image==NULL)
			{
			echo '<img src = "dist/img/user2-16x160.jpg" class="img-circle elevation-2">';
			} else { echo '<img src="images/'.$image.'" class="img-circle elevation-2">';}?> 
        </div>
        <div class="info">
          <a href="account.php" class="d-block"><?php echo $fetch_info['name'] ?></a>
        </div>
      </div>