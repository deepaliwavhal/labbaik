
<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-2x">&times;</i></button>
            <h4 class="modal-title" id="myModalLabel"><?= lang('add_user')." (".$company->name.")"; ?></h4>
        </div>
        <?php $attrib = array('data-toggle' => 'validator', 'role' => 'form');
        echo form_open("customers/add_user?id=".$company->id, $attrib); ?>
        <div class="modal-body">
            <p><?= lang('enter_info'); ?></p>

            <div class="row">

                <div class="col-md-6 col-sm-6">
                    <div class="form-group">
                        <?= lang('first_name', 'first_name'); ?> 
                        <div class="controls">
                            <?= form_input('first_name', '', 'class="form-control" id="first_name" required="required" pattern=".{3,10}"'); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <?= lang('last_name', 'last_name'); ?>
                        <div class="controls">
                            <?= form_input('last_name', '', 'class="form-control" id="last_name" required="required"'); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <?= lang('phone', 'phone'); ?>
                        <div class="controls">
                            <?= form_input('phone', '', 'class="form-control" id="phone"'); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <?= lang('email', 'email'); ?> 
                        <div class="controls">
                            <input type="email" id="email" name="email" class="form-control" required="required" />
                            <?php /* echo form_input('email', '', 'class="form-control" id="email" required="required"'); */ ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6">
                    <div class="form-group">
                        <?= lang('pw', 'password'); ?> 
                        <div class="controls">
                            <?= form_password('password', '', 'class="form-control tip" id="password" required="required"'); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <?= lang('confirm_password', 'password_confirm'); ?>
                        <div class="controls">
                            <?= form_password('password_confirm', '', 'class="form-control" id="password_confirm" required="required"'); ?>
                        </div>
                    </div>
                    <div class="clearfix"></div>

                </div>
            </div>

        </div>
        <div class="modal-footer">
            <?= form_submit('add_user', lang('add_user'), 'class="btn btn-primary"'); ?>
        </div>
    </div>
    <?= form_close(); ?>  
</div>


