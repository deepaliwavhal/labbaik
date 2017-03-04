<div class="page-head">
    <h2 class="pull-left"><?= $page_title; ?> <span class="page-meta"><?= lang("enter_info"); ?></span> </h2>
</div>
<div class="clearfix"></div>
<div class="matter">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <!--<p class="introtext"><?= lang('list_results'); ?></p>-->
                <div class="row">
                    <div class="col-md-8 col-sm-8">
                        <ul id="myTab" class="nav nav-tabs">
                            <li class=""><a href="#credentials"><?= lang('new_user') ?></a></li>
                            <li class=""><a href="#activate_email"><?= lang('activate_email') ?></a></li>
                            <li class=""><a href="#forgot_password"><?= lang('forgot_password') ?></a></li>
                            <li class=""><a href="#new_password"><?= lang('reset_password') ?></a></li>
                        </ul>

                        <div class="tab-content">
                            <div id="credentials" class="tab-pane fade in">
                                <?= form_open('settings/email_templates'); ?>

                                <?php echo form_textarea('mail_body', (isset($_POST['mail_body']) ? html_entity_decode($_POST['mail_body']) : html_entity_decode($credentials)), 'class="form-control" id="credentials-ta"'); ?>
                                <div class="well" style="margin-top:5px;" id="credentials-pr"><?=$credentials;?></div>
                                <input type="submit" name="submit" class="btn btn-primary" value="<?= lang('save'); ?>"
                                style="margin-top:15px;"/>

                                <?php echo form_close(); ?>
                            </div>

                            <div id="activate_email" class="tab-pane fade">
                                <?= form_open('settings/email_templates/activate_email'); ?>

                                <?php echo form_textarea('mail_body', (isset($_POST['mail_body']) ? html_entity_decode($_POST['mail_body']) : html_entity_decode($activate_email)), 'class="form-control" id="activate_email-ta"'); ?>
                                <div class="well" style="margin-top:5px;" id="activate_email-pr"><?=$activate_email;?></div>
                                <input type="submit" name="submit" class="btn btn-primary" value="<?= lang('save'); ?>"
                                style="margin-top:15px;"/>

                                <?php echo form_close(); ?>
                            </div>

                            <div id="forgot_password" class="tab-pane fade">
                                <?= form_open('settings/email_templates/forgot_password'); ?>

                                <?php echo form_textarea('mail_body', (isset($_POST['mail_body']) ? html_entity_decode($_POST['mail_body']) : html_entity_decode($forgot_password)), 'class="form-control" id="forgot_password-ta"'); ?>
                                <div class="well" style="margin-top:5px;" id="forgot_password-pr"><?=$forgot_password;?></div>
                                <input type="submit" name="submit" class="btn btn-primary" value="<?= lang('save'); ?>"
                                style="margin-top:15px;"/>

                                <?php echo form_close(); ?>
                            </div>

                            <div id="new_password" class="tab-pane fade">
                                <?= form_open('settings/email_templates/new_password'); ?>

                                <?php echo form_textarea('mail_body', (isset($_POST['mail_body']) ? html_entity_decode($_POST['mail_body']) : html_entity_decode($new_password)), 'class="form-control" id="new_password-ta"'); ?>
                                <div class="well" style="margin-top:5px;" id="new_password-pr"><?=$new_password;?></div>
                                <input type="submit" name="submit" class="btn btn-primary" value="<?= lang('save'); ?>"
                                style="margin-top:15px;"/>

                                <?php echo form_close(); ?>
                            </div>

                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <div class="margin5">
                            <h3 style="font-weight: bold;"><?= $this->lang->line('short_tags'); ?></h3>
                            <pre>{logo} {site_name} {site_link}, {user_name} {email}</pre>
                            <?= lang('new_user') ?>, <?= lang('reset_password') ?>
                            <pre>{password} </pre>
                            <?= lang('forgot_password') ?>
                            <pre>{reset_password_link}</pre>
                            <?= lang('activate_email') ?>
                            <pre>{activation_link}</pre>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('#credentials-ta').bind('input propertychange', function(event) {
            $('#credentials-pr').html($(this).val());
        });
        $('#activate_email-ta').bind('input propertychange', function(event) {
            $('#activate_email-pr').html($(this).val());
        });
        $('#forgot_password-ta').bind('input propertychange', function(event) {
            $('#forgot_password-pr').html($(this).val());
        });
        $('#new_password-ta').bind('input propertychange', function(event) {
            $('#new_password-pr').html($(this).val());
        });
    });
</script>