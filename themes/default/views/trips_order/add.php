<?php 
foreach($tax_rates as $tax){
    $tr[$tax->id] = $tax->name;
}
?>
<style type="text/css">
@media only screen and (max-width: 760px), (min-device-width: 768px) and (max-device-width: 1024px)  {
    #dyTable tbody td:nth-of-type(1):before { content: "<?= lang('no'); ?>"; }
    #dyTable tbody td:nth-of-type(2):before { content: "<?= lang('quantity'); ?>"; }
    #dyTable tbody td:nth-of-type(3):before { content: "<?= lang('product_code'); ?>"; }
    #dyTable tbody td:nth-of-type(4):before { content: "<?= lang('unit_price'); ?>"; }
    #dyTable tbody td:nth-of-type(5):before { content: "<?= lang('discount'); ?>"; }
    #dyTable tbody td:nth-of-type(6):before { content: "<?= lang('tax_rate'); ?>"; }
    #dyTable tbody td:nth-of-type(7):before { content: "<?= lang('subtotal'); ?>"; }
}
</style>
<script type="text/javascript">

    var counter = <?= $Settings->no_of_rows+1; ?>, no_of_rows = <?= $Settings->no_of_rows+1; ?>,
        default_tax_rate = <?= $Settings->default_tax_rate; ?>, tax_rates = <?=json_encode($tax_rates)?>;
    var total = 0, order_tax = 0, order_discount = 0, grand_total = 0;

</script>


<div class="page-head">
    <h2 class="pull-left"><?= $page_title; ?> <span class="page-meta"><?= lang("enter_info"); ?></span> </h2>
</div>
<div class="clearfix"></div>
<div class="matter">
    <div class="container">
        <?php $attrib = array('class' => 'form-horizontal'); echo form_open("sales/add");?>

        <?php include('form.php'); ?>

        <div class="form-group">
            <?= form_submit('submit', lang("add_invoice"), 'class="btn btn-primary btn-lg"');?>
        </div>
        <?= form_close();?>

        <div class="clearfix"></div>
    </div>
    <div class="clearfix"></div>
</div>
