
<div class="page-head">
    <h2 class="pull-left"><?= $page_title; ?> <span class="page-meta"><?= lang("enter_info"); ?></span> </h2>
</div>
<div class="clearfix"></div>
<div class="matter">
    <div class="container">

        <?php $attrib = array('class' => 'form-horizontal'); echo form_open("customers/add");?>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="company"><?= lang("company"); ?></label>
                    <div class="controls"> <?= form_input('company', '', 'class="form-control" id="company"');?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="name"><?= lang("contact_person"); ?></label>
                    <div class="controls"> <?= form_input('name', '', 'class="form-control" id="name"');?>
                    </div>
                </div> 
                <div class="form-group">
                    <label for="email_address"><?= lang("email_address"); ?></label>
                    <div class="controls"> <?= form_input('email', '', 'class="form-control" id="email_address"');?>
                    </div>
                </div> 
                <div class="form-group">
                    <label for="phone"><?= lang("phone"); ?></label>
                    <div class="controls"> <?= form_input('phone', '', 'class="form-control" id="phone"');?>
                    </div>
                </div> 
                <div class="form-group">
                    <label for="address"><?= lang("address"); ?></label>
                    <div class="controls"> <?= form_input('address', '', 'class="form-control" id="address"');?>
                    </div>
                </div>  
                <div class="form-group">
                    <label for="city"><?= lang("city"); ?></label>
                    <div class="controls"> <?= form_input('city', '', 'class="form-control" id="city"');?>
                    </div>
                </div> 
                <div class="form-group">
                    <label for="state"><?= lang("state"); ?></label>
                    <div class="controls"> <?= form_input('state', '', 'class="form-control" id="state"');?>
                    </div>
                </div> 
                <div class="form-group">
                    <label for="postal_code"><?= lang("postal_code"); ?></label>
                    <div class="controls"> <?= form_input('postal_code', '', 'class="form-control" id="postal_code"');?>
                    </div>
                </div> 
                <div class="form-group">
                    <label for="country"><?= lang("country"); ?></label>
                    <div class="controls"> <?= form_input('country', '', 'class="form-control" id="country"');?>
                    </div>
                </div> 
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="cf1"><?= lang("ccf1"); ?></label>
                    <div class="controls"> <?= form_input('cf1', '', 'class="form-control" id="cf1"');?>
                    </div>
                </div> 
                <div class="form-group">
                    <label for="cf2"><?= lang("ccf2"); ?></label>
                    <div class="controls"> <?= form_input('cf2', '', 'class="form-control" id="cf2"');?>
                    </div>
                </div> 
                <div class="form-group">
                    <label for="cf3"><?= lang("ccf3"); ?></label>
                    <div class="controls"> <?= form_input('cf3', '', 'class="form-control" id="cf3"');?>
                    </div>
                </div> 
                <div class="form-group">
                    <label for="cf4"><?= lang("ccf4"); ?></label>
                    <div class="controls"> <?= form_input('cf4', '', 'class="form-control" id="cf4"');?>
                    </div>
                </div> 
                <div class="form-group">
                    <label for="cf5"><?= lang("ccf5"); ?></label>
                    <div class="controls"> <?= form_input('cf5', '', 'class="form-control" id="cf5"');?>
                    </div>
                </div> 
                <div class="form-group">
                    <label for="cf6"><?= lang("ccf6"); ?></label>
                    <div class="controls"> <?= form_input('cf6', '', 'class="form-control" id="cf6"');?>
                    </div>
                </div> 
            </div>
        </div>
        <div class="form-group">
            <div class="controls"> <?= form_submit('submit', lang("add_customer"), 'class="btn btn-primary"');?> </div>
        </div>
        <?= form_close();?> 

        <div class="clearfix"></div>
    </div>
    <div class="clearfix"></div>
</div>
