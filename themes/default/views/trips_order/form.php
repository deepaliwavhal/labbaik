<?php
foreach ($tax_rates as $tax) {
    $tr[$tax->id] = $tax->name;
}
?>
<style type="text/css">
    @media only screen and (max-width: 760px), (min-device-width: 768px) and (max-device-width: 1024px)  {
        /*#dyTable tbody td:nth-of-type(1):before { content: "<?= lang('no'); ?>"; }*/
        #dyTable tbody td:nth-of-type(1):before { content: "<?= lang('gender'); ?>"; }
        #dyTable tbody td:nth-of-type(2):before { content: "<?= lang('name'); ?>"; }
        #dyTable tbody td:nth-of-type(3):before { content: "<?= lang('dob'); ?>"; }
        #dyTable tbody td:nth-of-type(4):before { content: "<?= lang('type'); ?>"; }
        /*#dyTable tbody td:nth-of-type(6):before { content: "<?= lang('tax_rate'); ?>"; }*/
        #dyTable tbody td:nth-of-type(5):before { content: "<?= lang('subtotal'); ?>"; }
    }
</style>

<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label for="customer"><?= lang("customer"); ?></label>
            <?php
            $cu[""] = lang("select") . " " . lang("customer");
            $cu["new"] = lang("new_customer");
            foreach ($customers as $customer) {
                $cu[$customer->id] = $customer->company && trim($customer->company) != '-' ? $customer->company . ' (' . $customer->name . ')' : $customer->name;
            }
            echo form_dropdown('customer', $cu, (isset($_POST['customer']) ? $_POST['customer'] : ($inv ? $inv->customer_id : '')), 'class="customer form-control" data-placeholder="' . lang("select") . " " . lang("customer") . '" id="customer"');
            ?>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="date"><?= lang("date"); ?></label>
            <?php $date = date('Y-m-d H:i'); ?>
            <?= form_input('date', (isset($_POST['date']) ? $_POST['date'] : ($inv ? $this->sim->hrld($inv->date) : $this->sim->hrld($date))), 'class="form-control datetime" id="date"'); ?>
        </div>
    </div>



    <div class="col-md-4">
        <div class="form-group">
            <label for="due_date"><?= lang("due_date"); ?></label>
            <?php $date = date('Y-m-d H:i'); ?>
            <?= form_input('due_date', (isset($_POST['due_date']) ? $_POST['due_date'] : ($inv && $inv->due_date ? $this->sim->hrsd($inv->due_date) : $this->sim->hrsd($date))), 'class="form-control date" id="due_date"'); ?>
        </div>
    </div>

</div>
<div class="row">
    <div class="col-md-4">
        <div class="form-group">
                <label for="mobile_no"><?= lang("mobile_no"); ?></label>
                <?= form_input('mobile_no', (isset($_POST['mobile_no']) ? $_POST['mobile_no'] : ''), 'class="form-control" id="order_discount"'); ?>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
                <label for="cr_cpr"><?= lang("cr_cpr"); ?></label>
                <?= form_input('cr_cpr', (isset($_POST['cr_cpr']) ? $_POST['cr_cpr'] : ''), 'class="form-control" id="order_discount"'); ?>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="assigned_to"><?= lang("assigned_to"); ?></label>
            <?php
            $st = array(
                '' => lang("select") . " " . lang("assigned_to"),
                'canceled' => lang('t1'),
                'ordered' => lang('t2'),
                'pending' => lang('t3')
            );
            echo form_dropdown('assigned_to', $st, (isset($_POST['assigned_to']) ? $_POST['assigned_to'] : ''), 'class="assigned_to form-control" data-placeholder="' . lang("select") . " " . lang("status") . '" id="status"');
            ?>
     </div>
    </div>
</div>
<div class="row">
    <!--<div class="col-md-4">
        <div class="form-group">
            <label for="order_discount"><?= lang("order_discount"); ?></label>
            <?= form_input('order_discount', (isset($_POST['order_discount']) ? $_POST['order_discount'] : ($inv ? $inv->order_discount_id : '')), 'class="form-control" id="order_discount"'); ?>
        </div>
    </div>           

    <div class="col-md-4">
        <div class="form-group">
            <label for="order_tax"><?= lang("order_tax"); ?></label>
            <?= form_dropdown('order_tax', $tr, (isset($_POST['order_tax']) ? $_POST['order_tax'] : ($inv ? $inv->order_tax_id : '')), 'id="order_tax" class="tax form-control input-sm" style="min-width: 100px;"');
            ?>
        </div>
    </div>-->

    <div class="col-md-4">
        <div class="form-group">
            <label for="status"><?= lang("status"); ?></label>
            <?php
          
                $st = array(
                    '' => lang("select") . " " . lang("status"),
                    'canceled' => lang('canceled'),
                    'ordered' => lang('ordered'),
                    'pending' => lang('pending'),
                    'sent' => lang('sent')
                );
            
            echo form_dropdown('status', $st, (isset($_POST['status']) ? $_POST['status'] : ($inv ? $inv->status : '')), 'class="status form-control" data-placeholder="' . lang("select") . " " . lang("status") . '" id="status"');
            ?>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="package"><?= lang("package"); ?></label>
            <?php
            $package = array(
                    '' => lang("select") . " " . lang("package")
                    );
                foreach($packages as $p){
                    $package[$p->t_id] = $p->t_name;
                }
            
            echo form_dropdown('package', $package, (isset($_POST['package']) ? $_POST['package'] : ''), 'class="package form-control" data-placeholder="' . lang("select") . " " . lang("package") . '" id="package"');
            echo form_hidden('package_cost', '');
            ?>
        </div>
    </div>
</div>



<div class="table-responsive">
    <table id="dyTable" class="table table-striped table-condensed" style="margin-bottom:5px;">
        <thead>
            <tr class="active">
                <th class="text-center"><?= lang("no"); ?></th>
                <th class="col-sm-1 text-center"><?= lang("gender"); ?></th>
                <th class="text-center"><?= lang("name"); ?></th>
                <th class="col-sm-2 text-center"><?= lang("dob"); ?></th>
                <th class="col-sm-2 text-center"><?= lang("type"); ?></th>
                <th class="col-sm-2 text-center"><?= lang("subtotal"); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = isset($_POST['traveler']) ? sizeof($_POST['traveler']) : 0;
            if (!$inv) {
                for ($r = 1; $r <= $i; $r++) {
                    ?>
                    <tr id="<?= $r; ?>">
                        <td style="width: 20px; text-align: center; padding-right: 10px; padding-right: 10px;"><?= $r; ?></td>
                        <td><?php  echo form_dropdown('gender', $gender, (isset($_POST['gender']) ? $_POST['gender'] : ""), 'class="form-control gender" data-placeholder="' . lang("select") . " " . lang("gender") . '" id="gender" style="width:100%;"'); ?></td>
                        <td>
                            <div class="input-group">
                                <?= form_input('traveler_name[]', $_POST['traveler_name'][$r - 1], 'id="traveler_name-' . $r . '" class="form-control input-sm suggestions" maxlength="80" style="min-width:270px;"'); ?>
                                <span class="input-group-addon"><i class="fa fa-file-text-o pointer details"></i></span>
                            </div>
                            <!--<div class="details-con details-con-0<?= $r; ?>"<?= $_POST['details'][$r - 1] ? '' : ' style="display:none;"'; ?>>
                                <?= form_textarea('details[]', $_POST['details'][$r - 1], 'class="form-control details" id="details-' . $r . '" maxlength="255" style="margin-top:5px;padding:5px 10px;height:60px;"'); ?>
                            </div>-->
                        </td>
                        <td><?= form_input('traveler_dob[]', $_POST['traveler_dob'][$r - 1], 'id="traveler_dob-' . $r . '" class="traveler_dob form-control text-right input-sm date" style="min-width: 100px;"'); ?></td>
                        <!--<?php if ($Settings->product_discount) { ?>
                            <td><?php echo form_input('discount[]', $_POST['discount'][$r - 1], 'id="discount-' . $r . '" class="discount form-control input-sm"'); ?></td>
                            </th><?php } ?>
                        <?php if ($Settings->default_tax_rate) { ?>
                            <td><?php echo form_dropdown('tax_rate[]', $tr, $_POST['tax_rate'][$r - 1], 'id="tax_rate-' . $r . '" class="tax form-control input-sm" style="min-width: 100px;"'); ?></td>
                            </th><?php } ?>-->
                        <td>
                            <?php  echo form_dropdown('traveler_type', $traveler_type, (isset($_POST['traveler_type'][$r - 1]) ? $_POST['traveler_type'][$r - 1] : ""), 'class="form-control traveler_type" data-placeholder="' . lang("select") . " " . lang("Type") . '" id="traveler_type" style="width:100%;"'); ?>
                            `<?php //echo form_input('quantity[]', $_POST['quantity'][$r - 1], 'id="quantity-' . $r . '" class="quantity form-control text-center input-sm" style="min-width: 70px;"'); 
                            ?></td>
                        <td><input type="text" readonly tabindex="-1" id="subtotal-<?= $r; ?>" class="subtotal form-control text-right input-sm" name="subtotal[]"></td>

                    </tr>
        <?php
    }
} else {
    $r = 1;
    foreach ($inv_products as $prod) {
        ?>
                    <tr id="<?= $r; ?>">
                        <td style="width: 20px; text-align: center; padding-right: 10px; padding-right: 10px;"><?= $r; ?></td>
                        <td><!--<?= form_input('quantity[]', $prod->quantity, 'id="quantity-' . $r . '" class="quantity form-control text-center input-sm" style="min-width: 70px;"'); ?>-->
                        <?php  echo form_dropdown('gender', $gender, (isset($_POST['gender']) ? $_POST['gender'] : ""), 'class="form-control gender" data-placeholder="' . lang("select") . " " . lang("gender") . '" id="gender" style="width:100%;"'); ?></td>
                        <td>
                            <div class="input-group">
        <?= form_input('traveler_name[]', $prod->traveler_name, 'id="traveler_name-' . $r . '" class="form-control input-sm suggestions" maxlength="80" style="min-width:270px;"'); ?>
                                <span class="input-group-addon"><i class="fa fa-file-text-o pointer details"></i></span>
                            </div>
                            <div class="details-con details-con-0<?= $r; ?>"<?= $prod->details ? '' : ' style="display:none;"'; ?>>
        <?= form_textarea('details[]', $prod->details, 'class="form-control details" id="details-' . $r . '" maxlength="255" style="margin-top:5px;padding:5px 10px;height:60px;"'); ?>
                            </div>
                        </td>
                        <td><?= form_input('traveler_dob[]', $prod->traveler_dob, 'id="traveler_dob-' . $r . '" class="traveler_dob form-control text-right input-sm date" style="min-width: 100px;"'); ?></td>
        <?php if ($Settings->product_discount) { ?>
                            <td><?php echo form_input('discount[]', $prod->discount, 'id="discount-' . $r . '" class="discount form-control input-sm"'); ?></td>
                            </th><?php } ?>
                            <?php if ($Settings->default_tax_rate) { ?>
                            <td><?php echo form_dropdown('tax_rate[]', $tr, $prod->tax_rate_id, 'id="tax_rate-' . $r . '" class="tax form-control input-sm" style="min-width: 100px;"'); ?></td>
                            </th><?php } ?>
                            <td><!--<?= form_input('quantity[]', $_POST['quantity'][$r - 1], 'id="quantity-' . $r . '" class="quantity form-control text-center input-sm" style="min-width: 70px;"'); ?>-->
                            <?php  echo form_dropdown('traveler_type', $traveler_type, (isset($_POST['traveler_type'][$r - 1]) ? $_POST['traveler_type'][$r - 1] : ""), 'class="form-control traveler_type" data-placeholder="' . lang("select") . " " . lang("Type") . '" id="traveler_type" style="width:100%;"'); ?>
                            </td>
                        <td><input type="text" readonly tabindex="-1" id="subtotal-<?= $r; ?>" class="subtotal form-control text-right input-sm" name="subtotal[]"></td>

                    </tr>
        <?php
        $r++;
    }
}
if ($r < 9) {
    for ($rw = $r; $rw <= $Settings->no_of_rows; $rw++) {
        ?>
                    <tr id="<?= $rw; ?>">
                        <td style="width: 20px; text-align: center; padding-right: 10px; padding-right: 10px;"><?= $rw; ?></td>
                        <td><!--<?= form_input('quantity[]', '', 'id="quantity-' . $rw . '" class="quantity form-control text-center input-sm" style="min-width: 70px;"'); ?>-->
                        <?php  echo form_dropdown('gender', $gender, (isset($_POST['gender']) ? $_POST['gender'] : ""), 'class="form-control gender" data-placeholder="' . lang("select") . " " . lang("gender") . '" id="gender" style="width:100%;"'); ?></td>
                        <td>
                            <div class="input-group">
        <?= form_input('traveler_name[]', '', 'id="traveler_name-' . $rw . '" class="form-control input-sm suggestions" maxlength="80" style="min-width:270px;"'); ?>
                                <span class="input-group-addon"><i class="fa fa-file-text-o pointer details"></i></span>
                            </div>
                            <div class="details-con details-con-0<?= $rw; ?>" style="display:none;">
                                <?= form_textarea('details[]', '', 'class="form-control details" id="details-' . $rw . '" maxlength="255" style="margin-top:5px;padding:5px 10px;height:60px;"'); ?>
                            </div>
                        </td>
                        <td><?= form_input('traveler_dob[]', '', 'id="traveler_dob-' . $rw . '" class="traveler_dob form-control text-right input-sm date" style="min-width: 100px;"'); ?></td>
                                <?php if ($Settings->product_discount) { ?>
                            <td><?php echo form_input('discount[]', '', 'id="discount-' . $rw . '" class="discount form-control input-sm"'); ?>
                            </td><?php } ?>
                        <?php if ($Settings->default_tax_rate) { ?>
     
                            <td><?php echo form_dropdown('tax_rate[]', $tr, '', 'id="tax_rate-' . $rw . '" class="tax form-control input-sm" style="min-width: 100px;"'); ?></td>
                            <?php } ?>
                            <td><!--<?= form_input('quantity[]', $_POST['quantity'][$r - 1], 'id="quantity-' . $r . '" class="quantity form-control text-center input-sm" style="min-width: 70px;"'); ?>-->
                            <?php  echo form_dropdown('traveler_type', $traveler_type, (isset($_POST['traveler_type'][$r - 1]) ? $_POST['traveler_type'][$r - 1] : ""), 'class="form-control traveler_type" data-placeholder="' . lang("select") . " " . lang("Type") . '" id="traveler_type" style="width:100%;"'); ?>
                        <td><input type="text" readonly tabindex="-1" id="subtotal-<?= $rw; ?>" class="subtotal form-control text-right input-sm" name="subtotal[]"></td>

                    </tr>
                            <?php
                        }
                    }
                    ?>
        </tbody>
        <tfoor>
            <?php $c = 4 ;
            if ($Settings->product_discount) {
                $c++;
            } if ($Settings->default_tax_rate) {
                $c++;
            } ?>
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
    <!--div class="col-sm-4" style="border:0;"><h4 style="margin:0;text-align:center;"><?= lang('order_tax'); ?>: <span id="order_tax_total">0.00</span></h4></div>-->
    <div class="col-sm-4" style="border:0;"><h4 style="margin:0;text-align:right;"><?= lang('grand_total'); ?>: <span id="grand_total" style="font-weight:bold;">0.00</span></h4></div>
    <div class="clearfix"></div>
</div>

<div class="clearfix"></div>

<div class="form-group">
    <?= form_textarea('note', (isset($_POST['note']) ? $_POST['note'] : ($inv ? $inv->note : '')), 'class="form-control notes" placeholder="' . lang("add_note") . '" rows="3" style="margin-top: 10px; height: 100px;"'); ?>
</div>