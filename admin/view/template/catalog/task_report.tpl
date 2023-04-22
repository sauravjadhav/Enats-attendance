<?php echo $header; ?>
<?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
        <div class="container-fluid">
            <div class="pull-right"><a href="<?php echo $add; ?>" title="Export report" class="btn btn-primary">Export report</a>
            </div>
            <h1>Report</h1>
            <ul class="breadcrumb">
                <?php foreach ($breadcrumbs as $breadcrumb) { ?>
                <li><a href="<?php echo $breadcrumb['href']; ?>">Reports</a></li>
                <?php } ?>
            </ul>
        </div>
  </div>
  <div class="container-fluid">
    <div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title"><i class="fa fa-list"></i>Task Report</h3>
  </div>
  <div class="panel-body"></div>
  <div class="table-responsive">
    <table class="table table-bordered table-hover">
      <thead>
        <tr>
          <td class="text-left">Date</td>
          <td class="text-left">User</td>
          <td class="text-left">Project</td>
          <td class="text-left">Project Start Time</td>
          <td class="text-left">Project End Time</td>
          <td class="text-left">Task/problem</td>
          <td class="text-left">Status</td>
        </tr>
      </thead>
      <tbody>
        <?php if ($tasks) { ?>
        <?php foreach ($tasks as $task) {
        //echo "<pre>";print_r($tasks);exit; ?>
        <tr>
        <td class="text-left"><?php echo $task['date']; ?></td>
        <td class="text-left"><?php echo $task['username']; ?></td>
        <td class="text-left"><?php echo $task['project_name']; ?></td>
        <td class="text-left"><?php echo $task['project_start_time']; ?></td>
        <td class="text-left"><?php echo $task['project_end_time']; ?></td>
        <td class="text-left"><?php echo $task['task']; ?></td>
        <td class="text-left"><?php echo $task['status']; ?></td>
        </tr>
        <?php } ?>
        <?php } else { ?>
        <tr>
        <td class="text-center" colspan="7">No result</td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</div>
  </div>
</div>
