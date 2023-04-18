<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-task" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_form; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-task" class="form-horizontal">
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-project"><?php echo $entry_project; ?></label>
            <div class="col-sm-5">
              <select name="project_id" id="project_id" class="dropdown-header form-control">
              <?php foreach ($project as $skey => $svalue) { //echo "<pre>";print_r($project_id);exit; ?>
                <?php if ($skey == $project_id) { ?>
                  <option value="<?php echo $skey ?>" class ="dropdown-manu form-control" selected="selected"><?php echo $svalue; ?></option>
                <?php } else { ?>
                  <option value="<?php echo $skey ?>" class ="dropdown-manu form-control"><?php echo $svalue ?></option>
                <?php } ?>
              <?php } ?>
              </select>
              <input type="hidden" name="user_id" value="<?php echo $user_id; ?>" id="input-user_id" class="form-control" />
            </div>
          </div>
          <?php if ($user_group_id == 1) {?>
            <div class="form-group">
              <label class="col-sm-2 control-label" for="input-username">User</label>
                <div class="col-sm-5">
                  <select name="user_id" id="user_id" class="dropdown-header form-control">
                    <?php foreach ($username as $skey => $svalue) { //echo "<pre>";print_r($user_id);exit; ?>
                      <?php if ($skey == $user_id) { ?>
                        <option value="<?php echo $skey ?>" class ="dropdown-manu form-control" selected="selected"><?php echo $svalue; ?></option>
                      <?php } else { ?>
                        <option value="<?php echo $skey ?>" class ="dropdown-manu form-control"><?php echo $svalue ?></option>
                      <?php } ?>
                    <?php } ?>
                  </select>
              </div>
            </div>
          <?php }?>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-project_start_time"><?php echo $entry_project_start_time; ?></label>
            <div class="col-sm-10">
              <input type="time" name="project_start_time" value="<?php echo $project_start_time; ?>" placeholder="<?php echo $entry_project_start_time; ?>" id="input-project_start_time" class="form-control" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-project_end_time"><?php echo $entry_project_end_time; ?></label>
            <div class="col-sm-10">
              <input type="time" name="project_end_time" value="<?php echo $project_end_time; ?>" placeholder="<?php echo $entry_project_end_time; ?>" id="input-contact_person" class="form-control" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-task"><?php echo $entry_task; ?></label>
            <div class="col-sm-10">
              <input type="tel" name="task" value="<?php echo $task; ?>" placeholder="<?php echo $entry_task; ?>" id="input-task" class="form-control" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
            <div class="col-sm-10">
              <select name="status" id="input-status" class="form-control">
                <option value="done"<?php if ($status == 'done') { echo ' selected="selected"'; } ?>>Done</option>
                <option value="left"<?php if ($status == 'left') { echo ' selected="selected"'; } ?>>Left</option>
                <option value="working"<?php if ($status == 'working') { echo ' selected="selected"'; } ?>>Working</option>
                <option value="c/f-working"<?php if ($status == 'c/f-working') { echo ' selected="selected"'; } ?>>C/F-Working</option>
                <option value="c/f-done"<?php if ($status == 'c/f-done') { echo ' selected="selected"'; } ?>>C/F-Done</option>
                <option value="transfer"<?php if ($status == 'transfer') { echo ' selected="selected"'; } ?>>Transfer</option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-commit_no"><?php echo $entry_commit_no; ?></label>
            <div class="col-sm-10">
              <input type="text" name="commit_no" value="<?php echo $commit_no; ?>" placeholder="<?php echo $entry_commit_no; ?>" id="input-commit_no" class="form-control" />
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?php echo $footer; ?>