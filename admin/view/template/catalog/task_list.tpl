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
        <div class="well">
          <div class="row">
            <div class="col-sm-4">
              <div class="form-group">
                <label class="control-label" for="input-project"><?php echo $entry_project; ?></label>
                <input type="text" name="filter_project" value="<?php echo $filter_project; ?>" placeholder="<?php echo $entry_project; ?>" id="input-project" class="form-control" />
                <input type="hidden" name="project_id" value="<?php echo $project_id; ?>" placeholder="<?php echo $entry_project; ?>" id="input-project" class="form-control" />
              </div>
              <div class="col-sm-12">
                <button type="button" id="button-filter" class="btn btn-primary pull-right"><i class="fa fa-search"></i> <?php echo $button_filter; ?></button>
              </div>
            </div>
            <?php if ($user_group_id == 1){?>
              <div class="col-sm-4">
                <div class="form-group">
                  <label class="control-label" for="input-project">User</label>
                  <input type="text" name="username" value="<?php echo $username; ?>" placeholder="User" id="input-username" class="form-control" />
                  <input type="hidden" name="user_id" placeholder="" id="input-user_id" class="form-control" />
                </div>
              </div>
            <?php }?>
          </div>
        </div>
        </div>
        <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form-project">
          <div class="table-responsive">
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <td style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td>
                  <td class="text-left"><?php if ($sort == 'name') { ?>
                  <a href="<?php echo $sort_name; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_project; ?></a>
                  <?php } else { ?>
                  <a href="<?php echo $sort_name; ?>"><?php echo $column_project; ?></a>
                  <?php } ?></td>
                  <?php if ($user_group_id == 1) { ?>
                    <td class="text-left">User</td>
                  <?php }?>
                  <td class="text-left"><?php echo $column_task;?></td>
                  <td class="text-left"><?php echo $column_status;?></td>
                  <td class="text-left"><?php echo $column_project_start_time;?></td>
                  <td class="text-left"><?php echo $column_project_end_time;?></td>
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
                  <td class="text-left"><?php echo $task['project']; ?></td>
                  <?php if ($user_group_id == 1) { ?>
                    <td class="text-left">
                        <?php echo $task['username']; ?>
                    </td>
                  <?php }?>
                  <td class="text-left"><?php echo $task['task']; ?></td>
                  <td class="text-left"><?php echo $task['status']; ?></td>
                  <td class="text-left"><?php echo $task['project_start_time']; ?></td>
                  <td class="text-left"><?php echo $task['project_end_time']; ?></td>
                  
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

  var project_id = $('input[name=\'project_id\']').val();

  if (project_id) {
    url += '&project_id=' + encodeURIComponent(project_id);
  }

  var user_id = $('input[name=\'user_id\']').val();

  if (user_id) {
    url += '&user_id=' + encodeURIComponent(user_id);
  }

  location = url;
});
//--></script>
<script type="text/javascript"><!--
$('input[name=\'filter_project\']').autocomplete({
  'source': function(request, response) {
    $.ajax({
      url: 'index.php?route=catalog/task/autocomplete&token=<?php echo $token; ?>&filter_project=' +  encodeURIComponent(request),
      dataType: 'json',
      success: function(json) {
        response($.map(json, function(item) {
          return {
            label: item['project_name'],
            value: item['project_id']
          }
        }));
      }
    });
  },
  'select': function(item) {
    $('input[name=\'filter_project\']').val(item['label']);
    $('input[name=\'project_id\']').val(item['value']);
  }
});
//--></script>
<script type="text/javascript"><!--
$('input[name=\'username\']').autocomplete({
  'source': function(request, response) {
    $.ajax({
      url: 'index.php?route=catalog/task/autocomplete2&token=<?php echo $token; ?>&username=' +  encodeURIComponent(request),
      dataType: 'json',
      success: function(json) {
        response($.map(json, function(item) {
          return {
            label: item['username'],
            value: item['user_id']
          }
        }));
      }
    });
  },
  'select': function(item) {
    $('input[name=\'username\']').val(item['label']);
    $('input[name=\'user_id\']').val(item['value']);
  }
});
//--></script>
<?php echo $footer; ?>