<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id="myModalLabel"><?= lang('edit_payment'); ?></h4>
        </div>
        <?=form_open('sales/edit_payment?id='.$payment->id); ?>
        <div class="modal-body">
            <div class="form-group">
                <label for="date"><?= lang("date"); ?></label>
                <div class="controls"> <?= form_input('date', (isset($_POST['date']) ? $_POST['date'] : $this->sim->hrsd($payment->date)), 'class="form-control" id="date"');?> </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="amount"><?= lang("amount_paid"); ?></label>
                <div class="controls"> <?= form_input('amount', $payment->amount, 'class="form-control" id="amount"');?> </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="note"><?= lang("note"); ?></label>
                <div class="controls"> <?= form_textarea('note', $payment->note, 'class="form-control" id="note" style="height:100px;"');?> </div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true"><?= lang('close'); ?></button>
            <button class="btn btn-primary" id="edit_payment"><?= lang('edit_payment'); ?></button>
        </div>
        <?=form_close();?>
    </div>
</div>