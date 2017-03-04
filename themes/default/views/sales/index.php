<?php $v = '';
if ($customer_id) {$v .= '&customer_id=' . $customer_id;}
?>

<script>
    $(document).ready(function() {
        function status(x) {
            var st = x.split('-');
            switch (st[0]) {
                case 'paid':
                return '<div class="text-center"><small><a id="'+st[1]+'" href="#myModal" role="button" data-toggle="modal" class="st"><span class="label'+st[1]+' label label-success"><?=lang('paid');?></span></a></small></div>';
                break;

                case 'partial':
                return '<div class="text-center"><small><a id="'+st[1]+'" href="#myModal" role="button" data-toggle="modal" class="st"><span class="label'+st[1]+' label label-info"><?=lang('partial');?></span></a></small></div>';
                break;

                case 'pending':
                return '<div class="text-center"><small><a id="'+st[1]+'" href="#myModal" role="button" data-toggle="modal" class="st"><span class="label'+st[1]+' label label-warning"><?=lang('pending');?></span></a></small></div>';
                break;

                case 'overdue':
                return '<div class="text-center"><small><a id="'+st[1]+'" href="#myModal" role="button" data-toggle="modal" class="st"><span class="label'+st[1]+' label label-danger"><?=lang('overdue');?></span></a></small></div>';
                break;

                case 'canceled':
                return '<div class="text-center"><small><a id="'+st[1]+'" href="#myModal" role="button" data-toggle="modal" class="st"><span class="label'+st[1]+' label label-danger"><?=lang('canceled');?></span></a></small></div>';
                break;

                default:
                return '<div class="text-center"><a id="'+st[1]+'" href="#myModal" role="button" data-toggle="modal" class="st">'+st[0]+'</a></div>';

            }
        }

        function recurring(x) {
            if( x == '' || x == 0 || x == null) {
                return '<div class="text-center"><i class="fa fa-times"></i></div>';
            } else if(x == -1) {
                return '<div class="text-center"><i class="fa fa-check"></i></div>';
            } else if(x == 1) {
                return '<div class="text-center"><?=lang('daily');?></div>';
            } else if(x == 2) {
                return '<div class="text-center"><?=lang('weekly');?></div>';
            } else if(x == 3) {
                return '<div class="text-center"><?=lang('monthly');?></div>';
            } else if(x == 4) {
                return '<div class="text-center"><?=lang('quarterly');?></div>';
            } else if(x == 5) {
                return '<div class="text-center"><?=lang('semiannually');?></div>';
            } else if(x == 6) {
                return '<div class="text-center"><?=lang('annually');?></div>';
            } else if(x == 7) {
                return '<div class="text-center"><?=lang('biennially');?></div>';
            } else {
                return '<div class="text-center"><i class="fa fa-times"></i></div>';
            }
        }

        var inv_id;

        var table = $('#fileData').DataTable( {

            "dom": '<"text-center"<"btn-group"B>><"clear"><"row"<"col-md-6"l><"col-md-6 pr0"p>r>t<"row"<"col-md-6"i><"col-md-6"p>><"clear">',
            "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            "order": [[ 0, "desc" ], [ 1, "desc" ]],
            "pageLength": <?=$Settings->rows_per_page;?>,
            "processing": true, "serverSide": true,
            // 'ajax': '<?=site_url('sales/getdatatableajax/' . $v);?>',
            'ajax' : { url: '<?=site_url('sales/getdatatableajax/' . $v);?>', type: 'POST', "data": function ( d ) {
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
            { "data": "sid", "visible": false },
            { "data": "date", "render": fld },
            { "data": "company_name" },
            { "data": "reference_no" },
            { "data": "user", "visible": false },
            { "data": "customer_name" },
            { "data": "grand_total", "render": cf },
            { "data": "paid", "render": cf },
            { "data": "balance", "render": cf },
            { "data": "due_date", "render": fsd  },
            { "data": "status", "render": status },
            { "data": "recurring", "render": recurring, "visible": false },
            { "data": "Actions", "searchable": false, "orderable": false }
            ],
            "footerCallback": function (  tfoot, data, start, end, display ) {
                var api = this.api(), data;
                $(api.column(6).footer()).html( cf(api.column(6).data().reduce( function (a, b) { return pf(a) + pf(b); }, 0)) );
                $(api.column(7).footer()).html( cf(api.column(7).data().reduce( function (a, b) { return pf(a) + pf(b); }, 0)) );
                $(api.column(8).footer()).html( cf(api.column(8).data().reduce( function (a, b) { return pf(a) + pf(b); }, 0)) );
            },
            "rowCallback": function( row, data, index ) {
                $(row).attr('id', data.sid);
                $(row).addClass('invoice_link');
            }

        });

        $('#fileData').on("click", ".st", function(){
            inv_id = $(this).attr('id');
        });

        $('#fileData tfoot th:not(:last-child)').each(function () {
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

        var inv_st;
        $('#myModal').on('show.bs.modal', function () {
            inv_st = $('.label'+inv_id).text();
            if(inv_st == '<?=lang('paid');?>') {
                var r = confirm("<?=lang('paid_status_change');?>");
                if (r == false) {
                    return false;
                }
            }
            $('#new_status').val(inv_st);
        })

        $('#myModal').on("click", "#update_status", function(){
            $('#update_status').text('Loading...');
            var new_status = $('#new_status').val();
            if(new_status != inv_st) {
                $.ajax({
                    type: "post",
                    url: "<?=site_url('sales/update_status');?>",
                    data: { id: inv_id, status: new_status, <?=$this->security->get_csrf_token_name();?>: '<?=$this->security->get_csrf_hash()?>' },
                    success: function(data) {
                        location.reload();
                    },
                    error: function(){
                        alert('<?=lang('ajax_error');?>');
                        $('#update_status').text('<?=lang('update');?>');
                    }
                });
            } else { 
                alert('<?=lang('same_status');?>'); 
                $(this).text('<?=lang('update');?>');
                return false; 
            }
        });

        $('#fileData').on('click', '.add_payment', function() {
            var vid = $(this).attr('id');
            var cid = $(this).attr('data-customer');
            $('#vid').val(vid);
            $('#cid').val(cid);
            $('#payModal').modal();
            return false;
        });

        $('#payModal').on('click', '#add-payment', function() {
            $(this).text('Loading...');
            var vid = $('#vid').val();
            var cid = $('#cid').val();
            var note = $('#note').val();
            var date = $('#date').val();
            var amount = $('#amount').val();
            if(amount != '') {
                $.ajax({
                    type: "post",
                    url: "<?=site_url('sales/add_payment');?>",
                    data: { invoice_id: vid, customer_id: cid, amount: amount, note: note, date:date, <?=$this->security->get_csrf_token_name();?>: '<?=$this->security->get_csrf_hash()?>' },
                    success: function(data) {
                        location.reload();
                    },
                    error: function(){
                        alert('<?=lang('ajax_error');?>');
                    }
                });
            } else { 
                alert('<?=lang('no_amount');?>'); 
                $(this).text('<?=lang('add_payment');?>');
                return false; 
            }
        });

        $('#fileData').on('click', '.email_inv', function() {
            var id = $(this).attr('id');
            var cid = $(this).attr('data-customer');
            var bid = $(this).attr('data-company');
            $.getJSON( "<?=site_url('sales/getCE');?>", { cid: cid, bid: bid, <?=$this->security->get_csrf_token_name();?>: '<?=$this->security->get_csrf_hash()?>' }).done(function( json ) {
                $('#customer_email').val(json.ce);
                $('#subject').val('<?=lang("invoice_from");?> '+json.com);
            });
            $('#emailModalLabel').text('<?=lang("email") . " " . lang("invoice") . " " . lang("no");?> '+id);
            // $('#subject').val('<?=lang("invoice") . " from " . $Settings->site_name;?>');
            $('#inv_id').val(id);
            $('#emailModal').modal();
            return false;
        });

        $('#emailModal').on('click', '#email_now', function() {
            $(this).text('Sending...');
            var vid = $('#inv_id').val();
            var to = $('#customer_email').val();
            var subject = $('#subject').val();
            var note = $('#message').val();
            var cc = $('#cc').val();
            var bcc = $('#bcc').val();

            if(to != '') {
                $.ajax({
                    type: "post",
                    url: "<?=site_url('sales/send_email');?>",
                    data: { id: vid, to: to, subject: subject, note: note, cc: cc, bcc: bcc, <?=$this->security->get_csrf_token_name();?>: '<?=$this->security->get_csrf_hash()?>' },
                    success: function(data) {
                        alert(data);
                    },
                    error: function(){
                        alert('<?=lang('ajax_error');?>');
                    }
                });
            } else { alert('<?=lang('to');?>'); }
            $('#emailModal').modal('hide');
            $(this).text('<?=lang('send_email');?>');
            return false;

        });

    });
</script>

<div class="page-head">
    <h2 class="pull-left"><?=$page_title;?> <span class="page-meta"><?=lang("list_results");?></span> </h2>
</div>
<div class="clearfix"></div>
<div class="matter">
    <div class="container">
        <div class="table-responsive">
            <table id="fileData" class="table sales table-bordered table-condensed table-hover table-striped" style="margin-bottom: 5px;">
                <thead>
                <tr class="active">
                    <th style="width:25px;"><?=lang("id");?></th>
                    <th class="col-xs-1"><?=lang("date");?></th>
                    <th class="col-xs-2"><?=lang("billing_company");?></th>
                    <th class="col-xs-1"><?=lang("reference_no");?></th>
                    <th class="col-xs-1"><?=lang("created_by");?></th>
                    <th class="col-xs-2"><?=lang("customer");?></th>
                    <th class="col-xs-1"><?=lang("total");?></th>
                    <th class="col-xs-1"><?=lang("paid");?></th>
                    <th class="col-xs-1"><?=lang("balance");?></th>
                    <th class="col-xs-1"><?=lang("due_date");?></th>
                    <th class="col-xs-1"><?=lang("status");?></th>
                    <th><?=lang("recurring");?></th>
                    <th style="min-width:80px; text-align:center;"><?=lang("actions");?></th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td colspan="13" class="dataTables_empty"><?=lang('loading_data_from_server');?></td>
                </tr>
                </tbody>
                <tfoot>
                <tr>
                    <th style="width:25px;"><?=lang("id");?></th>
                    <th class="col-xs-1">yyyy-mm-dd</th>
                    <th class="col-xs-2"><?=lang("billing_company");?></th>
                    <th class="col-xs-1"><?=lang("reference_no");?></th>
                    <th class="col-xs-1"><?=lang("created_by");?></th>
                    <th class="col-xs-2"><?=lang("customer");?></th>
                    <th class="col-xs-1"><?=lang("total");?></th>
                    <th class="col-xs-1"><?=lang("paid");?></th>
                    <th class="col-xs-1"><?=lang("balance");?></th>
                    <th class="col-xs-1">yyyy-mm-dd</th>
                    <th class="col-xs-1"><?=lang("status");?></th>
                    <th><?=lang("recurring");?></th>
                    <th style="min-width:80px; text-align:center;"><?=lang("actions");?></th>
                </tr>
                <tr>
                    <td colspan="13" class="p0"><input type="text" class="form-control b0" name="search_table" id="search_table" placeholder="<?= lang('type_hit_enter'); ?>" style="width:100%;"></td>
                </tr>
                </tfoot>
            </table>
        </div>
        <p><a href="<?=site_url('sales/add');?>" class="btn btn-primary"><?=lang("add_invoice");?></a></p>

        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel"><?=lang('update_invoice_status');?></h4>
                    </div>
                    <div class="modal-body">
                        <p class="red"><?=lang("status_change_x_payment");?></p>
                        <div class="control-group">
                            <label class="control-label" for="new_status"><?=lang("new_status");?></label>
                            <div class="controls" id="change_status">
                                <?php

$st = array(
    '' => lang("select") . " " . lang("status"),
    'canceled' => lang('canceled'),
    'overdue' => lang('overdue'),
    'paid' => lang('paid'),
    'pending' => lang('pending'),
);

echo form_dropdown('new_status', $st, '', 'class="new-status form-control select" id="new_status"');?>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn" data-dismiss="modal" aria-hidden="true"><?=lang('close');?></button>
                        <button class="btn btn-primary" id="update_status"><?=lang('update');?></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="payModal" tabindex="-1" role="dialog" aria-labelledby="payModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel"><?=lang('add_payment');?></h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="date"><?=lang("date");?></label>
                            <div class="controls"> <?=form_input('date', (isset($_POST['date']) ? $_POST['date'] : ""), 'class="form-control date" id="date"');?> </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="amount"><?=lang("amount_paid");?></label>
                            <div class="controls"> <?=form_input('amount', '', 'class="form-control" id="amount"');?> </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="note"><?=lang("note");?></label>
                            <div class="controls"> <?=form_textarea('note', '', 'class="form-control" id="note" style="height:100px;"');?> </div>
                        </div>
                        <input type="hidden" name="cid" value="" id="cid" />
                        <input type="hidden" name="vid" value="" id="vid" />
                    </div>
                    <div class="modal-footer">
                        <button class="btn" data-dismiss="modal" aria-hidden="true"><?=lang('close');?></button>
                        <button class="btn btn-primary" id="add-payment"><?=lang('add_payment');?></button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="emailModal" tabindex="-1" role="dialog" aria-labelledby="emailModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="emailModalLabel"></h4>
                    </div>
                    <div class="modal-body">

                        <div class="form-group">
                            <label for="customer_email"><?=lang("to");?></label>
                            <div class="controls"> <?=form_input('to', '', 'class="form-control" id="customer_email"');?></div>
                        </div>
                        <div id="extra" style="display:none;">
                            <div class="form-group">
                                <label for="cc"><?=lang("cc");?></label>
                                <div class="controls"> <?=form_input('cc', '', 'class="form-control" id="cc"');?></div>
                            </div>
                            <div class="form-group">
                                <label for="bcc"><?=lang("bcc");?></label>
                                <div class="controls"> <?=form_input('bcc', '', 'class="form-control" id="bcc"');?></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="subject"><?=lang("subject");?></label>
                            <div class="controls">
                                <?=form_input('subject', '', 'class="form-control" id="subject"');?> </div>
                        </div>
                        <div class="form-group">
                            <label for="message"><?=lang("message");?></label>
                            <div class="controls"> <?=form_textarea('note', lang("find_attached_invoice"), 'id ="message" class="form-control" placeholder="' . lang("add_note") . '" rows="3" style="margin-top: 10px; height: 100px;"');?> </div>
                        </div>
                        <input type="hidden" id="inv_id" value="" />
                    </div>
                    <div class="modal-footer">
                        <button class="btn pull-left" id="sh-btn"><?=lang('show_hide_cc');?></button>
                        <button class="btn" data-dismiss="modal" aria-hidden="true"><?=lang('close');?></button>
                        <button class="btn btn-primary" id="email_now"><?=lang('send_email');?></button>
                    </div>
                    <script type="text/javascript">
                        $(document).ready(function() {
                            $('#sh-btn').click(function(event) {
                                $('#extra').toggle();
                                $('#cc').val('<?=$this->session->userdata('email');?>');
                            });
                        });
                    </script>
                </div>

                <div class="clearfix"></div>
            </div>
            <div class="clearfix"></div>
        </div>
