<form method="POST" action="submit_comment.php">
  <div class="form-group">
    <label for="name">Name:</label>
    <input type="text" class="form-control" id="name" name="name" required>
  </div>
  <div class="form-group">
    <label for="comment">Comment:</label>
    <textarea class="form-control" id="comment" name="comment" rows="3" required></textarea>
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>