
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id="myModalLabel"><?= lang('day_event')." (".$this->sim->hrsd($date).")"; ?></h4>
        </div>

        <div class="modal-body">
            <!--<p><?= lang('list_results'); ?></p>-->

            <?php
            if ($events) {
                foreach ($events as $event) {
                    echo '<div class="col-xs-12" style="background:'.$event->color.'; margin-bottom:10px; color:#FFF; padding:10px 20px;">';
                    echo '<span class="pull-right">'.$this->sim->hrld($event->start).' - '.$this->sim->hrld($event->end).'</span><br>';
                    echo '<strong>'.$event->title.'</strong>';
                    echo '<p>'.$event->description.'</p>';
                    echo '</div>';
                }
            } else {
                echo lang('no_event');
            }
            ?>

            </div>
        <div class="modal-footer" style="margin-top:0;">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?=lang('close')?></button>
      </div>
</div>
