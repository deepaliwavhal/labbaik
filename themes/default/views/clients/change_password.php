
<div class="page-head">
    <h2><?= $page_title; ?></h2>
    <span class="page-meta"><?= lang("enter_info"); ?></span> 
</div>
<div class="clearfix"></div>
<div class="matter">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <?php $attrib = array('class' => 'form-horizontal'); echo form_open("auth/change_password");?>
                <div class="form-group">
                    <label for="old_password"><?= lang("old_pw"); ?></label>
                    <div class="controls"> <?= form_input($old_password , '', 'class="form-control" id="old_password"');?> </div>
                </div>
                <div class="form-group">
                    <label for="new_password"><?= lang("new_pw"); ?></label>
                    <div class="controls"> <?= form_input($new_password , '', 'class="form-control" id="new_password"');?> </div>
                </div>
                <div class="form-group">
                    <label for="new_password_confirm"><?= lang("confirm_pw"); ?></label>
                    <div class="controls"> <?= form_input($new_password_confirm , '', 'class="form-control" id="new_password_confirm"');?> </div>
                </div>
                <?= form_input($user_id);?>
                <div class="form-group">
                    <div class="controls"> <?= form_submit('submit', lang("change_password"), 'class="btn btn-primary"');?> </div>
                </div>
                <?= form_close();?> 
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="clearfix"></div>
</div>
