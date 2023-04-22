<?php echo $header; ?>
<!-- <div id="content" style="background-color: #f2f2f2;">
  <div class="container-fluid" style="padding-top: 20px;">
    <div class="row">
      <div class="col-sm-offset-4 col-sm-4">
        <div class="panel panel-default" style="width: 69%; background-color: #2a2a72; background-image: linear-gradient(315deg, #2a2a72 0%, #009ffd 74%); color: #fff;">
          <div class="panel-heading">
            <h1 class="panel-title" style="text-align: center;"><?php echo $text_login; ?></h1>
          </div>
          <div class="panel-body">
            <?php if ($success) { ?>
            <div class="alert alert-success" style="background-color: #28a745; color: #fff; border-color: #28a745;">
              <i class="fa fa-check-circle"></i> <?php echo $success; ?>
              <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
            <?php } ?>
            <?php if ($error_warning) { ?>
            <div class="alert alert-danger" style="background-color: #dc3545; color: #fff; border-color: #dc3545;">
              <i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
              <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
            <?php } ?>
            <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
              <div class="form-group" style="display: inline-flex; width: 70%; margin-left: 50px;">
                <label for="input-username" style="margin-bottom: 0; padding-right: 5px;"><?php echo $entry_username; ?></label>
                <input type="text" name="username" value="<?php echo $username; ?>" placeholder="<?php echo $entry_username; ?>" id="input-username" class="form-control" style="border-radius: 5px; border: none; padding: 5px; background-color: #fff;" />
              </div>
              <div class="form-group" style="border: none; display: inline-flex; width: 70%; margin-left: 53px;">
                <label for="input-password" style="margin-bottom: 0; padding-right: 5px;"><?php echo $entry_password; ?></label>
                <input type="password" name="password" value="<?php echo $password; ?>" placeholder="<?php echo $entry_password; ?>" id="input-password" class="form-control" style="border-radius: 5px; border: none; padding: 5px; background-color: #fff;" />
              </div>
              <div class="text-center" style="margin-top: 20px;">
                <?php if ($forgotten) { ?>
                <button class="btn btn-primary" style="padding: 5px; height: 35px; margin-right: 10px; border: none; border-radius: 5px; background-color: #3d7aed;">
                  <a href="<?php echo $forgotten; ?>" style="color: white; text-decoration: none;"><?php echo $text_forgotten; ?></a>
                </button>
                <?php } ?>
                <button type="submit" class="btn btn-primary" style="padding: 5px; height: 35px;">
                  <i class="fa fa-key"></i> <?php echo $button_login; ?>
                </button>
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
</div> -->
<head>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</head>
<div class="content">
  <section class="vh-100" style="background-color: #508bfc;">
    <div class="container py-5 h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-12 col-md-8 col-lg-6 col-xl-5">
          <div class="card shadow-2-strong" style="border-radius: 1rem;">
            <div class="card-body p-5 text-center">

              <h3 class="mb-5">Login in</h3>

              <?php if ($success) { ?>
            <div class="alert alert-success">
              <i class="fa fa-check-circle"></i> <?php echo $success; ?>
              <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
            <?php } ?>
            <?php if ($error_warning) { ?>
            <div class="alert alert-danger">
              <i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
              <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
            <?php } ?>
            <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
              <div class="form-outline mb-4">
                <label class="form-label" for="input-username"></label>
                <input type="text" name="username" value="<?php echo $username; ?>" placeholder="<?php echo $entry_username; ?>" id="input-username" class="form-control form-control-lg"/>
              </div>
              <div class="form-outline mb-4">
                <label class="form-label" for="input-password"></label>
                <input type="password" name="password" value="<?php echo $password; ?>" placeholder="<?php echo $entry_password; ?>" id="input-password" class="form-control form-control-lg" />
              </div>
              <div class="text-center">
                <button type="submit" class="btn btn-primary btn-lg btn-block">
                  <i class="fa fa-key"></i> <?php echo $button_login; ?>
                </button>
                <?php if ($forgotten) { ?>
                
                  <a style="color: blue;" href="<?php echo $forgotten; ?>"><?php echo $text_forgotten; ?></a>
                
                <?php } ?>
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
  </section>
</div>
<!-- <?php echo $footer; ?>  