<?php
$v = "?v=1";
if($this->input->post('submit')) {
	if($this->input->post('product')){
		$v .= "&product=".$this->input->post('product');
	} 
	if($this->input->post('user')){
		$v .= "&user=".$this->input->post('user');
	} 
	if($this->input->post('customer')){
		$v .= "&customer=".$this->input->post('customer');
	} 
	if($this->input->post('cf')){
		$v .= "&cf=".$this->input->post('cf');
	} 
	if($this->input->post('status')){
		$v .= "&status=".$this->input->post('status');
	}
	if($this->input->post('start_date')){
		$v .= "&start_date=".$this->input->post('start_date');
	}
	if($this->input->post('end_date')) {
		$v .= "&end_date=".$this->input->post('end_date');
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

			"dom": '<"text-center"<"btn-group"B>><"clear"><"row"<"col-md-6"l><"col-md-6"p>r>t<"row"<"col-md-6"i><"col-md-6"p>><"clear">',
			"lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
			"order": [[ 0, "desc" ], [ 1, "desc" ]],
			"pageLength": <?=$Settings->rows_per_page;?>,
			"processing": true, "serverSide": true,
            // 'ajax': '<?=site_url('reports/getsales/'.$v);?>',
            'ajax' : { url: '<?=site_url('reports/getsales/'.$v);?>', type: 'POST', "data": function ( d ) {
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
            { "data": "id", "visible": false },
            { "data": "date", "render": fld },
            { "data": "company_name" },
            { "data": "reference_no" },
            { "data": "user", "visible": false },
            { "data": "customer_name" },
            { "data": "grand_total", "render": cf },
            { "data": "paid", "render": cf },
            { "data": "balance", "render": cf },
            { "data": "due_date", "render": fsd  },
            { "data": "status", "render": status }
            ],
            "footerCallback": function (  tfoot, data, start, end, display ) {
            	var api = this.api(), data;
            	$(api.column(6).footer()).html( cf(api.column(6).data().reduce( function (a, b) { return pf(a) + pf(b); }, 0)) );
            	$(api.column(7).footer()).html( cf(api.column(7).data().reduce( function (a, b) { return pf(a) + pf(b); }, 0)) );
            	$(api.column(8).footer()).html( cf(api.column(8).data().reduce( function (a, b) { return pf(a) + pf(b); }, 0)) );
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

			<p>Please customize the report below.</p>
			<?php $attrib = array('class' => 'form-horizontal'); echo form_open("reports/sales"); ?>
			<div class="form-group">
				<label for="product"><?= lang("product"); ?></label>
				<div class="controls"> <?= form_input('product', (isset($_POST['product']) ? $_POST['product'] : ""), 'class="form-control" id="product"');?> </div>
			</div>
			
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
							echo form_dropdown('customer', $cu, (isset($_POST['customer']) ? $_POST['customer'] : ""), 'class="form-control customer" data-placeholder="'.lang("select")." ".lang("customer").'" id="customer" style="width:100%;"'); 
							?>
						</div>
					</div>
					<div class="form-group">
						<?= lang('cfs', 'cf'); ?>
						<?= form_input('cf', set_value('cf'), 'class="form-control tip" id="cf"'); ?>
					</div>
					<div class="form-group">
						<label for="user"><?= lang("created_by"); ?></label>
						<div class="controls">
							<?php 
							$us[""] = lang("select")." ".lang("user");
							foreach($users as $user){
								$us[$user->id] = $user->first_name.' '.$user->last_name;
							}
							echo form_dropdown('user', $us, (isset($_POST['user']) ? $_POST['user'] : ""), 'class="form-control user" data-placeholder="'.lang("select")." ".lang("user").'" id="user" style="width:100%;"'); 
							?>
						</div>
					</div>
				</div>

				<div class="col-md-6">
					<div class="form-group">
						<label for="customer"><?= lang("status"); ?></label>
						<div class="controls">
							<?php 
							$st = array(
								'' 		=> lang('select').' '.lang('status'),
								lang('cancelled') => lang('cancelled'),
								lang('overdue') 	=> lang('overdue'),
								lang('paid')		=> lang('paid'),
								lang('partially_paid')		=> lang('partially_paid'),
								lang('pending')	=> lang('pending')
								);

							echo form_dropdown('status', $st, (isset($_POST['status']) ? $_POST['status'] : ""), 'class="status form-control" data-placeholder="'.lang("select")." ".lang("status").'" id="status" style="width:100%;"'); 
							?>
						</div>
					</div>
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
		<?php }	?>

		<table id="fileData" class="table table-bordered table-hover table-striped" style="margin: 0 0 5px 0;">
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
					<th class="col-xs-1"><?= lang("balance"); ?></th>
					<th class="col-xs-1"><?= lang("due_date"); ?></th>
					<th class="col-xs-1"><?= lang("status"); ?></th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td colspan="11" class="dataTables_empty"><?= lang('loading_data_from_server'); ?></td>
				</tr>
			</tbody>

			<tfoot>
				<tr>
					<th class="col-xs-1"><?= lang("id"); ?></th>
					<th class="col-xs-1"><?= lang("date"); ?></th>
					<th class="col-xs-2"><?= lang("billing_company"); ?></th>
					<th class="col-xs-1"><?= lang("reference_no"); ?></th>
					<th class="col-xs-1"><?= lang("created_by"); ?></th>
					<th class="col-xs-2"><?= lang("customer"); ?></th>
					<th class="col-xs-1"><?= lang("total"); ?></th>
					<th class="col-xs-1"><?= lang("paid"); ?></th>
					<th class="col-xs-1"><?= lang("balance"); ?></th>
					<th class="col-xs-1"><?= lang("due_date"); ?></th>
					<th class="col-xs-1"><?= lang("status"); ?></th>
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
