<?php if($_COOKIE['user_id'] > 0){?>
<form class="form-horizontal">
  <div class="form-group">
    <label for="title" class="col-sm-2 control-label">Link Title</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="title" placeholder="Title">
      <div id="titleAlert" class="alert alert-danger" role="alert"><span class="sr-only">Error:</span>Enter a link title</div>
    </div>

  </div>
  <div class="form-group">
    <label for="link" class="col-sm-2 control-label">Link URL</label>
    <div class="col-sm-10">
      <input type="url" class="form-control" id="link" placeholder="Link">
      <div id="linkAlert" class="alert alert-danger" role="alert"><span class="sr-only">Error:</span>Enter a valid URL</div>
    </div>

  </div>

  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" id="save" class="btn btn-default">Save</button>
    </div>
  </div>
  <div id="saved" role="alert" class="alert alert-success">
      <strong>Your link was saved.</strong> Add another above or <a href="/home">go home</a>.
  </div>
</form>
<?php }else{ ?>
  <p class="bg-danger"><strong>You must be logged in to add a link.</strong></p>
<?php } ?>
