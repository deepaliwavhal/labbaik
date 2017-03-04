<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?= $page_title." ".lang("no")." ".$inv->id; ?></title>
    <link rel="shortcut icon" href="<?= $assets; ?>img/favicon.ico">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="<?= $assets; ?>style/bootstrap.min.css" rel="stylesheet">
    <link href="<?= $assets; ?>style/style.css" rel="stylesheet">
</head>

<body>
    <img src="<?= $assets; ?>img/<?= $inv->status; ?>.png" alt="<?= $inv->status; ?>" style="float: right; position: absolute; top:0; right: 0;"/>
    <div id="wrap">
        <img src="<?= base_url(); ?>uploads/<?= $biller->logo ? $biller->logo : $Settings->logo; ?>" alt="<?= $biller->company ? $biller->company : $Settings->site_name ?>" style="margin-top: 20px;" />
        <div class="row">    
            <div class="col-xs-5">
                <h3><?= $biller->company; ?></h3>
                <?= $biller->address.",<br />".$biller->city.", ".$biller->postal_code.", ".$biller->state.",<br />".$biller->country;
                echo "<br />".lang("tel").": ".$biller->phone."<br />".lang("email").": ".$biller->email; 
                if ($biller->cf1 && $biller->cf1 != "-") { echo "<br />".lang("bcf1").": ".$biller->cf1; }
                if ($biller->cf2 && $biller->cf2 != "-") { echo "<br />".lang("bcf2").": ".$biller->cf2; }
                if ($biller->cf3 && $biller->cf3 != "-") { echo "<br />".lang("bcf3").": ".$biller->cf3; }
                if ($biller->cf4 && $biller->cf4 != "-") { echo "<br />".lang("bcf4").": ".$biller->cf4; }
                if ($biller->cf5 && $biller->cf5 != "-") { echo "<br />".lang("bcf5").": ".$biller->cf5; }
                if ($biller->cf6 && $biller->cf6 != "-") { echo "<br />".lang("bcf6").": ".$biller->cf6; }
                ?>
            </div>

            <div class="col-xs-6">
                <?= lang("billed_to"); ?>:
                <h3><?php if($customer->company != "-") { echo $customer->company; } else { echo $customer->name; } ?></h3>
                <?php 
                if($customer->company != "-") {
                    echo "<p>Attn: ".$customer->name."</p>"; 
                } 
                
                if($customer->address != "-") { 
                    echo  lang("address").": ".$customer->address.", ".$customer->city.", ".$customer->postal_code.", ".$customer->state.", ".$customer->country; 
                } 
                ?><br>
                <?= lang("tel").": ".$customer->phone; ?><br>
                <?= lang("email").": ".$customer->email; ?><br>
                <?php
                if ($customer->cf1 && $customer->cf1 != "-") { echo "<br />".lang("ccf1").": ".$customer->cf1; }
                if ($customer->cf2 && $customer->cf2 != "-") { echo "<br />".lang("ccf2").": ".$customer->cf2; }
                if ($customer->cf3 && $customer->cf3 != "-") { echo "<br />".lang("ccf3").": ".$customer->cf3; }
                if ($customer->cf4 && $customer->cf4 != "-") { echo "<br />".lang("ccf4").": ".$customer->cf4; }
                if ($customer->cf5 && $customer->cf5 != "-") { echo "<br />".lang("ccf5").": ".$customer->cf5; }
                if ($customer->cf6 && $customer->cf6 != "-") { echo "<br />".lang("ccf6").": ".$customer->cf6; }
                ?>

            </div> 
        </div>
        <div style="clear: both; height: 15px;"></div>

        <div class="row"> 
            <div class="col-xs-5">     
                <h3 class="inv"><?= lang("invoice")." ". lang("no") ." ".$inv->id; ?></h3>
            </div>
            <div class="col-xs-6">

                <p>
                    <?= lang("reference_no"); ?>: 
                    <?= $inv->reference_no; ?>
                </p>
                <p>
                    <?= lang("date"); ?>: 
                    <?= $this->sim->hrsd($inv->date); ?>
                </p>

            </div>
            <p>&nbsp;</p>
            <div style="clear: both; height: 15px;"></div>   
            <div class="col-xs-12">
                <table class="table table-bordered table-hover table-striped" style="margin-bottom: 5px;">

                    <thead> 

                        <tr> 
                            <th class="col-xs-1" style="max-width: 40px !important;"><?= lang("no"); ?></th> 
                            <th><?= lang("description"); ?></th> 
                            <th class="col-xs-1" style="min-width:80px;padding-left:0;padding-right:0;"><?= lang("unit_price"); ?></th> 
                            <th class="col-xs-1" style="min-width:100px;padding-left:0;padding-right:0;"><?= lang("quantity"); ?></th>
                            <?php 
                            if($Settings->product_discount) {
                                ?>
                                <th class="col-xs-1" style="min-width:100px;padding-left:0;padding-right:0;"><?= lang("discount"); ?></th>
                                <?php 
                            } 
                            ?>
                            <?php 
                            if($Settings->default_tax_rate) {
                                ?>
                                <th class="col-xs-1" style="min-width:100px;padding-left:0;padding-right:0;"><?= lang("tax"); ?></th>
                                <?php 
                            } 
                            ?>
                            <th class="col-xs-2"><?= lang("subtotal"); ?></th> 
                        </tr> 

                    </thead> 

                    <tbody> 

                        <?php 
                        $r = 1; 
                        foreach ($rows as $row):
                            ?>
                        <tr>
                            <td style="max-width: 30px !important;" class="text-center"><?= $r; ?></td>
                            <td><?= $row->details ? '<strong>'.$row->product_name.'</strong><br>'.$row->details : $row->product_name; ?></td>
                            <td class="text-right"><?= $this->sim->formatMoney($row->real_unit_price); ?></td>
                            <td class="text-center"><?= $row->quantity; ?></td>
                            <?php 
                            if($Settings->product_discount) { 
                                ?>
                                <td class="text-right">
                                    <?= $row->discount_amt > 0 ? '<small>('.$row->discount.')</small>' : ''; ?>
                                    <?= $this->sim->formatMoney($row->discount_amt); ?>
                                </td>
                                <?php 
                            } 
                            ?>
                            <?php 
                            if($Settings->default_tax_rate) { 
                                ?>
                                <td class="text-right">
                                    <?= $row->tax_amt > 0 ? '<small>('.$row->tax.')</small>' : ''; ?>
                                    <?= $this->sim->formatMoney($row->tax_amt); ?>
                                </td>
                                <?php 
                            } 
                            ?> 
                            <td class="text-right"><?= $this->sim->formatMoney($row->subtotal); ?></td> 
                        </tr> 
                        <?php 
                        $r++; 
                        endforeach;
                        ?>
                    </tbody>

                    <tfoot>
                        <?php
                        $cols = 4;
                        ?>
                        <tr class="totals">
                            <th colspan="<?= $cols; ?>"><?= lang('total'); ?></th>
                            <?php 
                            if($Settings->product_discount) { 
                                ?>
                                <th class="text-right"><?= $this->sim->formatMoney($inv->product_discount); ?></th>
                                <?php 
                            } 
                            ?> 
                            <?php 
                            if($Settings->default_tax_rate) { 
                                ?>
                                <th class="text-right"><?= $this->sim->formatMoney($inv->product_tax); ?></th>
                                <?php 
                            } 
                            ?> 
                            <th class="text-right"><?= $this->sim->formatMoney($inv->total); ?></th>
                        </tr>

                        <?php
                        $cols = $cols-2;
                        if($Settings->product_discount) { $cols++; }
                        if($Settings->default_tax_rate) { $cols++; }

                        if ($inv->order_discount > 0) {
                            ?>
                            <tr>
                                <th class="word_text" colspan="<?= $cols; ?>">
                                    <?= $this->mywords->n2w($inv->order_discount); ?>
                                </th>
                                <th class="text-right" colspan="2">
                                    <?= lang("order_discount"); ?> (<?= $Settings->currency_prefix; ?>)
                                </th>
                                <th class="text-right">
                                    <?= $this->sim->formatMoney($inv->order_discount); ?>
                                </th>
                            </tr>
                            <?php
                        }
                        ?>
                        <?php
                        if ($inv->order_tax > 0) {
                            ?>
                            <tr>
                                <th class="word_text" colspan="<?= $cols; ?>">
                                    <?= $this->mywords->n2w($inv->order_tax); ?>
                                </th>
                                <th class="text-right" colspan="2">
                                    <?= lang("order_tax"); ?> (<?= $Settings->currency_prefix; ?>)
                                </th>
                                <th class="text-right">
                                    <?= $this->sim->formatMoney($inv->order_tax); ?>
                                </th>
                            </tr>
                            <?php
                        }
                        ?>
                        <?php
                        if ($inv->shipping > 0) {
                            ?>
                            <tr>
                                <th class="word_text" colspan="<?= $cols; ?>">
                                    <?= $this->mywords->n2w($inv->shipping); ?>
                                </th>
                                <th class="text-right" colspan="2">
                                    <?= lang("shipping"); ?> (<?= $Settings->currency_prefix; ?>)
                                </th>
                                <th class="text-right">
                                    <?= $this->sim->formatMoney($inv->shipping); ?>
                                </th>
                            </tr>
                            <?php
                        }
                        ?>
                        <tr class="primary">
                            <th class="word_text text-primary" colspan="<?= $cols; ?>">
                                <?= $this->mywords->n2w($inv->grand_total); ?>
                            </th>
                            <th class="text-right text-primary" colspan="2">
                                <?= lang("grand_total"); ?> (<?= $Settings->currency_prefix; ?>)
                            </th>
                            <th class="text-right text-primary">
                                <?= $this->sim->formatMoney($inv->grand_total); ?>
                            </th>
                        </tr>
                        <tr>
                            <th class="word_text text-success" colspan="<?= $cols; ?>">
                                <?= $this->mywords->n2w($inv->paid); ?>
                            </th>
                            <th class="text-right text-success" colspan="2">
                                <?= lang("paid"); ?> (<?= $Settings->currency_prefix; ?>)
                            </th>
                            <th class="text-right text-success">
                                <?= $this->sim->formatMoney($inv->paid); ?>
                            </th>
                        </tr>
                        <tr>
                            <th class="word_text text-warning" colspan="<?= $cols; ?>">
                                <?= $this->mywords->n2w($inv->grand_total-$inv->paid); ?>
                            </th>
                            <th class="text-right text-warning" colspan="2">
                                <?= (isset($client) && !empty($client)) ? lang('due') : lang('balance'); ?>
                                (<?= $Settings->currency_prefix; ?>)
                            </th>
                            <th class="text-right text-warning">
                                <?= $this->sim->formatMoney($inv->grand_total-$inv->paid); ?>
                            </th>
                        </tr>

                    </tfoot> 

                </table>
            </div>

            <div style="clear: both;"></div>
            <div class="col-xs-12">    
                <div class="row"> 
                    <div class="col-xs-12">    
                        <?php 
                        if($inv->note && $inv->note != "<br>" && $inv->note != " " && $inv->note != "<p></p>" ) { 
                            ?>
                            <p>&nbsp;</p>
                            <div class="well well-sm">
                                <p class="lead"><?= lang("note"); ?>:</p>
                                <p><?= $inv->note; ?></p>
                            </div>
                            <?php 
                        } 
                        ?>
                    </div>

                    <div style="clear: both;"></div>
                    <div class="col-xs-4 pull-left"> 
                        <?php 
                        if($biller->ss_image) { 
                            ?>
                            <img src="<?= base_url('uploads/'.$biller->ss_image); ?>" alt="" />
                            <?php 
                        } else { 
                            ?>
                            <p>&nbsp;</p>
                            <p>&nbsp;</p>
                            <p>&nbsp;</p>
                            <p>&nbsp;</p>
                            <?php 
                        } 
                        ?>
                        <p style="border-bottom: 1px solid #999;">&nbsp;</p>
                        <p><?= lang("signature")." &amp; ".lang("stamp"); ; ?></p>
                    </div>

                    <div class="col-xs-4 pull-right"> 
                        <p>&nbsp;</p>
                        <p>
                            <?= lang("buyer"); ?>: 
                            <?php 
                            if($customer->company != "-") { echo $customer->company; } else { echo $customer->name; } 
                            ?>
                        </p>
                        <p>&nbsp;</p>
                        <p>&nbsp;</p>
                        <p style="border-bottom: 1px solid #999;">&nbsp;</p>
                        <p><?= lang("signature")." &amp; ".lang("stamp"); ; ?></p>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="col-xs-12" style="margin-top: 15px;">
            <?php
            if (isset($client) && !empty($client)) {
                echo '<a class="btn btn-primary btn-block" href="'.site_url('clients/pdf?id='.$inv->id).'">'.lang('download_pdf').'</a>';
            }
            ?>
                <?php 
                if($Settings->print_payment) { if(!empty($payment)) {
                    ?>
                    <div class="page-break"></div>
                    <h4><?= lang("payment_details"); ?> (<?= $page_title." ".lang("no")." ".$inv->id; ?>)</h4>
                    <table class="table table-bordered table-condensed table-hover table-striped" style="margin-bottom: 5px;">

                        <thead> 
                            <tr> 
                                <th><?= lang("date"); ?></th> 
                                <th><?= lang("amount"); ?></th> 
                                <th><?= lang("note"); ?></th> 
                            </tr> 
                        </thead> 
                        <tbody>
                            <?php 
                            foreach ($payment as $p) { 
                                ?>
                                <tr> 
                                    <td><?= $this->sim->hrsd($p->date); ?></td> 
                                    <td><?= $this->sim->formatMoney($p->amount); ?></td> 
                                    <td><?= $p->note; ?></td> 
                                </tr> 
                                <?php 
                            }
                            ?>
                        </tbody>
                    </table>    
                    <?php 
                } 
            }
            ?>
        </div>
    </div>
</div>
</body>
</html>