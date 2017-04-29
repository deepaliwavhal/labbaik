<?php $v = '';
$v='id='.$package_group_id;
if ($customer_id) {$v .= '&customer_id=' . $customer_id;}
?>

<script>
    $(document).ready(function() {
        
        var inv_id;

        var table = $('#fileData').DataTable( {

            "dom": '<"text-center"<"btn-group"B>><"clear"><"row"<"col-md-6"l><"col-md-6 pr0"p>r>t<"row"<"col-md-6"i><"col-md-6"p>><"clear">',
            "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            "order": [[ 0, "desc" ], [ 1, "desc" ]],
            "pageLength": <?=$Settings->rows_per_page;?>,
            "processing": true, "serverSide": true,
            // 'ajax': '<?=site_url('trips/getdatatableajax/' . $v);?>',
            'ajax' : { url: '<?=site_url('trips/getdatatableajax?' . $v);?>', type: 'POST', "data": function ( d ) {
                d.<?=$this->security->get_csrf_token_name();?> = "<?=$this->security->get_csrf_hash()?>";
            }},
            "buttons": [
            { extend: 'copyHtml5', exportOptions: { columns: [ 1, 2, 3, 4, 5, 6,7, 8] } },
            { extend: 'excelHtml5', 'footer': true, exportOptions: { columns: [ 1, 2, 3, 4, 5, 6,7, 8] } },
            { extend: 'csvHtml5', 'footer': true, exportOptions: { columns: [ 1, 2, 3, 4, 5, 6,7, 8] } },
            { extend: 'pdfHtml5', orientation: 'landscape', pageSize: 'A4', 'footer': true, 
            exportOptions: { columns: [ 1, 2, 3, 4, 5, 6,7, 8 ] } },
            { extend: 'colvis', text: 'Columns'},
            ],
            "columns": [
            { "data": "id", "searchable": false, "visible": false },
            { "data": "name" },
            { "data": "price" },
            { "data": "total_days" },
            { "data": "max_capacity" },
            { "data": "fromdate" },
            { "data": "todate" },
            { "data": "country" },
            { "data": "city" },
            { "data": "Actions", "searchable": false, "orderable": false },
            ],
            
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
                    <th class="col-xs-1"><?=lang("name");?></th>
                    <th class="col-xs-1"><?=lang("price");?></th>
                    <th class="col-xs-1"><?=lang("total_days");?></th>
                    <!--<th class="col-xs-1"><?=lang("airline");?></th>-->
                    <th class="col-xs-1"><?=lang("max_capacity");?></th>
                    <th class="col-xs-1"><?=lang("fromdate");?></th>
                    <th class="col-xs-1"><?=lang("todate");?></th>
                    <th class="col-xs-1"><?=lang("country");?></th>
                    <th class="col-xs-1"><?=lang("city");?></th>
                    <th style="width:150px;"><?= lang("actions"); ?></th>
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
                    <th class="col-xs-1">Name</th>
                     <th class="col-xs-1"><?=lang("price");?></th>
                    <th class="col-xs-1"><?=lang("total_days");?></th>
                    <!--<th class="col-xs-1"><?=lang("airline");?></th>-->
                    <th class="col-xs-1"><?=lang("max_capacity");?></th>
                    <th class="col-xs-1"><?=lang("country");?></th>
                    <th class="col-xs-1"><?=lang("fromdate");?></th>
                    <th class="col-xs-1"><?=lang("todate");?></th>
                    <th class="col-xs-1"><?=lang("city");?></th>
                    <th style="width:150px;"><?= lang("actions"); ?></th>
                </tr>
                <tr>
                    <td colspan="13" class="p0"><input type="text" class="form-control b0" name="search_table" id="search_table" placeholder="<?= lang('type_hit_enter'); ?>" style="width:100%;"></td>
                </tr>
                </tfoot>
            </table>
        </div>
        <p><a href="<?=site_url('trips/add?group_id='.$package_group_id);?>" class="btn btn-primary"><?=lang("add_trip");?></a></p>

        
        

        