<link href="<?= $assets; ?>/css/bootstrap-fileupload.css" rel="stylesheet">

<?php if($message) { echo "<div class=\"alert alert-error\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $message . "</div>"; } ?>
<?php if($success_message) { echo "<div class=\"alert alert-success\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $success_message . "</div>"; } ?>

<div class="page-head">
  <h2 class="pull-left"><?= $page_title; ?> <span class="page-meta"><?= lang("enter_info"); ?></span> </h2>
</div>
<div class="clearfix"></div>
<div class="matter">
  <div class="container">
    <?php $attrib = array('class' => 'form-horizontal'); echo form_open_multipart("settings/change_logo");?>
    <div class="fprm-group">
      <label class="control-label" for="copy"><?= lang("upload_logo"); ?></label>
      <div class="controls">
        <div class="fileupload fileupload-new" data-provides="fileupload">
          <div class="input-append">
            <div class="uneditable-input span2"><i class="icon-file fileupload-exists"></i> <span class="fileupload-preview"></span></div>
            <span class="btn btn-file btn-info"><span class="fileupload-new"><?= lang("select_file"); ?></span><span class="fileupload-exists"><?= lang("change"); ?></span>
            <input type="file" name="logo" />
            </span><a href="#" class="btn fileupload-exists" data-dismiss="fileupload"><?= lang("remove"); ?></a> </div>
        </div>
        <span class="help-block"><?= lang("site_logo_tip"); ?></span> </div>
    </div>
    <div class="control-group">
      <div class="controls"> <?= form_submit('submit', lang("upload_logo"), 'class="btn btn-primary"');?> </div>
    </div>
    <?= form_close();?>
    <div class="clearfix"></div>
  </div>
  <div class="clearfix"></div>
</div>
