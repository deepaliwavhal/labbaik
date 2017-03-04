
<div class="page-head">
  <h2 class="pull-left"><?= $page_title; ?> <span class="page-meta"><?= lang("update_info"); ?></span> </h2>
</div>
<div class="clearfix"></div>
<div class="matter">
  <div class="container">
    <?php $attrib = array('class' => 'form-horizontal'); echo form_open("settings/edit_tax_rate?id=".$id);?>
    <div class="form-group"> <labelfor="title"><?= lang("title"); ?>
      </label>
      <div class="controls"> <?= form_input('name', $tax_rate->name, 'id="title" class="form-control"');?> </div>
    </div>
    <div class="form-group">
      <label for="type"><?= lang("rate"); ?></label>
      <div class="controls controls-row"> <?= form_input('rate', $tax_rate->rate, 'class="form-control"'); ?> </div>
    </div>
    <div class="form-group">
      <label for="type"><?= lang("type"); ?></label>
      <div class="controls controls-row">
        <?php 
      $type = array ('' => lang("select").' '.lang("type"), '1' => lang("percenage").' (%)', '2' => lang("fixed").' ($)');
		echo form_dropdown('type', $type, $tax_rate->type, 'class="form-control"'); ?>
      </div>
    </div>
    <div class="control-group">
      <div class="controls"> <?= form_submit('submit', lang("update_tax_rate"), 'class="btn btn-primary"');?> </div>
    </div>
    <?= form_close();?>
    <div class="clearfix"></div>
  </div>
  <div class="clearfix"></div>
</div>
