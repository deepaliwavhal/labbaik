<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
    <div class="modal-body">
<div id="wrap">
    <img src="<?= base_url(); ?>uploads/<?= $biller->logo ? $biller->logo : $Settings->logo; ?>" alt="<?= $biller->company ? $biller->company : $Settings->site_name ?>" />
    <div class="row">
        <div class="col-xs-5">
            <?= lang("from"); ?>:
            <h3><?= $biller->company; ?></h3>
            <?= $biller->address.",<br />".$biller->city.", ".$biller->postal_code.", ".$biller->state.",<br />".$biller->country;
            echo "<br />".lang("tel").": ".$biller->phone."<br />".lang("email").": ".$biller->email;
            if($biller->cf1 && $biller->cf1 != "-") { echo "<br />".lang("cf1").": ".$biller->cf1; }
            if($biller->cf2 && $biller->cf2 != "-") { echo "<br />".lang("cf2").": ".$biller->cf2; }
            if($biller->cf3 && $biller->cf3 != "-") { echo "<br />".lang("cf3").": ".$biller->cf3; }
            if($biller->cf4 && $biller->cf4 != "-") { echo "<br />".lang("cf4").": ".$biller->cf4; }
            if($biller->cf5 && $biller->cf5 != "-") { echo "<br />".lang("cf5").": ".$biller->cf5; }
            if($biller->cf6 && $biller->cf6 != "-") { echo "<br />".lang("cf6").": ".$biller->cf6; }
            ?>

        </div>

        <div class="col-xs-5">

            <?= lang("to"); ?>:
            <h3><?php if($customer->company != "-") { echo $customer->company; } else { echo $customer->name; } ?></h3>
            <?php if($customer->company != "-") { echo "<p>Attn: ".$customer->name."</p>"; } ?>

            <?php if($customer->address != "-") { echo  lang("address").": ".$customer->address.", ".$customer->city.", ".$customer->postal_code.", ".$customer->state.", ".$customer->country; } ?><br>
            <?= lang("tel").": ".$customer->phone; ?><br>
            <?= lang("email").": ".$customer->email; ?><br>
            <?php
            if($customer->cf1 && $customer->cf1 != "-") { echo "<br />".lang("cf1").": ".$customer->cf1; }
            if($customer->cf2 && $customer->cf2 != "-") { echo "<br />".lang("cf2").": ".$customer->cf2; }
            if($customer->cf3 && $customer->cf3 != "-") { echo "<br />".lang("cf3").": ".$customer->cf3; }
            if($customer->cf4 && $customer->cf4 != "-") { echo "<br />".lang("cf4").": ".$customer->cf4; }
            if($customer->cf5 && $customer->cf5 != "-") { echo "<br />".lang("cf5").": ".$customer->cf5; }
            if($customer->cf6 && $customer->cf6 != "-") { echo "<br />".lang("cf6").": ".$customer->cf6; }
            ?>

        </div>
    </div>
    <div style="clear: both;"></div>
    <p>&nbsp;</p>
    <div class="row">
        <div class="col-xs-6">
            <p style="font-weight:bold;"><?= lang("date"); ?>: <?= $this->sim->hrsd($payment->date); ?></p>

        </div>
        <p>&nbsp;</p>
        <div style="clear: both; height: 15px;"></div>
    </div>
    <div class="well">
        <table class="table table-striped print-full" style="margin-bottom:0;">
            <tbody>
            <tr>
                <td><h2><?= lang("payment_received"); ?></h2></td>
                <td class="text-right"><h2 class="text-right"><?= $payment->amount; ?></h2></td>
            </tr>
            <?php if (!empty($payment->note)) { ?>
            <tr>
                <td colspan="2"><?= $payment->note; ?></td>
            </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
    <div style="clear: both; height: 15px;"></div>
    <div class="row">
        <div class="col-xs-4 pull-left">
            <?php if($biller->ss_image) { ?>
                <img src="<?= $assets; ?>/img/<?= $biller->ss_image; ?>" alt="" />
            <?php } else { ?>
                <p>&nbsp;</p>
                <p>&nbsp;</p>
                <p>&nbsp;</p>
                <p>&nbsp;</p>
            <?php } ?>
            <p style="border-bottom: 1px solid #666;">&nbsp;</p>
            <p><?= lang("signature")." &amp; ".lang("stamp"); ; ?></p>
        </div>

        <div class="clearfix"></div>
    </div>
</div>

</div>
</div>
</div>