<script src="<?= $assets; ?>/js/bootstrap-fileupload.js"></script>
<link href="<?= $assets; ?>/style/bootstrap-fileupload.css" rel="stylesheet">
    <?php if($message) { echo "<div class=\"alert alert-danger\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $message . "</div>"; } ?>

<div class="page-head">
  <h2 class="pull-left"><?= $page_title; ?> <span class="page-meta"><?= lang("enter_info"); ?></span> </h2>
</div>
<div class="clearfix"></div>
<div class="matter">
  <div class="container">
    <div class="well well-small"> <a href="<?= base_url(); ?>uploads/sample_customers.csv" class="btn btn-info pull-right"><i class="icon-download icon-white"></i> Download Sample File</a> <span class="text-info">You can import maximum 999 customer with single csv file.</span><br /><span class="text-warning"><?= lang("csv1"); ?></span><br />
      <?= lang("csv2"); ?> <span class="text-info">(<?= lang("company"); ?>, <?= lang("contact_person"); ?>, <?= lang("email"); ?>, <?= lang("phone"); ?>, <?= lang("address"); ?>, <?= lang("city"); ?>, <?= lang("state"); ?>, <?= lang("postal_code"); ?>, <?= lang("country"); ?>, <?= lang("ccf1"); ?>, <?= lang("ccf2"); ?>, <?= lang("ccf3"); ?>, <?= lang("ccf4"); ?>, <?= lang("ccf5"); ?>, <?= lang("ccf6"); ?>)</span> <?= lang("csv3"); ?> </div>
    <?php $attrib = array('class' => 'form-horizontal'); echo form_open_multipart("customers/import", $attrib); ?>
    <div class="control-group">
      <label class="control-label" for="csv_file"><?= lang("upload_file"); ?></label>
      <div class="controls">
        <div class="fileupload fileupload-new" data-provides="fileupload"> <span class="btn btn-file btn-info"><span class="fileupload-new"><?= lang("select_file"); ?></span><span class="fileupload-exists"><?= lang("change"); ?></span>
          <input type="file" name="userfile" id="csv_file" onchange="checkfile(this);" required="required" data-error="<?= lang("select_file")." ".lang("is_required"); ?>" />
          </span> <span class="fileupload-preview"></span> <a href="#" class="close fileupload-exists" data-dismiss="fileupload" style="float: none">×</a> </div>
      </div>
    </div>
    <div class="control-group">
      <div class="controls"> <?= form_submit('submit', lang("submit"), 'class="btn btn-primary"');?> </div>
    </div>
    <?= form_close();?>
    <div class="clearfix"></div>
  </div>
  <div class="clearfix"></div>
</div>
