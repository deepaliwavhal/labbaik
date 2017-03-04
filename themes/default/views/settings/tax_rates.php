<script>
             $(document).ready(function() {
                $('#fileData').dataTable( {
					"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
                    "aaSorting": [[ 1, "desc" ]],
                    "iDisplayLength": 10,
					"oTableTools": {
                "sSwfPath": "<?= $assets; ?>media/swf/copy_csv_xls_pdf.swf",
                "aButtons": [ "csv", "xls", { "sExtends": "pdf", "sPdfOrientation": "landscape", "sPdfMessage": "" }, "print" ]
            },
					"aoColumns": [ { "bSortable": false }, null, null, null, { "bSortable": false } ]
                });
            });         
</script>

<div class="page-head">
  <h2 class="pull-left"><?= $page_title; ?> <span class="page-meta"><?= lang("list_results"); ?></span> </h2>
</div>
<div class="clearfix"></div>
<div class="matter">
  <div class="container">
    <table id="fileData" cellpadding=0 cellspacing=10 class="table table-bordered table-condensed table-hover table-striped" style="margin-bottom: 5px;">
      <thead>
        <tr>
          <th style="width:35px;"><?= lang('no'); ?></th>
          <th><?= lang('title'); ?></th>
          <th><?= lang('tax_rate'); ?></th>
          <th><?= lang('type'); ?></th>
          <th style="width:100px;"><?= lang('actions'); ?></th>
        </tr>
      </thead>
      <tbody>
        <?php 
		$r = 1;
		foreach ($tax_rates as $row):?>
        <tr>
          <td><?= $r; ?></td>
          <td><?= $row->name; ?></td>
          <td><?= $row->rate; ?></td>
          <td><?php switch ($row->type) {
								case 1:
									echo "Percentage (%)";
									break;
								case 2:
									echo "Fixed ($)";
									break;
						}
					?></td>
          <td><?= '<center><div class="btn-group"> <a class="tip btn btn-primary btn-xs" title="'. lang('edit_tax_rate').'"  href="'.site_url('settings/edit_tax_rate').'?id=' . $row->id . '"> <i class="fa fa-edit"></i> </a> <a class="tip btn btn-danger btn-xs" title="'.lang('delete_tax_rate').'" href="'.site_url('settings/delete_tax_rate').'?&id=' . $row->id . '" onClick="return confirm(\''. lang('alert_x_tax_rate') .'\')"> <i class="fa fa-trash-o"></i> </a></div></center> 
								
							
                '; ?></td>
        </tr>
        <?php $r++; endforeach;?>
      </tbody>
    </table>
    <p><a href="<?= site_url('settings/add_tax_rate');?>" class="btn btn-primary"><?= lang('new_tax_rate'); ?></a></p>
    <div class="clearfix"></div>
  </div>
  <div class="clearfix"></div>
</div>
