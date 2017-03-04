
<div class="page-head">
  <h2 class="pull-left"><?= $page_title; ?> <span class="page-meta"><?= lang("enter_info"); ?></span> </h2>
</div>
<div class="clearfix"></div>
<div class="matter">
  <div class="container">
    <?php $attrib = array('class' => 'form-horizontal'); echo form_open("settings/add_tax_rate");?>
    <div class="form-group">
      <label for="title"><?= lang("title"); ?></label>
      <div class="controls"> <?= form_input('name', '', 'id="title" class="form-control"');?> </div>
    </div>
    <div class="form-group">
      <label for="type"><?= lang("rate"); ?></label>
      <div class="controls controls-row"> <?= form_input('rate', '', 'class="form-control"'); ?> </div>
    </div>
    <div class="form-group">
      <label for="type"><?= lang("type"); ?></label>
      <div class="controls controls-row">
        <?php 
      $type = array ('' => lang("select").' '.lang("type"), '1' => lang("percenage").' (%)', '2' => lang("fixed").' ($)');
		echo form_dropdown('type', $type, '', 'class="form-control"'); ?>
      </div>
    </div>
    <div class="control-group">
      <div class="controls"> <?= form_submit('submit', lang("new_tax_rate"), 'class="btn btn-primary"');?> </div>
    </div>
    <?= form_close();?>
    <div class="clearfix"></div>
  </div>
  <div class="clearfix"></div>
</div>
