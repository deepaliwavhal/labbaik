<script>
$(document).ready(function() {

    var table = $('#fileData').DataTable( {

        "dom": '<"text-center"<"btn-group"B>><"clear"><"row"<"col-md-6"l><"col-md-6 pr0"p>r>t<"row"<"col-md-6"i><"col-md-6"p>><"clear">',
        "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
        "order": [[ 2, "asc" ], [ 1, "asc" ]],
        "pageLength": <?=$Settings->rows_per_page;?>,
        "processing": true, "serverSide": true,
        // 'ajax': '<?=site_url('customers/getdatatableajax');?>',
        'ajax' : { url: '<?=site_url('customers/getdatatableajax');?>', type: 'POST', "data": function ( d ) {
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
        { "data": "id", "searchable": false, "visible": false },
        { "data": "name" },
        { "data": "company" },
        { "data": "phone" },
        { "data": "email" },
        { "data": "city" },
        { "data": "country" },
        { "data": "Actions", "searchable": false, "orderable": false },
        { "data": "login", "searchable": false, "orderable": false<?= $this->sim->in_group('admin') ? '' : ', "visible": false '; ?> }
        ]

    });

    $('#fileData tfoot th:not(:last-child, :nth-last-child(2))').each(function () {
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

		<table id="fileData" cellpadding=0 cellspacing=10 class="table table-bordered table-hover table-striped">
			<thead>
				<tr>
					<th><?= lang("id"); ?></th>
					<th><?= lang("name"); ?></th>
					<th><?= lang("company"); ?></th>
					<th><?= lang("phone"); ?></th>
					<th><?= lang("email_address"); ?></th>
					<th><?= lang("city"); ?></th>
					<th><?= lang("country"); ?></th>
					<th style="width:150px;"><?= lang("actions"); ?></th>
					<th style="width:50px;"><?= lang("login"); ?></th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td colspan="9" class="dataTables_empty"><?= lang('loading_data_from_server'); ?></td>
				</tr>
			</tbody>
			<tfoot>
				<tr>
					<th><?= lang("id"); ?></th>
					<th><?= lang("name"); ?></th>
					<th><?= lang("company"); ?></th>
					<th><?= lang("phone"); ?></th>
					<th><?= lang("email_address"); ?></th>
					<th><?= lang("city"); ?></th>
					<th><?= lang("country"); ?></th>
					<th style="width:150px;"><?= lang("actions"); ?></th>
					<th style="width:50px;"><?= lang("login"); ?></th>
				</tr>
				<tr>
				    <td colspan="9" class="p0"><input type="text" class="form-control b0" name="search_table" id="search_table" placeholder="<?= lang('type_hit_enter'); ?>" style="width:100%;"></td>
				</tr>
			</tfoot>
		</table>

		<p><a href="<?= site_url('customers/add');?>" class="btn btn-primary"><?= lang("add_customer"); ?></a></p>
		<div class="clearfix"></div>
	</div>
	<div class="clearfix"></div>
</div>

