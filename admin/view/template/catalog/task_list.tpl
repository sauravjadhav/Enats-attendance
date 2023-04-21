<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right"><a href="<?php echo $add; ?>" data-toggle="tooltip" title="<?php echo $button_add; ?>" class="btn btn-primary"><i class="fa fa-plus"></i></a>
        <button type="button" data-toggle="tooltip" title="<?php echo $button_delete; ?>" class="btn btn-danger" onclick="confirm('<?php echo $text_confirm; ?>') ? $('#form-project').submit() : false;"><i class="fa fa-trash-o"></i></button>
      </div>
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
    <?php if ($success) { ?>
    <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $text_list; ?></h3>
      </div>
      <div class="panel-body">
        <?php if ($user_group_id != 12) { ?>
          <div class="well">
            <div class="row">
              <div class="col-sm-4">
                <div class="form-group">
                  <label class="control-label" for="input-project"><?php echo $entry_project; ?></label>
                  <select name="project_id" id="project_id" class="dropdown-header form-control">
                    <?php foreach ($project as $skey => $svalue) { //echo "<pre>";print_r($project_id);exit; ?>
                      <?php if ($skey == $project_id) { ?>
                        <option value="<?php echo $skey ?>" class ="dropdown-manu form-control" selected="selected"><?php echo $svalue; ?></option>
                      <?php } else { ?>
                        <option value="<?php echo $skey ?>" class ="dropdown-manu form-control"><?php echo $svalue ?></option>
                      <?php } ?>
                    <?php } ?>
                    <option value="" selected="selected" class ="dropdown-manu form-control">Select project</option>
                  </select>
                </div>
              </div>
              <?php if ($user_group_id == 1) { ?>
                <div class="col-sm-4">
                  <div class="form-group">
                    <label class="control-label" for="input-project">User</label>
                    <select name="user_id" id="user_id" class="dropdown form-control">
                      <?php foreach ($username as $skey => $svalue) { //echo "<pre>";print_r($user_id);exit; ?>
                        <?php if ($skey == $user_id) { ?>
                          <option value="<?php echo $skey ?>" class ="dropdown-manu form-control" selected="selected"><?php echo $svalue; ?></option>
                        <?php } else { ?>
                          <option value="<?php echo $skey ?>" class ="dropdown-manu form-control"><?php echo $svalue ?></option>
                        <?php } ?>
                      <?php } ?>
                      <option value="" selected="selected" class ="dropdown-manu form-control">Select User</option>
                    </select>
                  </div>
                </div>
              <?php }?>
              <div class="col-sm-5 pull-right">
                <button type="button" id="button-filter" class="btn btn-primary"><i class="fa fa-search"></i> <?php echo $button_filter; ?></button>
              </div>
            </div>
          </div>
        <?php }?>
        </div>
        <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form-project">
          <div class="table-responsive">
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <td style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td>
                  <td class="text-left"><?php if ($sort == 'date') { ?>
                  <a href="<?php echo $sort_date; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_date; ?></a>
                  <?php } else { ?>
                  <a href="<?php echo $sort_date; ?>"><?php echo $column_date; ?></a>
                  <?php } ?></td>
                  <?php if ($user_group_id == 1) { ?>
                    <td class="text-left">User</td>
                  <?php }?>
                  <td class="text-left"><?php echo $column_project;?></td>
                  <td class="text-left"><?php echo $column_task;?></td>
                  <td class="text-left"><?php echo $column_status;?></td>
                  <td class="text-right"><?php echo $column_action; ?></td>
                </tr>
              </thead>
              <tbody>
                <?php if ($tasks) { ?>
                <?php foreach ($tasks as $task) { ?>
                <tr>
                  <td class="text-center"><?php if (in_array($task['task_id'], $selected)) { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $task['task_id']; ?>" checked="checked" />
                    <?php } else { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $task['task_id']; ?>" />
                    <?php } ?></td>
                  <td class="text-left"><?php echo $task['date']; ?></td>
                  <?php if ($user_group_id == 1) { ?>
                    <td class="text-left">
                        <?php echo $task['username']; ?>
                    </td>
                  <?php }?>
                  <td class="text-left"><?php echo $task['project']; ?></td>
                  <td class="text-left"><?php echo $task['task']; ?></td>
                  <td class="text-left"><?php echo $task['status']; ?></td>
                  <td class="text-right"><a href="<?php echo $task['edit']; ?>" data-toggle="tooltip" title="<?php echo $button_edit; ?>" class="btn btn-primary"><i class="fa fa-pencil"></i></a></td>
                </tr>
                <?php } ?>
                <?php } else { ?>
                <tr>
                  <td class="text-center" colspan="4"><?php echo $text_no_results; ?></td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </form>
        <div class="row">
          <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
          <div class="col-sm-6 text-right"><?php echo $results; ?></div>
        </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript"><!--
$('#button-filter').on('click', function() {
  var url = 'index.php?route=catalog/task&token=<?php echo $token; ?>';

  var project_id = $('select[name=\'project_id\']').val();

  if (project_id) {
    url += '&project_id=' + encodeURIComponent(project_id);
  }

  var user_id = $('select[name=\'user_id\']').val();

  if (user_id) {
    url += '&user_id=' + encodeURIComponent(user_id);
  }

  location = url;
});
//--></script>
<?php echo $footer; ?>