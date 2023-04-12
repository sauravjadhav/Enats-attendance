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
            <div class="col-sm-10">
              <input type="text" name="project" value="<?php echo $project; ?>" placeholder="<?php echo $entry_project; ?>" id="input-project" class="form-control" />
            </div>
          </div>
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
              <input type="text" name="status" value="<?php echo $status; ?>" placeholder="<?php echo $entry_status; ?>" id="input-status" class="form-control" />
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