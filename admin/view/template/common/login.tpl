<head>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</head>
<div class="content">
  <!-- <?php echo $header; ?> -->
  <img src="view/image/enatsLogoe1.jpg">
  <section class="" style="background-color: #508bfc; height: 93vh;">
    <div class="container py-5" style="height: 100%">
      <div class="row justify-content-center align-items-center" style="height: 100%;">
        <div class="col-sm-4">
          <div class="card shadow-2-strong hover11" style="border-radius: 1rem;">
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
                <button type="submit" style="background-color: #3b71ca;" class="btn btn-primary btn-block">
                  <i class="fa fa-key"></i> <?php echo $button_login; ?>
                </button>
              </div>
              <?php if ($forgotten) { ?>
                <div class="text-center" style="margin-top: 22px;">
                  <a style="color: #3b71ca; text-align: center;" href="<?php echo $forgotten; ?>"><?php echo $text_forgotten; ?></a>
                </div>
              <?php } ?>
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
<style>
  .hover11:hover{
    box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
  }
  header{
    justify-content: center!important;
  }
</style>
<!-- <?php echo $footer; ?>  