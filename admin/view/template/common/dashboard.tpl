<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <?php if ($user_group_id == 1) {?>
      <div class="col-lg-12 col-md-9 col-sm-9"><?php echo $list_attendance; ?></div>
      <div class="col-lg-12 col-md-9 col-sm-9"><?php echo $list_task; ?></div>
    <?php } elseif($user_group_id == 11) {?>
      <div class="col-lg-12 col-md-9 col-sm-9"><?php echo $list_task; ?></div>
      <div class="col-lg-12 col-md-9 col-sm-9"><?php echo $list_attendance; ?></div>
    <?php } else {?>
      <div class="col-lg-12 col-md-9 col-sm-9"><?php echo $list_task; ?></div>
    <?php }?>
  </div>
</div>
<?php echo $footer; ?>