<?php
$v = "?v=1";
if($this->input->post('submit')) {
    if($this->input->post('customer')){
        $v .= "&customer=".$this->input->post('customer');
    } 
    if($this->input->post('cf')){
        $v .= "&cf=".$this->input->post('cf');
    } 
    if($this->input->post('start_date')){
        $v .= "&start_date=".$this->input->post('start_date');
    }
    if($this->input->post('end_date')) {
        $v .= "&end_date=".$this->input->post('end_date');
    }
    if($this->input->post('note')){
        $v .= "&note=".$this->input->post('note');
    }

}
?>
<script type="text/javascript">

    $(document).ready(function(){

        $("form select").chosen({no_results_text: "No results matched", disable_search_threshold: 5, allow_single_deselect:true});

        <?php if($this->input->post('submit')) { echo "$('.form').hide();"; } ?>
        $(".show_hide").slideDown('slow');

        $('.show_hide').click(function(){
            $(".form").slideToggle();
            return false;
        });

        var table = $('#fileData').DataTable( {

            "dom": '<"text-center"<"btn-group"B>><"clear"><"row"<"col-md-6"l><"col-md-6"p>r>t<"row"<"col-md-6"i><"col-md-6"p>><"clear">',
            "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            "order": [[ 0, "desc" ], [ 1, "desc" ]],
            "pageLength": <?=$Settings->rows_per_page;?>,
            "processing": true, "serverSide": true,
            // 'ajax': '<?=site_url('reports/getpayments/'.$v);?>',
            'ajax' : { url: '<?=site_url('reports/getpayments/'.$v);?>', type: 'POST', "data": function ( d ) {
                d.<?=$this->security->get_csrf_token_name();?> = "<?=$this->security->get_csrf_hash()?>";
            }},
            "buttons": [
            { extend: 'copyHtml5', exportOptions: { columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10 ] } },
            { extend: 'excelHtml5', 'footer': true, exportOptions: { columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10 ] } },
            { extend: 'csvHtml5', 'footer': true, exportOptions: { columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10 ] } },
            { extend: 'pdfHtml5', orientation: 'landscape', pageSize: 'A4', 'footer': true, 
            exportOptions: { columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10 ] } },
            { extend: 'colvis', text: 'Columns'},
            ],
            "columns": [
            { "data": "date", "render": fsd },
            { "data": "invoice_id" },
            { "data": "company" },
            { "data": "user" },
            { "data": "amount", "render": cf },
            { "data": "note" }
            ],
            "footerCallback": function (  tfoot, data, start, end, display ) {
                var api = this.api(), data;
                $(api.column(4).footer()).html( cf(api.column(4).data().reduce( function (a, b) { return pf(a) + pf(b); }, 0)) );
            }

        });

        $('#fileData tfoot th').each(function () {
            var title = $(this).text();
            $(this).html( '<input type="text" class="text_filter" placeholder="'+title+'" />' );
        });

        $('#search_table').on( 'keyup change', function (e) {
            var code = (e.keyCode ? e.keyCode : e.which);
            if (((code == 13 && table.search() !== this.value) || (table.search() !== '' && this.value === ''))) {
                table.search( this.value ).draw();
            }
        });

        table.columns().every(function () {
            var self = this;
            $( 'input', this.footer() ).on( 'keyup change', function (e) {
                var code = (e.keyCode ? e.keyCode : e.which);
                if (((code == 13 && self.search() !== this.value) || (self.search() !== '' && this.value === ''))) {
                    self.search( this.value ).draw();
                }
            });
        });

    });

</script>

<div class="page-head">
    <h2 class="pull-left"><?= $page_title; ?> <span class="page-meta"><a href="#" class="btn btn-primary btn-xs show_hide"><?= lang("show_hide"); ?></a></span> </h2>
</div>
<div class="clearfix"></div>
<div class="matter">
    <div class="container">
        <div class="form">

            <p>Please customise the report below.</p>
            <?php $attrib = array('class' => 'form-horizontal'); echo form_open("reports/payments"); ?>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="customer"><?= lang("customer"); ?></label>
                        <div class="controls">
                            <?php 
                            $cu[""] = lang("select")." ".lang("customer");
                            foreach($customers as $customer){
                                $cu[$customer->id] = $customer->company .' ('.$customer->name.')';
                            }
                            echo form_dropdown('customer', $cu, (isset($_POST['customer']) ? $_POST['customer'] : ""), 'class="form-control customer" data-placeholder="'.lang("select")." ".lang("customer").'" id="customer" style="width:100%;"');  ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <?= lang('cfs', 'cf'); ?>
                        <?= form_input('cf', set_value('cf'), 'class="form-control tip" id="cf"'); ?>
                    </div>

                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="start_date"><?= lang("start_date"); ?></label>
                        <div class="controls"> <?= form_input('start_date', (isset($_POST['start_date']) ? $_POST['start_date'] : ""), 'class="form-control date" id="start_date"');?> </div>
                    </div>
                    <div class="form-group">
                        <label for="end_date"><?= lang("end_date"); ?></label>
                        <?php $date = date($dateFormats['php_sdate']); ?>
                        <div class="controls"> <?= form_input('end_date', (isset($_POST['end_date']) ? $_POST['end_date'] : $this->sim->hrsd($date)), 'class="form-control date" id="end_date"');?> </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="start_date"><?= lang("note"); ?></label>
                <div class="controls"> <?= form_input('note', (isset($_POST['note']) ? $_POST['note'] : ""), 'class="form-control" id="note"');?> </div>
            </div>

            <div class="form-group">
                <div class="controls"> <?= form_submit('submit', lang("submit"), 'class="btn btn-primary"');?> </div>
            </div>
            <?= form_close();?>

        </div>
        <div class="clearfix"></div>
        <?php if($this->input->post('submit')) { ?>
        <?php if($this->input->post('customer')){ ?>
        <div class="widget wlightblue"> 
            <div class="widget-head">
                <div class="pull-left"><?= lang('name').": <strong>".$cus->name."</strong> &nbsp;&nbsp;&nbsp;&nbsp;".lang('email').": <strong>".$cus->email."</strong> &nbsp;&nbsp;&nbsp;&nbsp;".lang('phone').": <strong>".$cus->phone."</strong>"; ?></div>
                <div class="widget-icons pull-right"> <a class="wminimize" href="#"><i class="icon-chevron-up"></i></a> <a class="wclose" href="#"><i class="icon-remove"></i></a> </div>
                <div class="clearfix"></div>
            </div>

            <div class="widget-content">
                <div class="padd">
                    <ul class="today-datas">
                        <li class="bviolet"> <span class="bold" style="font-size:24px;">
                            <?php /* echo $Settings->currency_prefix." ".$total['total_amount']; */ ?>
                            <?= $total; ?></span><br>
                            <?= lang('total'); ?> <?= lang('invoices'); ?>
                            <div class="clearfix"></div>
                        </li>
                        <li class="bgreen"> <span class="bold" style="font-size:24px;">
                            <?php /* echo $Settings->currency_prefix." ".$paid['total_amount'];*/ ?>
                            <?= $paid; ?></span><br>
                            <?= lang('paid'); ?>
                            <div class="clearfix"></div>
                        </li>
                        <li class="bblue"> <span class="bold" style="font-size:24px;"><?= $pp; ?></span><br>
                            <?= lang('partially_paid'); ?>
                            <div class="clearfix"></div>
                        </li>
                        <li class="borange"> <span class="bold" style="font-size:24px;"><?= $pending; ?></span><br>
                            <?= lang('pending'); ?>
                            <div class="clearfix"></div>
                        </li>
                        <li class="bred"> <span class="bold" style="font-size:24px;"><?= $overdue; ?></span><br>
                            <?= lang('overdue'); ?>
                            <div class="clearfix"></div>
                        </li>
                        <li class="bred" style="background:#000 !important;"> <span class="bold" style="font-size:24px;"><?= $cancelled; ?></span><br>
                            <?= lang('cancelled'); ?>
                            <div class="clearfix"></div>
                        </li>
                    </ul>
                    <hr />
                    <ul class="today-datas t">
                        <li class="bviolet"> <span class="bold" style="font-size:24px;">
                            <?php /* echo $Settings->currency_prefix." ".$total['total_amount']; */ ?>
                            <?= $this->sim->formatMoney($tpp->total); ?></span><br>
                            <?= lang('total'); ?> <?= lang('amount'); ?>
                            <div class="clearfix"></div>
                        </li>
                        <li class="bgreen"> <span class="bold" style="font-size:24px;">
                            <?php /* echo $Settings->currency_prefix." ".$paid['total_amount'];*/ ?>
                            <?= $this->sim->formatMoney($tpp->paid); ?></span><br>
                            <?= lang('paid'); ?> <?= lang('amount'); ?>
                            <div class="clearfix"></div>
                        </li>
                        <li class="borange"> <span class="bold" style="font-size:24px;"><?= $this->sim->formatMoney(($tpp->total - $tpp->paid)); ?></span><br>
                            <?= lang('balance'); ?> <?= lang('amount'); ?>
                            <div class="clearfix"></div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <?php } ?>

        <table id="fileData" cellpadding=0 cellspacing=10 class="table table-bordered table-hover table-striped" style="margin-bottom: 5px;">
            <thead>
                <tr class="active">
                    <th class="col-xs-1"><?= lang("date"); ?></th>
                    <th class="col-xs-1"><?= lang("invoice").' '.lang("no"); ?></th>
                    <th class="col-xs-2"><?= lang("customer"); ?></th>
                    <th class="col-xs-1"><?= lang("added_by"); ?></th>
                    <th class="col-xs-1"><?= lang("amount"); ?></th>
                    <th class="col-xs-6"><?= lang("note"); ?></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="7" class="dataTables_empty"><?= lang('loading_data_from_server'); ?></td>
                </tr>
            </tbody>

            <tfoot>
                <tr>
                    <th class="col-xs-1"><?= lang("date"); ?></th>
                    <th class="col-xs-1"><?= lang("invoice").' '.lang("no"); ?></th>
                    <th class="col-xs-2"><?= lang("customer"); ?></th>
                    <th class="col-xs-1"><?= lang("added_by"); ?></th>
                    <th class="col-xs-1"><?= lang("amount"); ?></th>
                    <th class="col-xs-6"><?= lang("note"); ?></th>
                </tr>
                <tr>
                    <td colspan="11" class="p0"><input type="text" class="form-control b0" name="search_table" id="search_table" placeholder="<?= lang('type_hit_enter'); ?>" style="width:100%;"></td>
                </tr>
            </tfoot>
        </table>
        <?php 
    }
    ?>
    <div class="clearfix"></div>
</div>
<div class="clearfix"></div>
</div>
