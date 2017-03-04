<style type="text/css">
  .payments td {
    width: auto !important;
  }
</style>
<div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><?= lang("view_payments").' ('.lang("invoice_no").' '.$inv->id.')'; ?></h4>
      </div>
      <div class="modal-body">
        <?php if(!empty($payment)) { ?>

        <table class="table table-bordered table-condensed table-hover table-striped payments" style="margin-bottom: 0px;">
        	<thead> 
        	<tr> 
        	    <th><?= lang("date"); ?></th> 
        	    <th><?= lang("amount"); ?></th> 
              <th><?= lang("note"); ?></th> 
              <th style="max-width:25px !imprtant; text-align:center;"><i class="fa fa-file-text-o"></i></th> 
        	</tr> 
        	</thead> 
            <tbody>
            <?php foreach ($payment as $p) { ?>
            <tr> 
        	    <td style="text-align:left;"><?= $this->sim->hrsd($p->date); ?></td> 
        	    <td style="text-align:right;"><?= $p->amount; ?></td> 
              <td><?= $p->note; ?></td> 
              <td style="max-width:25px !imprtant; text-align:center;"><a class="tip btn btn-success btn-xs" title="<?= lang("view_payments"); ?>" href="<?= site_url('sales/payment_note'); ?>?id=<?= $p->id; ?>" data-toggle="ajax-modal"><i class="fa fa-file-text-o"></i></a><a class="tip btn btn-warning btn-xs" title="<?= lang("edit_payment"); ?>" href="<?= site_url('sales/edit_payment?id='.$p->id); ?>" data-toggle="ajax-modal"><i class="fa fa-edit"></i></a><a class="tip btn btn-danger btn-xs" title="<?= lang("delete_payment"); ?>" href="<?= site_url('sales/delete_payment?id='.$p->id); ?>"><i class="fa fa-trash-o"></i></a></td>
        	</tr> 
            <?php } ?>
            </tbody>
        </table>    
           <?php } else { echo "<p>".lang("no_payment")."</p>"; 
           } ?> 
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?= lang("close"); ?></button>
      </div>
    </div>
  </div>