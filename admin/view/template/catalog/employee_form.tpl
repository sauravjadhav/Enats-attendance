<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
    <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
      <button type="submit" form="form-employee" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
      <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
      <?php foreach ($breadcrumbs as $breadcrumb) { ?>
      <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
      <?php } ?>
      </ul>
    </div>
    </div>      
    <div class="panel-heading">
    <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_form; ?></h3>
    </div>
  <div class="panel-body">
    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-employee" class="form-horizontal">
      <div class="form-group required">
          <label class="col-sm-2 control-label" for="input-login"><?php echo $entry_login; ?></label>
        <div class="col-sm-10">
          <input type="text" name="login" value="<?php echo $login; ?>" placeholder="<?php echo $entry_login; ?>" id="input-login" class="form-control" />
          <?php if ($error_login) { ?>
          <div class="text-danger"><?php echo $error_login; ?></div>
          <?php } ?>
        </div>
        </div>
      <div class="form-group required">
          <label class="col-sm-2 control-label" for="input-name"><?php echo $entry_name; ?></label>
        <div class="col-sm-10">
          <input type="text" name="name" value="<?php echo $name; ?>" placeholder="<?php echo $entry_name; ?>" id="input-name" class="form-control" />
          <?php if ($error_name) { ?>
          <div class="text-danger"><?php echo $error_name; ?></div>
          <?php } ?>
        </div>
        </div>
        <div class="form-group required">
          <label class="col-sm-2 control-label" for="input-name"><?php echo $entry_father_name; ?></label>
        <div class="col-sm-10">
          <input type="text" name="father name" value="<?php echo $father_name; ?>" placeholder="<?php echo $entry_father_name; ?>" id="input-name" class="form-control" />
          <?php if ($error_father_name) { ?>
          <div class="text-danger"><?php echo $error_father_name; ?></div>
          <?php } ?>
        </div>
        </div>
        <div class="form-group required">
          <label class="col-sm-2 control-label" for="input-name"><?php echo $entry_surname; ?></label>
        <div class="col-sm-10">
          <input type="text" name="surname" value="<?php echo $surname; ?>" placeholder="<?php echo $entry_surname; ?>" id="input-name" class="form-control" />
          <?php if ($error_surname) { ?>
          <div class="text-danger"><?php echo $error_surname; ?></div>
          <?php } ?>
        </div>
        </div>
      <div class="form-group required">
        <label class="col-sm-2 control-label" for="input-email"><?php echo $entry_email; ?></label>
        <div class="col-sm-10">
          <input type="text" name="email" value="<?php echo $email; ?>" placeholder="<?php echo $entry_email; ?>" id="input-email" class="form-control" />
          <?php if ($error_email) { ?>
          <div class="text-danger"><?php echo $error_email; ?></div>
          <?php } ?>
        </div>
      </div>
      <div class="form-group required">
        <label class="col-sm-2 control-label" for="input-password"><?php echo $entry_password; ?></label>
        <div class="col-sm-10">
          <input type="text" name="password" value="<?php echo $password; ?>" placeholder="<?php echo $entry_password; ?>" id="input-password" class="form-control" />
          <?php if ($error_password) { ?>
          <div class="text-danger"><?php echo $error_password; ?></div>
          <?php } ?>
        </div>
      </div>
        <div class="form-group required">
        <label class="col-sm-2 control-label" for="input-number"> Contact Number</label>
        <div class="col-sm-10">
          <input type="text" name="numbers" value="<?php echo $numbers; ?>" placeholder= 'Contact Number' id="input-number" class="form-control" />
          <?php if ($error_numbers) { ?>
          <div class="text-danger"><?php echo $error_numbers; ?></div>
          <?php } ?>
        </div>
        </div>
        <div class="form-group required">
        <label class="col-sm-2 control-label" for="input-date"> Date of Birth</label>
        <div class="col-sm-10">
          <input type="date" name="dob" value="<?php echo $dob; ?>" placeholder= '' id="input-date" class="form-control" />
          <?php if ($error_dob) { ?>
          <div class="text-danger"><?php echo $error_dob; ?></div>
          <?php } ?>
        </div>
        </div>
      <div class="form-group required">
        <label class="col-sm-2 control-label" for="input-address"><?php echo $entry_address; ?></label>
        <div class="col-sm-10">
        <input type="text" name="address" value="<?php echo $address; ?>" placeholder="<?php echo $entry_address; ?>" id="input-address" class="form-control" />
        <?php if ($error_address) { ?>
        <div class="text-danger"><?php echo $error_address; ?></div>
        <?php } ?>
        </div>
      </div>
       <div class="form-group required">
        <label class="col-sm-2 control-label" for="input-date"> Date of Joining ENATTS</label>
        <div class="col-sm-10">
          <input type="date" name="doje" value="<?php echo $doje; ?>" placeholder= '' id="input-date" class="form-control" />
          <?php if ($error_doje) { ?>
          <div class="text-danger"><?php echo $error_doje; ?></div>
          <?php } ?>
        </div>
        </div>
      <div class="form-group required">
        <label class="col-sm-2 control-label" for="input-pan"><?php echo $entry_pan; ?></label>
        <div class="col-sm-10">
        <input type="text" name="pan" value="<?php echo $pan; ?>" placeholder="<?php echo $entry_pan; ?>" id="input-pan" class="form-control" />
        <?php if ($error_pan) { ?>
        <div class="text-danger"><?php echo $error_pan; ?></div>
        <?php } ?>
        </div>
      </div>
       <div class="form-group required">
        <label class="col-sm-2 control-label" for="input-adhaar"><?php echo $entry_adhaar; ?></label>
        <div class="col-sm-10">
        <input type="text" name="adhaar" value="<?php echo $adhaar; ?>" placeholder="<?php echo $entry_adhaar; ?>" id="input-adhaar" class="form-control" />
        <?php if ($error_adhaar) { ?>
        <div class="text-danger"><?php echo $error_adhaar; ?></div>
        <?php } ?>
        </div>
      </div>
      <div class="form-group ">
        <label class="col-sm-2 control-label" for="input-bank_details"><?php echo $entry_bank_details; ?></label>
        <div class="col-sm-10">
        <input type="text" name="bank_details" value="<?php echo $bank_details; ?>" placeholder="<?php echo $entry_bank_details; ?>" id="input-name" class="form-control" />
        </div>
      </div>
      <div class="form-group ">
        <label class="col-sm-2 control-label" for="input-emergency_contact_person_details"><?php echo $entry_emergency_contact_person_details; ?></label>
        <div class="col-sm-10">
        <input type="text" name="emergency_contact_person_details" value="<?php echo $emergency_contact_person_details; ?>" placeholder="<?php echo $entry_emergency_contact_person_details; ?>" id="input-name" class="form-control" />
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-2 control-label" for="input-laptop_model"><?php echo $entry_laptop_model; ?></label>
        <div class="col-sm-10">
        <input type="text" name="laptop_model" value="<?php echo $laptop_model; ?>" placeholder="<?php echo $entry_laptop_model; ?>" id="input-laptop_model" class="form-control" />
        </div>
      </div>
<?php echo $footer; ?>