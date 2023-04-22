<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title"><i class="fa fa-list"></i>Task List</h3>
  </div>
  <div class="panel-body"></div>
  <div class="table-responsive">
    <table class="table table-bordered table-hover">
      <thead>
        <tr>
          <td class="text-left">Date</td>
          <?php if ($user_group_id == 1) {?>
            <td class="text-left">User</td>
          <?php }?>
          <td class="text-left">Project</td>
          <td class="text-left">Task/problem</td>
          <td class="text-left">Remark/Instruction</td>
          <td class="text-left">Status</td>
          <td class="text-center">Action</td>
        </tr>
      </thead>
      <tbody>
        <?php if ($tasks) { ?>
        <?php foreach ($tasks as $task) {
        //echo "<pre>";print_r($tasks);exit; ?>
        <tr>
        <td class="text-left"><?php echo $task['date']; ?></td>
        <?php if ($user_group_id == 1) {?>
          <td class="text-left"><?php echo $task['username']; ?></td>
        <?php }?>
        <td class="text-left"><?php echo $task['project_name']; ?></td>
        <td class="text-left"><?php echo $task['task']; ?></td>
        <td class="text-left"><?php echo $task['remark']; ?></td>
        <td class="text-left"><?php echo $task['status']; ?></td>
        <td class="text-center"><a href="<?php echo $task['edit']; ?>" data-toggle="tooltip" title="Edit Task" class="btn btn-primary"><i class="fa fa-pencil"></i></a></td>
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