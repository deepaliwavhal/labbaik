    <script>
        $(document).ready(function(){
            $('#active').change(function(){
                var v = $(this).val();
                if(v == 1) {
                    $('#secret_key').attr('required', 'required');
                    $('#publishable_key').attr('required', 'required');
                } else {
                    $('#secret_key').removeAttr('required');
                    $('#publishable_key').removeAttr('required');
                }
            });
            var v = <?=$stripe->active;?>;
            if(v == 1) {
                $('#secret_key').attr('required', 'required');
                $('#publishable_key').attr('required', 'required');
            } else {
                $('#secret_key').removeAttr('required');
                $('#publishable_key').removeAttr('required');
            }
        });
    </script>
    
    <div class="page-head">
      <h2 class="pull-left"><?= $page_title; ?> <span class="page-meta"><?= lang("enter_info"); ?></span> </h2>
  </div>
  <div class="clearfix"></div>
  <div class="matter">
      <div class="container">

        <?php $attrib = array('role' => 'form', 'id="stripe_form"');
        echo form_open("settings/stripe", $attrib);
        ?>
        <div class="row">            
            <div class="col-md-6">
                <div class="form-group">
                    <?= lang("activate", "active"); ?>
                    <?php
                    $yn = array('1' => 'Yes', '0' => 'No');
                    echo form_dropdown('active', $yn, $stripe->active, 'class="form-control tip" required="required" id="active"');
                    ?>
                </div>

                <div class="form-group">
                    <?= lang("secret_key", "secret_key"); ?>
                    <?= form_input('secret_key', $stripe->secret_key, 'class="form-control tip" id="secret_key"'); ?>
                </div>
                <div class="form-group">
                    <?= lang("publishable_key", "publishable_key"); ?>
                    <?= form_input('publishable_key', $stripe->publishable_key, 'class="form-control tip" id="publishable_key"'); ?>
                </div>

                <div class="form-group">
                    <?= lang("fixed_charges", "fixed_charges"); ?>
                    <?= form_input('fixed_charges', $stripe->fixed_charges, 'class="form-control tip" id="fixed_charges"'); ?>
                    <small class="help-block"><?=lang("fixed_charges_tip");?></small>
                </div>
                <div class="form-group">
                    <?= lang("extra_charges_my", "extra_charges_my"); ?>
                    <?= form_input('extra_charges_my', $stripe->extra_charges_my, 'class="form-control tip" id="extra_charges_my"'); ?>
                    <small class="help-block"><?=lang("extra_charges_my_tip");?></small>
                </div>
                <div class="form-group">
                    <?= lang("extra_charges_others", "extra_charges_other"); ?>
                    <?= form_input('extra_charges_other', $stripe->extra_charges_other, 'class="form-control tip" id="extra_charges"'); ?>
                    <small class="help-block"><?=lang("extra_charges_others_tip");?></small>
                </div>

            </div>
        </div>
        <div style="clear: both; height: 10px;"></div>
        <div class="form-group">
            <?= form_submit('update_settings', lang("update_settings"), 'class="btn btn-primary"'); ?> 
        </div>
    </div>
    <?= form_close(); ?> 
</div>                         
