 <?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <?php if ($user_group_id == 1) {?>
          <a href="<?php echo $add; ?>" data-toggle="tooltip" title="<?php echo $button_add; ?>" class="btn btn-primary"><i class="fa fa-plus"></i></a>
          <button type="button" data-toggle="tooltip" title="<?php echo $button_delete; ?>" class="btn btn-danger" onclick="confirm('<?php echo $text_confirm; ?>') ? $('#form-employee').submit() : false;"><i class="fa fa-trash-o"></i></button>
        <?php }?>
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
        <?php if ($user_group_id == 1) {?>
          <div class="well">
          <div class="row">
            <div class="col-sm-4">
              <div class="form-group">
                <label class="control-label" for="input-name"><?php echo $entry_name; ?></label>
                <input type="text" name="filter_name" value="<?php echo $filter_name; ?>" placeholder="<?php echo $entry_name; ?>" id="input-name" class="form-control" />
              </div>
            </div>
            <div class="col-sm-4">
              <div class="form-group">
                <label class="control-label" for="input-model"><?php echo $entry_numbers; ?></label>
                <input type="text" name="filter_numbers" value="<?php echo $filter_numbers; ?>" placeholder="<?php echo $entry_numbers; ?>" id="input-model" class="form-control" />
              </div>
            </div>
            <div class="col-sm-4">
              <div class="form-group">
                <label class="control-label" for="input-price"><?php echo $entry_email; ?></label>
                <input type="text" name="filter_email" value="<?php echo $filter_email; ?>" placeholder="<?php echo $entry_email; ?>" id="input-price" class="form-control" />
              </div>
            </div>
             <div class="col-sm-12">
              <button type="button" id="button-filter" class="btn btn-primary pull-right"><i class="fa fa-search"></i> <?php echo $button_filter; ?></button>
            </div>
          </div>
        </div>
      <?php }?>
        <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form-employee">
          <div class="table-responsive">
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <td style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td>
                  <td class="text-left"><?php if ($sort == 'name') { ?>
                  <a href="<?php echo $sort_name; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_name; ?></a>
                  <?php } else { ?>
                  <a href="<?php echo $sort_name; ?>"><?php echo $column_name; ?></a>
                  <?php } ?></td>
                  <td class="text-left"><?php echo $column_email; ?></td>
                  <td class="text-left"><?php echo $column_numbers; ?></td>
                  <td class="text-left"><?php echo $column_address; ?></td>
                  <td class="text-right"><?php echo $column_action; ?></td>
                </tr>
              </thead>
            <tbody>
              <?php if ($employees) { ?>
              <?php foreach ($employees as $employee) {
              // echo "<pre>";print_r($manufacturers);exit; ?>
              <tr>
              <td class="text-center"><?php if (in_array($employee['employee_id'], $selected)) { ?>
              <input type="checkbox" name="selected[]" value="<?php echo $employee['employee_id']; ?>" checked="checked" />
              <?php } else { ?>
              <input type="checkbox" name="selected[]" value="<?php echo $employee['employee_id']; ?>" />
              <?php } ?></td>
              <td class="text-left"><?php echo $employee['name']; ?></td>
              <td class="text-left"><?php echo $employee['email']; ?></td>
              <td class="text-left"><?php echo $employee['numbers']; ?></td>
              <td class="text-left"><?php echo $employee['address']; ?></td>
              <td class="text-right"><a href="<?php echo $employee['edit']; ?>" data-toggle="tooltip" title="<?php echo $button_edit; ?>" class="btn btn-primary"><i class="fa fa-pencil"></i></a></td>
              </tr>
              <?php } ?>
              <?php } else { ?>
              <tr>
              <td class="text-center" colspan="7"><?php echo $text_no_results; ?></td>
              </tr>
              <?php } ?>
            </tbody>
          </div>
        </table>
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
  // console.log(url);

  var url = 'index.php?route=catalog/employee&token=<?php echo $token; ?>';

  var filter_name = $('input[name=\'filter_name\']').val();

  if (filter_name) {
    url += '&filter_name=' + encodeURIComponent(filter_name);
  }

  var filter_numbers = $('input[name=\'filter_numbers\']').val();

  if (filter_numbers) {
    url += '&filter_numbers=' + encodeURIComponent(filter_numbers);
  }

  var filter_email = $('input[name=\'filter_email\']').val();

  if (filter_email) {
    url += '&filter_email=' + encodeURIComponent(filter_email);
  }

  location = url;
});  
</script>
<script type="text/javascript"><!--
$('input[name=\'filter_name\']').autocomplete({
  'source': function(request, response) {
    $.ajax({
      url: 'index.php?route=catalog/employee/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
      dataType: 'json',
      success: function(json) {
        response($.map(json, function(item) {
          return {
            label: item['name'],
            value: item['employee_id']
          }
        }));
      }
    });
  },
  'select': function(item) {
    $('input[name=\'filter_name\']').val(item['label']);
  }
});
--></script>
<script type="text/javascript"><!--
$('input[name=\'filter_numbers\']').autocomplete({
  'source': function(request, response) {
    // console.log(request);
    $.ajax({
      url: 'index.php?route=catalog/employee/autocomplete1&token=<?php echo $token; ?>&filter_numbers=' +  encodeURIComponent(request),
      dataType: 'json',
      success: function(json) {
        response($.map(json, function(item) {
          return {
            label: item['numbers'],
            value: item['employee_id']
          }
        }));
      }
    });
  },
  'select': function(item) {
    $('input[name=\'filter_numbers\']').val(item['label']);
  }
});
--></script>
<script type="text/javascript"><!--
$('input[name=\'filter_email\']').autocomplete({
  'source': function(request, response) {
    // console.log(request);
    $.ajax({
      url: 'index.php?route=catalog/employee/autocomplete2&token=<?php echo $token; ?>&filter_email=' +  encodeURIComponent(request),
      dataType: 'json',
      success: function(json) {
        response($.map(json, function(item) {
          console.log(response);
          return {
            label: item['email'],
            value: item['employee_id']
          }
        }));
      }
    });
  },
  'select': function(item) {
    $('input[name=\'filter_email\']').val(item['label']);
  }
});
--></script>

<?php echo $footer; ?> -->