<!-- Errors -->
<?php if($message) { echo "<div class=\"alert alert-error\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $message . "</div>"; } ?>

<div class="page-head">
  <h2 class="pull-left"><?= $page_title; ?> <span class="page-meta"><?= lang("enter_user_info"); ?></span> </h2>
</div>
<div class="clearfix"></div>
<div class="matter">
  <div class="container">
    <?php $attrib = array('class' => 'form-horizontal'); echo form_open("auth/create_user");?>
    <div class="form-group">
      <label for="first_name"><?= lang("first_name"); ?></label>
      <div class="controls"> <?= form_input($first_name, '', 'class="form-control"');?> </div>
    </div>
    <div class="form-group">
      <label for="last_name"><?= lang("last_name"); ?></label>
      <div class="controls"> <?= form_input($last_name, '', 'class="form-control"');?> </div>
    </div>
    <div class="form-group">
      <label for="company"><?= lang("company"); ?></label>
      <div class="controls"> <?= form_input($company, '', 'class="form-control"');?> </div>
    </div>
    <div class="form-group">
      <label for="phone"><?= lang("phone"); ?></label>
      <div class="controls"> <?= form_input($phone, '', 'class="form-control"');?> </div>
    </div>
    <div class="form-group">
      <label for="email"><?= lang("email_address"); ?></label>
      <div class="controls"> <?= form_input($email, '', 'class="form-control"');?> </div>
    </div>
    <div class="form-group">
      <label><?= lang("user_role"); ?></label>
      <div class="controls">
        <label class="radio">
          <input type="radio" name="role" id="optionsRadios1" value="1" <?php if(isset($_POST['submit']) && ($_POST['role'] == '1')) { echo "checked=\"yes\""; } ?>>
          <?= lang("admin_role"); ?> </label>
        <label class="radio">
          <input type="radio" name="role" id="optionsRadios2" value="2" <?php if(isset($_POST['submit']) && ($_POST['role'] == '2')) { echo "checked=\"yes\""; } ?>>
          <?= lang("sales_role"); ?> </label>
        <label class="radio">
          <input type="radio" name="role" id="optionsRadios3" value="3" <?php if(isset($_POST['submit']) && ($_POST['role'] == '3')) { echo "checked=\"yes\""; } ?>>
          <?= lang("viewer_role"); ?> </label>
      </div>
    </div>
    <div class="form-group">
      <label for="password"><?= lang("pw"); ?></label>
      <div class="controls"> <?= form_input($password , '', 'class="form-control" id="password"');?> </div>
    </div>
    <div class="form-group">
      <label for="confirm_pw"><?= lang("confirm_pw"); ?></label>
      <div class="controls"> <?= form_input($password_confirm , '', 'class="form-control" id="confirm_pw"');?> </div>
    </div>
    <div class="form-group">
      <div class="controls"> <?= form_submit('submit', lang("add_user"), 'class="btn btn-primary"');?> </div>
    </div>
    <?= form_close();?>
    <div class="clearfix"></div>
  </div>
  <div class="clearfix"></div>
</div>
