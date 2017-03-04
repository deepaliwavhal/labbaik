<?php 
foreach($tax_rates as $tax){
    $tr[$tax->id] = $tax->name;
}
?>
<style type="text/css">
@media only screen and (max-width: 760px), (min-device-width: 768px) and (max-device-width: 1024px)  {
    /*#dyTable tbody td:nth-of-type(1):before { content: "<?= lang('no'); ?>"; }*/
    #dyTable tbody td:nth-of-type(2):before { content: "<?= lang('quantity'); ?>"; }
    #dyTable tbody td:nth-of-type(3):before { content: "<?= lang('product_code'); ?>"; }
    #dyTable tbody td:nth-of-type(4):before { content: "<?= lang('unit_price'); ?>"; }
    #dyTable tbody td:nth-of-type(5):before { content: "<?= lang('discount'); ?>"; }
    #dyTable tbody td:nth-of-type(6):before { content: "<?= lang('tax_rate'); ?>"; }
    #dyTable tbody td:nth-of-type(7):before { content: "<?= lang('subtotal'); ?>"; }
}
</style>

<div class="row">

    <div class="col-md-4">
        <div class="form-group">
            <label for="date"><?= lang("date"); ?></label>
            <?php $date = date('Y-m-d H:i'); ?>
            <?= form_input('date', (isset($_POST['date']) ? $_POST['date'] : ($inv ? $this->sim->hrld($inv->date) : $this->sim->hrld($date))), 'class="form-control datetime" id="date"');?>
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            <label for="billing_company"><?= lang("billing_company"); ?></label>
            <?php
            $bc[""] = lang("select")." ".lang("billing_company");
            foreach($companies as $company){
                $bu[$company->id] = $company->company;
            }
            echo form_dropdown('billing_company', $bu, (isset($_POST['billing_company']) ? $_POST['billing_company'] : ($inv ? $inv->company_id : '')), 'class="billing_company form-control" data-placeholder="'.lang("select")." ".lang("billing_company").'" id="billing_company"');
            ?>
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            <label for="reference_no"><?= lang("reference_no"); ?></label>
            <div class="input-group">
                <?= form_input('reference_no', (isset($_POST['reference_no']) ? $_POST['reference_no'] : ($inv ? $inv->reference_no : '')), 'class="form-control" id="reference_no"'); ?>
                <span class="input-group-addon" id="gen_ref" style="cursor: pointer;"><i class="fa fa-random"></i></span>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>

<div class="row">

    <div class="col-md-4">
        <div class="form-group">
        <label for="customer"><?= lang("customer"); ?></label>
            <?php
            $cu[""] = lang("select")." ".lang("customer");
            $cu["new"] = lang("new_customer");
            foreach($customers as $customer){
                $cu[$customer->id] = $customer->company && trim($customer->company) != '-' ? $customer->company .' ('.$customer->name.')' : $customer->name;
            }
            echo form_dropdown('customer', $cu, (isset($_POST['customer']) ? $_POST['customer'] : ($inv ? $inv->customer_id : '')), 'class="customer form-control" data-placeholder="'.lang("select")." ".lang("customer").'" id="customer"');
            ?>
        </div>
    </div>
    
    <?php
    if (!$q) {
        ?>
        <div class="col-md-4">
            <div class="form-group">
                <label for="due_date"><?= lang("due_date"); ?></label>
                <?php $date = date('Y-m-d H:i'); ?>
                <?= form_input('due_date', (isset($_POST['due_date']) ? $_POST['due_date'] : ($inv && $inv->due_date ? $this->sim->hrsd($inv->due_date) : $this->sim->hrsd($date))), 'class="form-control date" id="due_date"');?>
            </div>
        </div>
        <?php
    } else {
        ?>
        <div class="col-md-4">
            <div class="form-group">
                <label for="expiry_date"><?= lang("expiry_date"); ?></label>
                <?= form_input('expiry_date', (isset($_POST['expiry_date']) ? $_POST['expiry_date'] : ($inv && $inv->expiry_date ? $this->sim->hrsd($inv->expiry_date) : '')), 'class="form-control" id="expiry_date"');?>
            </div>
        </div>
        <?php
    }
    ?>

    <div class="col-md-4">
        <div class="form-group">
            <label for="shipping"><?= lang("shipping"); ?></label>
            <?= form_input('shipping', (isset($_POST['shipping']) ? $_POST['shipping'] : ($inv ? $inv->shipping : '')), 'class="form-control" id="shipping"');?>
        </div>
    </div>
</div>

<div class="row">

    <div class="col-md-4">
        <div class="form-group">
            <label for="order_discount"><?= lang("order_discount"); ?></label>
            <?= form_input('order_discount', (isset($_POST['order_discount']) ? $_POST['order_discount'] : ($inv ? $inv->order_discount_id : '')), 'class="form-control" id="order_discount"');?>
        </div>
    </div>           

    <div class="col-md-4">
        <div class="form-group">
            <label for="order_tax"><?= lang("order_tax"); ?></label>
            <?= form_dropdown('order_tax', $tr, (isset($_POST['order_tax']) ? $_POST['order_tax'] : ($inv ? $inv->order_tax_id : '')), 'id="order_tax" class="tax form-control input-sm" style="min-width: 100px;"');
            ?>
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            <label for="status"><?= lang("status"); ?></label>
            <?php
            if (!$q) {
                $st = array(
                    ''      => lang("select")." ".lang("status"),
                    'canceled' => lang('canceled'),
                    'overdue'   => lang('overdue'),
                    'paid'      => lang('paid'),
                    'pending'   => lang('pending')
                    );
            } else {
                $st = array(
                    ''      => lang("select")." ".lang("status"),
                    'canceled' => lang('canceled'),
                    'ordered'   => lang('ordered'),
                    'pending'   => lang('pending'),
                    'sent'  => lang('sent')
                    );
            }
            echo form_dropdown('status', $st, (isset($_POST['status']) ? $_POST['status'] : ($inv ? $inv->status : '')), 'class="status form-control" data-placeholder="'.lang("select")." ".lang("status").'" id="status"');
            ?>
        </div>
    </div>
</div>

<?php
if (!$q) {
    ?>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label for="recurring"><?= lang("recurring"); ?></label>
                <?php
                $opt = array(0 => lang('no'), 1 => lang('daily'), 2 => lang('weekly'), 3 => lang('monthly'), 4 => lang('quarterly'), 5 => lang('semiannually'), 6 => lang('annually'), 7 => lang('biennially'));
                echo form_dropdown('recurring', $opt, (isset($_POST['recurring']) ? $_POST['recurring'] : ($inv ? $inv->recurring : '')), 'class="form-control" id="recurring"');
                ?>
            </div>
        </div>
    </div>
    <?php
}
?>

<div class="clearfix"></div>

<div class="col-xs-12">
    <div class="row" id="customerForm" style="display:none;">
        <div class="well well-sm">
            <div class="clearfix"></div>
            <h3><?= lang('new_customer'); ?></h3>
            <div class="clearfix"></div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label for="company"><?= lang("company"); ?></label>
                    <div class="controls"> <?= form_input('company', (isset($_POST['company']) ? $_POST['company'] : ""), 'class="form-control" id="company" ');?> </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label for="name"><?= lang("contact_person"); ?></label>
                    <div class="controls"> <?= form_input('name', (isset($_POST['name']) ? $_POST['name'] : ""), 'class="form-control" id="name"');?> </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label for="phone"><?= lang("phone"); ?></label>
                    <div class="controls"> <?= form_input('phone', (isset($_POST['phone']) ? $_POST['phone'] : ""), 'class="form-control" id="phone"');?> </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label for="email_address"><?= lang("email_address"); ?></label>
                    <div class="controls"> <?= form_input('email', (isset($_POST['email']) ? $_POST['email'] : ""), 'class="form-control" id="email_address"');?> </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label for="address"><?= lang("address"); ?></label>
                    <div class="controls"> <?= form_input('address', (isset($_POST['address']) ? $_POST['address'] : ""), 'class="form-control" id="address" ');?> </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label for="city"><?= lang("city"); ?></label>
                    <div class="controls"> <?= form_input('city', (isset($_POST['city']) ? $_POST['city'] : ""), 'class="form-control" id="city" ');?> </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label for="state"><?= lang("state"); ?></label>
                    <div class="controls"> <?= form_input('state', (isset($_POST['state']) ? $_POST['state'] : ""), 'class="form-control" id="state" ');?> </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label for="postal_code"><?= lang("postal_code"); ?></label>
                    <div class="controls"> <?= form_input('postal_code', (isset($_POST['postal_code']) ? $_POST['postal_code'] : ""), 'class="form-control" id="postal_code" ');?> </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label for="country"><?= lang("country"); ?></label>
                    <div class="controls"> <?= form_input('country', (isset($_POST['country']) ? $_POST['country'] : ""), 'class="form-control" id="country" ');?> </div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
<div class="clearfix"></div>

<div class="table-responsive">
    <table id="dyTable" class="table table-striped table-condensed" style="margin-bottom:5px;">
        <thead>
        <tr class="active">
            <th class="text-center"><?= lang("no"); ?></th>
            <th class="col-sm-1 text-center"><?= lang("quantity"); ?></th>
            <th class="text-center"><?= lang("product_code"); ?></th>
            <th class="col-sm-2 text-center"><?= lang("unit_price"); ?></th>
            <?php if($Settings->product_discount) { ?><th class="col-sm-1 text-center"><?= lang("discount"); ?></th><?php } ?>
            <?php if($Settings->default_tax_rate) { ?><th class="col-sm-2 text-center"><?= lang("tax_rate"); ?></th><?php } ?>
            <th class="col-sm-2 text-center"><?= lang("subtotal"); ?></th>
        </tr></thead>
        <tbody>
        <?php
        $i = isset($_POST['product']) ? sizeof($_POST['product']) : 0;
        if (!$inv) {
            for($r=1; $r<=$i; $r++) {
            ?>
                <tr id="<?= $r; ?>">
                    <td style="width: 20px; text-align: center; padding-right: 10px; padding-right: 10px;"><?= $r; ?></td>
                    <td><?= form_input('quantity[]', $_POST['quantity'][$r-1], 'id="quantity-'.$r.'" class="quantity form-control text-center input-sm" style="min-width: 70px;"');?></td>
                    <td>
                        <div class="input-group">
                            <?= form_input('product[]', $_POST['product'][$r-1], 'id="product-'.$r.'" class="form-control input-sm suggestions" maxlength="80" style="min-width:270px;"'); ?>
                            <span class="input-group-addon"><i class="fa fa-file-text-o pointer details"></i></span>
                        </div>
                        <div class="details-con details-con-0<?= $r; ?>"<?= $_POST['details'][$r-1] ? '' : ' style="display:none;"'; ?>>
                            <?= form_textarea('details[]', $_POST['details'][$r-1], 'class="form-control details" id="details-'.$r.'" maxlength="255" style="margin-top:5px;padding:5px 10px;height:60px;"');?>
                        </div>
                    </td>
                    <td><?= form_input('price[]', $_POST['price'][$r-1], 'id="price-'.$r.'" class="price form-control text-right input-sm" style="min-width: 100px;"'); ?></td>
                    <?php if($Settings->product_discount) { ?>
                        <td><?php
                        echo form_input('discount[]', $_POST['discount'][$r-1], 'id="discount-'.$r.'" class="discount form-control input-sm"');  ?></td>
                        </th><?php } ?>
                    <?php if($Settings->default_tax_rate) { ?>
                        <td><?php
                        echo form_dropdown('tax_rate[]', $tr, $_POST['tax_rate'][$r-1], 'id="tax_rate-'.$r.'" class="tax form-control input-sm" style="min-width: 100px;"');  ?></td>
                        </th><?php } ?>
                    <td><input type="text" readonly tabindex="-1" id="subtotal-<?= $r; ?>" class="subtotal form-control text-right input-sm" name="subtotal[]"></td>
                    
                </tr>
            <?php
            }
        } else {
            $r = 1;
            foreach($inv_products as $prod) {
            ?>
            <tr id="<?= $r; ?>">
                <td style="width: 20px; text-align: center; padding-right: 10px; padding-right: 10px;"><?= $r; ?></td>
                <td><?= form_input('quantity[]', $prod->quantity, 'id="quantity-'.$r.'" class="quantity form-control text-center input-sm" style="min-width: 70px;"');?></td>
                <td>
                    <div class="input-group">
                        <?= form_input('product[]', $prod->product_name, 'id="product-'.$r.'" class="form-control input-sm suggestions" maxlength="80" style="min-width:270px;"'); ?>
                        <span class="input-group-addon"><i class="fa fa-file-text-o pointer details"></i></span>
                    </div>
                    <div class="details-con details-con-0<?= $r; ?>"<?= $prod->details ? '' : ' style="display:none;"'; ?>>
                        <?= form_textarea('details[]', $prod->details, 'class="form-control details" id="details-'.$r.'" maxlength="255" style="margin-top:5px;padding:5px 10px;height:60px;"');?>
                    </div>
                </td>
                <td><?= form_input('price[]', $prod->real_unit_price, 'id="price-'.$r.'" class="price form-control text-right input-sm" style="min-width: 100px;"'); ?></td>
                <?php if($Settings->product_discount) { ?>
                    <td><?php
                    echo form_input('discount[]', $prod->discount, 'id="discount-'.$r.'" class="discount form-control input-sm"');  ?></td>
                    </th><?php } ?>
                <?php if($Settings->default_tax_rate) { ?>
                    <td><?php
                    echo form_dropdown('tax_rate[]', $tr, $prod->tax_rate_id, 'id="tax_rate-'.$r.'" class="tax form-control input-sm" style="min-width: 100px;"');  ?></td>
                    </th><?php } ?>
                <td><input type="text" readonly tabindex="-1" id="subtotal-<?= $r; ?>" class="subtotal form-control text-right input-sm" name="subtotal[]"></td>
                
            </tr>
            <?php
            $r++;
            }
        }
        if($r < 9) {
            for($rw=$r; $rw<=$Settings->no_of_rows; $rw++) {
        ?>
            <tr id="<?= $rw; ?>">
                <td style="width: 20px; text-align: center; padding-right: 10px; padding-right: 10px;"><?= $rw; ?></td>
                <td><?= form_input('quantity[]', '', 'id="quantity-'.$rw.'" class="quantity form-control text-center input-sm" style="min-width: 70px;"');?></td>
                <td>
                    <div class="input-group">
                        <?= form_input('product[]', '', 'id="product-'.$rw.'" class="form-control input-sm suggestions" maxlength="80" style="min-width:270px;"'); ?>
                        <span class="input-group-addon"><i class="fa fa-file-text-o pointer details"></i></span>
                    </div>
                    <div class="details-con details-con-0<?= $rw; ?>" style="display:none;">
                        <?= form_textarea('details[]', '', 'class="form-control details" id="details-'.$rw.'" maxlength="255" style="margin-top:5px;padding:5px 10px;height:60px;"');?>
                    </div>
                </td>
                <td><?= form_input('price[]', '', 'id="price-'.$rw.'" class="price form-control text-right input-sm" style="min-width: 100px;"'); ?></td>
                <?php if($Settings->product_discount) { ?>
                    <td><?php
                    echo form_input('discount[]', '', 'id="discount-'.$rw.'" class="discount form-control input-sm"');  ?>
                    </td><?php } ?>
                <?php if($Settings->default_tax_rate) { ?>
                    <td><?php
                    echo form_dropdown('tax_rate[]', $tr, '', 'id="tax_rate-'.$rw.'" class="tax form-control input-sm" style="min-width: 100px;"');  ?></td>
                    <?php } ?>
                <td><input type="text" readonly tabindex="-1" id="subtotal-<?= $rw; ?>" class="subtotal form-control text-right input-sm" name="subtotal[]"></td>
                
            </tr>
        <?php
            }
        }
        ?>
        </tbody>
        <tfoor>
            <?php $c = 3; if($Settings->product_discount) { $c++; } if($Settings->default_tax_rate) { $c++; } ?>
            <td colspan="<?= $c; ?>">
                <button type="button" tabindex="-1" class="btn btn-primary btn-sm" id='addButton'><i class="fa fa-plus"></i></button>
                <button type="button" tabindex="-1" class="btn btn-danger btn-sm" id='removeButton'><i class="fa fa-minus"></i></button>
            </td>
            <td class="hidden-xs"><h4 style="margin: 0; text-align: right;"><?= lang('total'); ?>:</h4></td>
            <td class="hidden-xs"><h4 style="margin: 0; text-align: right;"><span class="pull-right total_amount">0.00</span></h4></td>
        </tfoor>
    </table>
</div>

<div class="well well-sm bold">
    <div class="visible-xs col-xs-12" style="border:0;"><h4 style="margin:0;text-align:center;"><?= lang('total'); ?>: <span class="total_amount">0.00</span></h4></div>
    <div class="col-sm-4" style="border:0;"><h4 style="margin:0;text-align:center;"><?= lang('order_discount'); ?>: <span id="order_discount_total">0.00</span></h4></div>
    <div class="col-sm-4" style="border:0;"><h4 style="margin:0;text-align:center;"><?= lang('order_tax'); ?>: <span id="order_tax_total">0.00</span></h4></div>
    <div class="col-sm-4" style="border:0;"><h4 style="margin:0;text-align:center;"><?= lang('grand_total'); ?>: <span id="grand_total" style="font-weight:bold;">0.00</span></h4></div>
    <div class="clearfix"></div>
</div>

<div class="clearfix"></div>

<div class="form-group">
    <?= form_textarea('note', (isset($_POST['note']) ? $_POST['note'] : ($inv ? $inv->note : '')), 'class="form-control notes" placeholder="'.lang("add_note").'" rows="3" style="margin-top: 10px; height: 100px;"');?>
</div>