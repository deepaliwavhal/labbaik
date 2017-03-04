<?php $name = array(
  'name'        => 'name',
  'id'          => 'name',
  'value'       => $details->name,
  'class'       => 'form-control',
  );
$email = array(
  'name'        => 'email',
  'id'          => 'email',
  'value'       => $details->email,
  'class'       => 'form-control',
  );
$company = array(
  'name'     => 'company',
  'id'          => 'company',
  'value'       => $details->company,
  'class'       => 'form-control',
  );
$cf1 = array(
  'name'        => 'cf1',
  'id'          => 'cf1',
  'value'       => $details->cf1,
  'class'       => 'form-control',
  );
$cf2 = array(
  'name'        => 'cf2',
  'id'          => 'cf2',
  'value'       => $details->cf2,
  'class'       => 'form-control',
  );
$cf3 = array(
  'name'        => 'cf3',
  'id'          => 'cf3',
  'value'       => $details->cf3,
  'class'       => 'form-control',
  );
$cf4 = array(
  'name'        => 'cf4',
  'id'          => 'cf4',
  'value'       => $details->cf4,
  'class'       => 'form-control',
  );
$cf5 = array(
  'name'        => 'cf5',
  'id'          => 'cf5',
  'value'       => $details->cf5,
  'class'       => 'form-control',
  );
$cf6 = array(
  'name'        => 'cf6',
  'id'          => 'cf6',
  'value'       => $details->cf6,
  'class'       => 'form-control',
  );
$address = array(
  'name'        => 'address',
  'id'          => 'address',
  'value'       => $details->address,
  'class'       => 'form-control',
  );
$city = array(
  'name'        => 'city',
  'id'          => 'city',
  'value'       => $details->city,
  'class'       => 'form-control',
  );
$state = array(
  'name'     => 'state',
  'id'          => 'state',
  'value'       => $details->state,
  'class'       => 'form-control',
  );
$postal_code = array(
  'name'        => 'postal_code',
  'id'          => 'postal_code',
  'value'       => $details->postal_code,
  'class'       => 'form-control',
  );
$country = array(
  'name'        => 'country',
  'id'          => 'country',
  'value'       => $details->country,
  'class'       => 'form-control',
  );
$phone = array(
  'name'        => 'phone',
  'id'          => 'phone',
  'value'       => $details->phone,
  'class'       => 'form-control',
  );

  ?>
  <script src="<?= $assets; ?>/js/bootstrap-fileupload.js"></script>
  <link href="<?= $assets; ?>/style/bootstrap-fileupload.css" rel="stylesheet">        
  
  <div class="page-head">
    <h2 class="pull-left"><?= $page_title; ?> <span class="page-meta"><?= lang("update_info"); ?></span> </h2>
  </div>
  <div class="clearfix"></div>
  <div class="matter">
    <div class="container">
      <?php $attrib = array('class' => 'form-horizontal'); echo form_open_multipart("settings/edit_company?id=".$details->id);?>
      <div class="form-group">
        <label for="company"><?= lang("company"); ?></label>
        <div class="controls"> <?= form_input($company);?>
        </div>
      </div> 
      <div class="form-group">
        <label for="name"><?= lang("contact_person"); ?></label>
        <div class="controls"> <?= form_input($name);?>
        </div>
      </div> 
      <div class="form-group">
        <label for="email_address"><?= lang("email_address"); ?></label>
        <div class="controls"> <?= form_input($email);?>
        </div>
      </div> 
      <div class="form-group">
        <label for="phone"><?= lang("phone"); ?></label>
        <div class="controls"> <?= form_input($phone);?>
        </div>
      </div> 
      
      <div class="form-group">
        <label for="address"><?= lang("address"); ?></label>
        <div class="controls"> <?= form_input($address);?>
        </div>
      </div>  
      <div class="form-group">
        <label for="city"><?= lang("city"); ?></label>
        <div class="controls"> <?= form_input($city);?>
        </div>
      </div> 
      <div class="form-group">
        <label for="state"><?= lang("state"); ?></label>
        <div class="controls"> <?= form_input($state);?>
        </div>
      </div> 
      <div class="form-group">
        <label for="postal_code"><?= lang("postal_code"); ?></label>
        <div class="controls"> <?= form_input($postal_code);?>
        </div>
      </div> 
      <div class="form-group">
        <label for="country"><?= lang("country"); ?></label>
        <div class="controls"> <?= form_input($country);?>
        </div>
      </div> 
      <div class="form-group">
        <label for="cf1"><?= lang("bcf1"); ?></label>
        <div class="controls"> <?= form_input($cf1);?>
        </div>
      </div> 
      <div class="form-group">
        <label for="cf2"><?= lang("bcf2"); ?></label>
        <div class="controls"> <?= form_input($cf2);?>
        </div>
      </div> 
      <div class="form-group">
        <label for="cf3"><?= lang("bcf3"); ?></label>
        <div class="controls"> <?= form_input($cf3);?>
        </div>
      </div> 
      <div class="form-group">
        <label for="cf4"><?= lang("bcf4"); ?></label>
        <div class="controls"> <?= form_input($cf4);?>
        </div>
      </div> 
      <div class="form-group">
        <label for="cf5"><?= lang("bcf5"); ?></label>
        <div class="controls"> <?= form_input($cf5);?>
        </div>
      </div> 
      <div class="form-group">
        <label for="cf6"><?= lang("bcf6"); ?></label>
        <div class="controls"> <?= form_input($cf6);?>
        </div>
      </div> 
      <div class="row">
        <div class="col-sm-6">
          <div class="control-group">
            <label class="form-label" for="copy"><?= lang("upload_logo"); ?></label>
            <div class="controls">
              <div class="fileupload fileupload-new" data-provides="fileupload">
                <div class="input-append">
                  <div class="uneditable-input span2"><i class="icon-file fileupload-exists"></i> <span class="fileupload-preview"></span></div>
                  <span class="btn btn-file btn-info"><span class="fileupload-new"><?= lang("select_file"); ?></span><span class="fileupload-exists"><?= lang("change"); ?></span>
                  <input type="file" name="logo" />
                </span><a href="#" class="btn fileupload-exists" data-dismiss="fileupload"><?= lang("remove"); ?></a> </div>
              </div>
              <span class="help-block"><?= lang("invoice_logo_tip"); ?></span> </div>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="control-group">
              <label class="form-label" for="copy"><?= lang("upload_stamp_sign_image"); ?></label>
              <div class="controls">
                <div class="fileupload fileupload-new" data-provides="fileupload">
                  <div class="input-append">
                    <div class="uneditable-input span2"><i class="icon-file fileupload-exists"></i> <span class="fileupload-preview"></span></div>
                    <span class="btn btn-file btn-info"><span class="fileupload-new"><?= lang("select_file"); ?></span><span class="fileupload-exists"><?= lang("change"); ?></span>
                    <input type="file" name="image" />
                  </span><a href="#" class="btn fileupload-exists" data-dismiss="fileupload"><?= lang("remove"); ?></a> </div>
                </div>
                <span class="help-block"><?= lang("stamp_sign_image_tip"); ?></span> </div>
              </div>
            </div>
          </div>

          <div class="form-group">
            <div class="controls"> <?= form_submit('submit', lang("update"), 'class="btn btn-primary"');?> </div>
          </div>
          <?= form_close();?> 
          <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
      </div>