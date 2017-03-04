<script>
    $(document).ready(function() {
        var inv_id;

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

        var table = $('#fileData').DataTable( {

            "dom": '<"text-center"<"btn-group"B>><"clear"><"row"<"col-md-6"l><"col-md-6 pr0"p>r>t<"row"<"col-md-6"i><"col-md-6"p>><"clear">',
            "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            "order": [[ 0, "desc" ], [ 1, "desc" ]],
            "pageLength": <?=$Settings->rows_per_page;?>,
            "processing": true, "serverSide": true,
            // 'ajax': '<?=site_url('clients/get_sales');?>',
            'ajax' : { url: '<?=site_url('clients/get_sales');?>', type: 'POST', "data": function ( d ) {
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
            { "data": "customer_name", "visible": false  },
            { "data": "grand_total", "render": cf },
            { "data": "paid", "render": cf },
            { "data": "balance", "render": cf },
            { "data": "due_date", "render": fsd  },
            { "data": "status", "render": status },
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
    <h2><?= $page_title; ?></h2>
    <span class="page-meta"><?= lang("list_results"); ?></span>
</div>
<div class="clearfix"></div>
<div class="matter">
    <div class="container">
        <div class="table-responsive">
            <table id="fileData" class="table table-bordered table-condensed table-hover table-striped" style="margin-bottom: 0px;">
                <thead>
                    <tr class="active">
                        <th class="col-xs-1"><?= lang("id"); ?></th>
                        <th class="col-xs-1"><?= lang("date"); ?></th>
                        <th class="col-xs-2"><?= lang("billing_company"); ?></th>
                        <th class="col-xs-1"><?= lang("reference_no"); ?></th>
                        <th class="col-xs-1"><?= lang("created_by"); ?></th>
                        <th class="col-xs-2"><?= lang("customer"); ?></th>
                        <th class="col-xs-1"><?= lang("total"); ?></th>
                        <th class="col-xs-1"><?= lang("paid"); ?></th>
                        <th class="col-xs-1"><?= lang("due"); ?></th>
                        <th class="col-xs-1"><?= lang("due_date"); ?></th>
                        <th class="col-xs-1"><?= lang("status"); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="11" class="dataTables_empty"><?= lang("loading_data_from_server"); ?></td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <th class="col-xs-1"><?= lang("id"); ?></th>
                        <th class="col-xs-1">yyyy-mm-dd</th>
                        <th class="col-xs-2"><?= lang("billing_company"); ?></th>
                        <th class="col-xs-1"><?= lang("reference_no"); ?></th>
                        <th class="col-xs-1"><?= lang("created_by"); ?></th>
                        <th class="col-xs-2"><?= lang("customer"); ?></th>
                        <th class="col-xs-1"><?= lang("total"); ?></th>
                        <th class="col-xs-1"><?= lang("paid"); ?></th>
                        <th class="col-xs-1"><?= lang("due"); ?></th>
                        <th class="col-xs-1">yyyy-mm-dd</th>
                        <th class="col-xs-1"><?= lang("status"); ?></th>
                    </tr>
                    <tr>
                        <td colspan="11" class="p0"><input type="text" class="form-control b0" name="search_table" id="search_table" placeholder="<?= lang('type_hit_enter'); ?>" style="width:100%;"></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

