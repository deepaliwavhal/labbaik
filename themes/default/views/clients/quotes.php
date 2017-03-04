<script>
	$(document).ready(function() {
		function status(x) {
			switch (x) {
				case 'sent':
				return '<div class="text-center"><small><span class="label label-success"><?=lang('sent');?></span></small></div>';
				break;
				case 'ordered':
				return '<div class="text-center"><small><span class="label label-success"><?=lang('ordered');?></span></small></div>';
				break;
				case 'pending':
				return '<div class="text-center"><small><span class="label label-default"><?=lang('pending');?></span></small></div>';
				break;
				default:
				return '<div class="text-center"><small><span class="label'+x+' label label-default">'+x+'</span></small></div>';
			}
		}
		var table = $('#fileData').DataTable( {

			"dom": '<"text-center"<"btn-group"B>><"clear"><"row"<"col-md-6"l><"col-md-6 pr0"p>r>t<"row"<"col-md-6"i><"col-md-6"p>><"clear">',
			"lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
			"order": [[ 0, "desc" ], [ 1, "desc" ]],
			"pageLength": <?=$Settings->rows_per_page;?>,
			"processing": true, "serverSide": true,
		    // 'ajax': '<?=site_url('clients/get_quotes');?>',
		    'ajax' : { url: '<?=site_url('clients/get_quotes');?>', type: 'POST', "data": function ( d ) {
		    	d.<?=$this->security->get_csrf_token_name();?> = "<?=$this->security->get_csrf_hash()?>";
		    }},
		    "buttons": [
		    { extend: 'copyHtml5', exportOptions: { columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11 ] } },
		    { extend: 'excelHtml5', 'footer': true, exportOptions: { columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11 ] } },
		    { extend: 'csvHtml5', 'footer': true, exportOptions: { columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11 ] } },
		    { extend: 'pdfHtml5', orientation: 'landscape', pageSize: 'A4', 'footer': true, 
		    exportOptions: { columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11 ] } },
		    { extend: 'colvis', text: 'Columns'},
		    ],
		    "columns": [
		    { "data": "id", "visible": false },
		    { "data": "date", "render": fld },
		    { "data": "company_name" },
		    { "data": "reference_no" },
		    { "data": "user", "visible": false },
		    { "data": "customer_name", "visible": false },
		    { "data": "total", "render": cf, "visible": false },
		    { "data": "total_tax", "render": cf, "visible": false },
		    { "data": "shipping", "render": cf },
		    { "data": "discount", "render": cf, "visible": false },
		    { "data": "grand_total", "render": cf },
		    { "data": "expiry_date", "render": fsd, "visible": false },
		    ],
		    "rowCallback": function( row, data, index ) {
		    	$(row).attr('id', data.id);
		    	$(row).addClass('quote_link');
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
	<h2><?= $page_title; ?> </h2>
	<span class="page-meta"><?= lang("list_results"); ?></span>
</div>
<div class="clearfix"></div>
<div class="matter">
	<div class="container">
		<div class="table-responsive">
			<table id="fileData" cellpadding=0 cellspacing=10 class="table table-bordered table-hover table-striped" style="margin-bottom: 0px;">
				<thead>
					<tr class="active">
						<th class="col-xs-1"><?= lang("id"); ?></th>
						<th class="col-xs-1"><?= lang("date"); ?></th>
						<th class="col-xs-2"><?= lang("billing_company"); ?></th>
						<th class="col-xs-1"><?= lang("reference_no"); ?></th>
						<th class="col-xs-1"><?= lang("created_by"); ?></th>
						<th class="col-xs-2"><?= lang("customer"); ?></th>
						<th class="col-xs-1"><?= lang("total"); ?></th>
						<th class="col-xs-1"><?= lang("total_tax"); ?></th>
						<th class="col-xs-1"><?= lang("shipping"); ?></th>
						<th class="col-xs-1"><?= lang("discount"); ?></th>
						<th class="col-xs-1"><?= lang("grand_total"); ?></th>
						<th class="col-xs-1"><?= lang("expiry_date"); ?></th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td colspan="12" class="dataTables_empty"><?= lang("loading_data_from_server"); ?></td>
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
						<th class="col-xs-1"><?= lang("total_tax"); ?></th>
						<th class="col-xs-1"><?= lang("shipping"); ?></th>
						<th class="col-xs-1"><?= lang("discount"); ?></th>
						<th class="col-xs-1"><?= lang("grand_total"); ?></th>
						<th class="col-xs-1">yyyy-mm-dd</th>
					</tr>
					<tr>
						<td colspan="12" class="p0"><input type="text" class="form-control b0" name="search_table" id="search_table" placeholder="<?= lang('type_hit_enter'); ?>" style="width:100%;"></td>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>
</div>
