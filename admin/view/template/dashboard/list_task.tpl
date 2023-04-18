<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title"><i class="fa fa-list"></i>Task List</h3>
  </div>
  <div class="panel-body"></div>
  <div class="table-responsive">
    <table class="table table-bordered table-hover">
      <thead>
        <tr>
          <?php if ($user_group_id == 1) {?>
            <td class="text-left">User</td>
          <?php }?>
          <td class="text-left">Project</td>
          <td class="text-left">Project Start Time</td>
          <td class="text-left">Project End Time</td>
          <td class="text-left">Status</td>
        </tr>
      </thead>
      <tbody>
        <?php if ($tasks) { ?>
        <?php foreach ($tasks as $task) {
        //echo "<pre>";print_r($tasks);exit; ?>
        <tr>
        <?php if ($user_group_id == 1) {?>
          <td class="text-left"><?php echo $task['username']; ?></td>
        <?php }?>
        <td class="text-left"><?php echo $task['project_name']; ?></td>
        <td class="text-left"><?php echo $task['project_start_time']; ?></td>
        <td class="text-left"><?php echo $task['project_end_time']; ?></td>
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