<?php echo $header; ?>
<?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
        <div class="container-fluid">
            <div class="pull-right">
              <a href="<?php echo $export; ?>" title="Export report" class="btn btn-primary"><i class="fa fa-download"></i> Export report</a>
            </div>
            <div class="pull-right" style="margin-right: 4px;">
              <a href="<?php echo $archive; ?>" title="Export report" class="btn btn-danger"><i class="fa fa-archive"></i> Archive report</a>
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
        <h3 class="panel-title"><i class="fa fa-list"></i>Attendance Report</h3>
      </div>
      <div class="panel-body"></div>
      <div class="table-responsive">
        <table class="table table-bordered table-hover">
          <thead>
            <tr>
              <td class="text-left">Name</td>
              <?php foreach ($attendances_header as $header) { ?>
                <td class="text-left"><?php echo $header['date'] ?></td>
              <?php }?>
            </tr>
          </thead>
          <tbody>
            <?php if ($attendances_body) { ?>
              <?php foreach ($username as $user) { ?>
                <tr>
                  <td class="text-left"><?php echo $user['name']; ?></td>
                  <?php foreach ($attendances_header as $header) { ?>
                    <?php $found = false; ?>
                    <?php foreach ($attendances_body as $body) { ?>
                      <?php if ($body['user_id'] == $user['user_id'] && $body['date'] == $header['date']) { ?>
                        <td class="text-left <?php if (date('H:i', strtotime($body['office_in_time'])) > '10:00:00') echo 'text-danger'; ?>"><?php echo $body['office_in_time']; $found = true; break; ?></td>
                      <?php } ?>
                    <?php } ?>
                    <?php if (!$found) { ?>
                      <td class="text-left"></td>
                    <?php } ?>
                  <?php } ?>
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
