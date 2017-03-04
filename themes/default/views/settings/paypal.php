    <script>
        $(document).ready(function(){
            $('#active').change(function(){
                var v = $(this).val();
                if(v == 1) {
                    $('#account_email').attr('required', 'required');
                } else {
                    $('#account_email').removeAttr('required');
                }
            });
            var v = <?=$paypal->active;?>;
            if(v == 1) {
                $('#account_email').attr('required', 'required');
            } else {
                $('#account_email').removeAttr('required');
            }
        });
    </script>
    
    <div class="page-head">
      <h2 class="pull-left"><?= $page_title; ?> <span class="page-meta"><?= lang("enter_info"); ?></span> </h2>
  </div>
  <div class="clearfix"></div>
  <div class="matter">
      <div class="container">

        <?php $attrib = array('role' => 'form', 'id="paypal_form"');
        echo form_open("settings/paypal", $attrib);
        ?>
        <div class="row">            
            <div class="col-md-6">
                <div class="form-group">
                    <?= lang("activate", "active"); ?>
                    <?php
                    $yn = array('1' => 'Yes', '0' => 'No');
                    echo form_dropdown('active', $yn, $paypal->active, 'class="form-control tip" required="required" id="active"');
                    ?>
                </div>

                <div class="form-group">
                    <?= lang("paypal_account_email", "account_email"); ?>
                    <?= form_input('account_email', $paypal->account_email, 'class="form-control tip" id="account_email"'); ?>
                    <small class="help-block"><?=lang("account_email_tip");?></small>
                </div>

                <div class="form-group">
                    <?= lang("fixed_charges", "fixed_charges"); ?>
                    <?= form_input('fixed_charges', $paypal->fixed_charges, 'class="form-control tip" id="fixed_charges"'); ?>
                    <small class="help-block"><?=lang("fixed_charges_tip");?></small>
                </div>
                <div class="form-group">
                    <?= lang("extra_charges_my", "extra_charges_my"); ?>
                    <?= form_input('extra_charges_my', $paypal->extra_charges_my, 'class="form-control tip" id="extra_charges_my"'); ?>
                    <small class="help-block"><?=lang("extra_charges_my_tip");?></small>
                </div>
                <div class="form-group">
                    <?= lang("extra_charges_others", "extra_charges_other"); ?>
                    <?= form_input('extra_charges_other', $paypal->extra_charges_other, 'class="form-control tip" id="extra_charges"'); ?>
                    <small class="help-block"><?=lang("extra_charges_others_tip");?></small>
                </div>
                        <!--<div class="form-group">
                            <label><?= lang("ipn_link"); ?></label>
                            <span class="form-control" id="ipn_link"><?=site_url('paypalipn');?></span>
                            <small class="help-block"><?=lang("ipn_link_tip");?></small>
                        </div>-->
                    </div>
                </div>
                <div style="clear: both; height: 10px;"></div>
                <div class="form-group">
                    <?= form_submit('update_settings', lang("update_settings"), 'class="btn btn-primary"'); ?> 
                </div>
            </div>
            <?= form_close(); ?> 
        </div>                         
