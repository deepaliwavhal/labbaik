<?php 
$name = array('name' => 'name', 'id' => 'name', 'value' => $customer->name, 'class' => 'form-control', 'readonly' => true);
$email = array('name' => 'email', 'id' => 'email', 'value' => $customer->email, 'class' => 'form-control');
$company = array('name' => 'company', 'id'=> 'company', 'value' => $customer->company, 'class' => 'form-control', 'readonly' => true);
$cf1 = array('name' => 'cf1', 'id' => 'cf1', 'value' => $customer->cf1, 'class' => 'form-control');
$cf2 = array('name' => 'cf2', 'id' => 'cf2', 'value' => $customer->cf2, 'class' => 'form-control');
$cf3 = array('name' => 'cf3', 'id' => 'cf3', 'value' => $customer->cf3, 'class' => 'form-control');
$cf4 = array('name' => 'cf4', 'id' => 'cf4', 'value' => $customer->cf4, 'class' => 'form-control');
$cf5 = array('name' => 'cf5', 'id' => 'cf5', 'value' => $customer->cf5, 'class' => 'form-control');
$cf6 = array('name' => 'cf6', 'id' => 'cf6', 'value' => $customer->cf6, 'class' => 'form-control');
$address = array('name' => 'address', 'id' => 'address', 'value' => $customer->address, 'class' => 'form-control');
$city = array('name' => 'city', 'id' => 'city', 'value' => $customer->city, 'class' => 'form-control');
$state = array('name' => 'state', 'id' => 'state', 'value' => $customer->state, 'class' => 'form-control');
$postal_code = array('name' => 'postal_code', 'id' => 'postal_code', 'value' => $customer->postal_code, 'class' => 'form-control');
$country = array('name' => 'country', 'id' => 'country', 'value' => $customer->country, 'class' => 'form-control');
$phone = array('name' => 'phone', 'id' => 'phone', 'value' => $customer->phone, 'class' => 'form-control');
?>

<div class="page-head">
    <h2><?= $page_title; ?></h2>
    <span class="page-meta"><?= lang("update_info"); ?></span>
</div>
<div class="clearfix"></div>
<div class="matter">
    <div class="container">

        <?php $attrib = array('class' => 'form-horizontal'); echo form_open("clients/company_details?id=".$id);?>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="company"><?= lang("company"); ?></label>
                    <div class="controls"> <?= form_input($company);?>
                    </div>
                </div> 
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="name"><?= lang("contact_person"); ?></label>
                    <div class="controls"> <?= form_input($name);?>
                    </div>
                </div> 
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
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
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="cf1"><?= lang("cf1"); ?></label>
                    <div class="controls"> <?= form_input($cf1);?>
                    </div>
                </div> 
                <div class="form-group">
                    <label for="cf2"><?= lang("cf2"); ?></label>
                    <div class="controls"> <?= form_input($cf2);?>
                    </div>
                </div> 
                <div class="form-group">
                    <label for="cf3"><?= lang("cf3"); ?></label>
                    <div class="controls"> <?= form_input($cf3);?>
                    </div>
                </div> 
                <div class="form-group">
                    <label for="cf4"><?= lang("cf4"); ?></label>
                    <div class="controls"> <?= form_input($cf4);?>
                    </div>
                </div> 
                <div class="form-group">
                    <label for="cf5"><?= lang("cf5"); ?></label>
                    <div class="controls"> <?= form_input($cf5);?>
                    </div>
                </div> 
                <div class="form-group">
                    <label for="cf6"><?= lang("cf6"); ?></label>
                    <div class="controls"> <?= form_input($cf6);?>
                    </div>
                </div> 
            </div>
        </div>

        <div class="form-group">
            <div class="controls"> <?= form_submit('submit', lang("update"), 'class="btn btn-primary"');?> </div>
        </div>
        <?= form_close();?>

    </div>
</div>
