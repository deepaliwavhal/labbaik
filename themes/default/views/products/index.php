<script>
$(document).ready(function() {

    var table = $('#fileData').DataTable( {

        "dom": '<"text-center"<"btn-group"B>><"clear"><"row"<"col-md-6"l><"col-md-6 pr0"p>r>t<"row"<"col-md-6"i><"col-md-6"p>><"clear">',
        "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
        "order": [[ 1, "asc" ]],
        "pageLength": <?=$Settings->rows_per_page;?>,
        "processing": true, "serverSide": true,
        // 'ajax': '<?=site_url('products/getdatatableajax');?>',
        'ajax' : { url: '<?=site_url('products/getdatatableajax');?>', type: 'POST', "data": function ( d ) {
            d.<?=$this->security->get_csrf_token_name();?> = "<?=$this->security->get_csrf_hash()?>";
        }},
        "buttons": [
        { extend: 'copyHtml5', exportOptions: { columns: [ 0, 1, 2, 3 ] } },
        { extend: 'excelHtml5', 'footer': true, exportOptions: { columns: [ 0, 1, 2, 3 ] } },
        { extend: 'csvHtml5', 'footer': true, exportOptions: { columns: [ 0, 1, 2, 3 ] } },
        { extend: 'pdfHtml5', orientation: 'landscape', pageSize: 'A4', 'footer': true, 
        exportOptions: { columns: [ 0, 1, 2, 3 ] } },
        { extend: 'colvis', text: 'Columns'},
        ],
        "columns": [
        { "data": "pid", "searchable": false, "visible": false },
        { "data": "product_name" },
        { "data": "details" },
        { "data": "price" },
        { "data": "tax_rate" },
        { "data": "Actions", "searchable": false, "orderable": false }
        ]

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
    <h2 class="pull-left"><?= $page_title; ?> <span class="page-meta"><?= lang("list_results"); ?></span> </h2>
</div>
<div class="clearfix"></div>
<div class="matter">
    <div class="container">

        <table id="fileData" class="table table-bordered table-hover table-striped">
            <thead>
                <tr>
                    <th class="col-xs-1"><?= lang("id"); ?></th>
                    <th class="col-xs-2"><?= lang("name"); ?></th>
                    <th><?= lang("details"); ?></th>
                    <th  class="col-xs-1"><?= lang("price"); ?></th>
                    <th  class="col-xs-1"><?= lang("tax_rate"); ?></th>
                    <th style="width:45px;"><?= lang("actions"); ?></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="6" class="dataTables_empty"><?= lang('loading_data_from_server'); ?></td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <th class="col-xs-1"><?= lang("id"); ?></th>
                    <th class="col-xs-2"><?= lang("name"); ?></th>
                    <th><?= lang("details"); ?></th>
                    <th  class="col-xs-1"><?= lang("price"); ?></th>
                    <th  class="col-xs-1"><?= lang("tax_rate"); ?></th>
                    <th style="width:100px;"><?= lang("actions"); ?></th>
                </tr>
                <tr>
                    <td colspan="6" class="p0"><input type="text" class="form-control b0" name="search_table" id="search_table" placeholder="<?= lang('type_hit_enter'); ?>" style="width:100%;"></td>
                </tr>
            </tfoot>
        </table>

        <p><a href="<?= site_url('products/add');?>" class="btn btn-primary"><?= lang("add_product"); ?></a></p>
        <div class="clearfix"></div>
    </div>
    <div class="clearfix"></div>
</div>

