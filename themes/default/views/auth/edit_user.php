
<div class="page-head">
  <h2 class="pull-left"><?= $page_title; ?> <span class="page-meta"><?= lang("update_user_info"); ?></span> </h2>
</div>
<div class="clearfix"></div>
<div class="matter">
  <div class="container">
<?php $first_name = array(
              'name'        => 'first_name',
              'id'          => 'first_name',
			  'placeholder' => "First Name",
              'value'       => $user->first_name,
              'class'       => 'form-control'
            );
			$last_name = array(
              'name'        => 'last_name',
              'id'          => 'last_name',
              'value'       => $user->last_name,
              'class'       => 'form-control'
            );
			$company = array(
              'name'     => 'company',
              'id'          => 'company',
              'value'       => $user->company,
              'class'       => 'form-control',
            );
			$phone = array(
              'name'        => 'phone',
              'id'          => 'phone',
              'value'       => $user->phone,
              'class'       => 'form-control',
            );
			$email = array(
              'name'        => 'email',
              'id'          => 'email',
              'value'       => $user->email,
              'class'       => 'form-control',
            );
			
	?>
<?php $attrib = array('class' => 'form-horizontal'); echo form_open("auth/edit_user?id=".$id."&customer=".$customer);?>
<div class="form-group">
  <label for="first_name"><?= lang("first_name"); ?></label>
  <div class="controls"> <?= form_input($first_name);?> </div>
</div>
<div class="form-group">
  <label for="last_name"><?= lang("last_name"); ?></label>
  <div class="controls"> <?= form_input($last_name);?> </div>
</div>
<?php if($group->group_id != 4) { ?>
<div class="form-group">
  <label for="company"><?= lang("company"); ?></label>
  <div class="controls"> <?= form_input($company);?> </div>
</div>
<?php } else { echo form_hidden('company', $user->company); } ?>      
<div class="form-group">
  <label for="phone"><?= lang("phone"); ?></label>
  <div class="controls"> <?= form_input($phone);?> </div>
</div>
<div class="form-group">
  <label for="email"><?= lang("email_address"); ?></label>
  <div class="controls"> <?= form_input($email);?> </div>
</div>
<?php if($group->group_id != 4) { ?>
<div class="form-group">
  <label for="phone"><?= lang("user_role"); ?></label>
  <div class="controls"> 
<label class="radio">
        <input type="radio" name="role" id="optionsRadios1" value="1" <?php if($group->group_id == '1') { echo "checked=\"yes\""; } if(isset($_POST['submit']) && ($_POST['role'] == '1')) { echo "checked=\"yes\""; } ?>>
        <?= lang("admin_role"); ?> </label>
      <label class="radio">
        <input type="radio" name="role" id="optionsRadios2" value="2" <?php if($group->group_id == '2') { echo "checked=\"yes\""; } if(isset($_POST['submit']) && ($_POST['role'] == '2')) { echo "checked=\"yes\""; } ?>>
        <?= lang("sales_role"); ?> </label>
      <label class="radio">
        <input type="radio" name="role" id="optionsRadios3" value="3" <?php if($group->group_id == '3') { echo "checked=\"yes\""; } if(isset($_POST['submit']) && ($_POST['role'] == '3')) { echo "checked=\"yes\""; } ?>>
        <?= lang("viewer_role"); ?> </label>
  </div>
</div>  
<?php } else { echo form_hidden('role', '4'); } ?>      
<div class="form-group">
  <label for="password"><?= lang("pw"); ?></label>
  <div class="controls"> <?= form_input($password , '', 'class="form-control" id="password" placeholder="Optional"');?> </div>
</div>
<div class="form-group">
  <label for="confirm_pw"><?= lang("confirm_pw"); ?></label>
  <div class="controls"> <?= form_input($password_confirm , '', 'class="form-control" id="confirm_pw" placeholder="Optional"');?> </div>
</div>
<div class="form-group">
  <div class="controls"> <?= form_submit('submit', lang("update_user"), 'class="btn btn-primary"');?> </div>
</div>
<?= form_close();?>

<div class="clearfix"></div>
  </div>
  <div class="clearfix"></div>
</div>
