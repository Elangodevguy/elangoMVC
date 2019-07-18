<?php require APPROOT . '/views/inc/header.php'; ?>
<a href="<?php echo URLROOT; ?>/posts" class="btn btn-light mt-5"> <i class="fas fa-backward mr-3"></i>Back</a>
<div class="card bg-light mt-5">
  <div class="card-header">
    <h2>Add Post</h2>
    <p>Fill these fields to create new post</p>
  </div>
  <div class="card-body">
    <form action="<?php echo URLROOT; ?>/posts/add" method="post">
      <div class="form-group">
        <label for="title">Title<sup>*</sup></label>
        <input type="text" name="title" class="form-control <?php echo (!empty($data['title_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['title']; ?>">
        <span class="invalid-feedback"><?php echo $data['title_err']; ?></span>
      </div>
      <div class="form-group">
        <label for="body">Body<sup>*</sup></label>
        <textarea name="body" class="form-control <?php echo (!empty($data['body_err'])) ? 'is-invalid' : ''; ?>"><?php echo $data['body']; ?></textarea>
        <span class="invalid-feedback"><?php echo $data['body_err']; ?></span>
      </div>
      <input type="submit" value="Add" class="btn btn-success">
    </form>
  </div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>