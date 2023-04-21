<?php echo $header; ?>
<div id="content">
  <div class="container-fluid"><br />
    <br />
    <div class="row">
      <div class="col-sm-offset-4 col-sm-4">
        <div class="panel panel-default" style="width: 69%; background-color: #2a2a72; background-image: linear-gradient(315deg, #2a2a72 0%, #009ffd 74%); ">
          <div class="panel-heading">
            <h1 class="panel-title" style="text-align: center;" > <?php echo $text_login; ?></h1>
          </div>
          <div class="panel-body">
            <?php if ($success) { ?>
            <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
              <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
            <?php } ?>
            <?php if ($error_warning) { ?>
            <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
              <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
            <?php } ?>
            <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
              <div class="form-group" >
                <label for="input-username"><?php echo $entry_username; ?></label>
                <div class="input-group" style="display: inline-flex; width: 70% ;margin-left: 50px;" >
                  <input type="text" name="username" value="<?php echo $username; ?>" placeholder="<?php echo $entry_username; ?>" id="input-username" class="form-control" />
                </div>
              </div>
              <div class="form-group" style="border: none;">
                <label for="input-password"><?php echo $entry_password; ?></label>
                <div class="input-group" style="display: inline-flex; width: 70% ;margin-left: 53px;">
                  <input type="password" name="password" value="<?php echo $password; ?>" placeholder="<?php echo $entry_password; ?>" id="input-password" class="form-control" />
                </div>
              </div>
              <div class="text-center">
                <?php if ($forgotten) { ?>
                <button class="btn btn-primary" style="padding: 5px; height: 35px" ><a href="<?php echo $forgotten; ?>" style="color: white;"><?php echo $text_forgotten; ?></a></button>
                <?php } ?>
                <button type="submit" class="btn btn-primary"><i class="fa fa-key"></i> <?php echo $button_login; ?></button>
              </div>
              <?php if ($redirect) { ?>
              <input type="hidden" name="redirect" value="<?php echo $redirect; ?>" />
              <?php } ?>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php echo $footer; ?>