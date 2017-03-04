<div class="page-head">
  <h2 class="pull-left"><?= $page_title; ?> <span class="page-meta"><?= lang("enter_info"); ?></span> </h2>
</div>
<div class="clearfix"></div>
<div class="matter">
  <div class="container">

   	<?php $attrib = array('class' => 'form-horizontal'); echo form_open("products/add");?>

<div class="form-group">
  <label for="name"><?= lang("name"); ?></label>
  <div class="controls"> <?= form_input('name', '', 'class="form-control" id="name" maxlength="80"');?>
  </div>
</div> 
<div class="form-group">
  <label for="details"><?= lang("details"); ?></label>
  <div class="controls"> <?= form_textarea('details', '', 'class="form-control" id="details" maxlength="255" style="height:60px;"');?>
  </div>
</div> 
<div class="form-group">
  <label for="price"><?= lang("price"); ?></label>
  <div class="controls"> <?= form_input('price', '', 'class="form-control" id="price"');?>
  </div>
</div> 
<?php if($Settings->default_tax_rate) { ?>
<div class="form-group">
      <label for="tax_rate"><?= lang("tax_rate"); ?></label>
      <div class="controls">
        <?php 
	  foreach($tax_rates as $rate){
    		$tr[$rate->id] = $rate->name;
		}
		
		echo form_dropdown('tax_rate', $tr, $Settings->default_tax_rate, 'class="form-control" id"tax_rate"'); ?>
      </div>
    </div>
    <?php } ?>

<div class="form-group">
  <div class="controls"> <?= form_submit('submit', lang("add_product"), 'class="btn btn-primary"');?> </div>
</div>
<?= form_close();?> 
   
   <div class="clearfix"></div>
  </div>
  <div class="clearfix"></div>
</div>
