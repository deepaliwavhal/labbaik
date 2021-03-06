<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<link href='<?= $assets ?>fullcalendar/css/fullcalendar.min.css' rel='stylesheet' />
<link href='<?= $assets ?>fullcalendar/css/fullcalendar.print.css' rel='stylesheet' media='print' />
<link href="<?= $assets ?>fullcalendar/css/bootstrap-colorpicker.min.css" rel="stylesheet" />

<style>
    .calendar-con {
        padding: 0 5px 0 0;
    }
    .calendar-con table, .fc-toolbar {
        width: 99%;
    }
    .calendar-con table table {
        width: 100%;
    }
    .fc th {
        padding: 10px 0px;
        vertical-align: middle;
        background:#F2F2F2;
        width: 14.285%;
    }
    .fc-content {
        cursor: pointer;
        background: none;
    }
    .fc-day-grid-event>.fc-content {
        padding: 4px;
    }

    .fc .fc-center h2 {
        font-size: 16px;
        font-weight: bold;
        line-height: 16px;
    }
    .error {
        color: #ac2925;
        margin-bottom: 15px;
    }
    .event-tooltip {
        width:150px;
        background: rgba(0, 0, 0, 0.85);
        color:#FFF;
        padding:10px;
        position:absolute;
        z-index:10001;
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        border-radius: 4px;
        cursor: pointer;
        font-size: 11px;
    }
    .fc-widget-header {
        padding: 0 !important;
    }
    .fc-day-header {
        padding: 5px 0 !important;
    }
</style>
<div class="page-head"> 
  <h2 class="pull-left"><?= $page_title; ?> 
    <span class="page-meta"><?= lang("calendar_line"); ?> </span> </h2>
</div>
<div class="clearfix"></div>
<div class="matter">
  <div class="container">

        <div class="row">
            <div class="col-lg-12">
                <div class="calendar-con">
                    <div id='calendar'></div>
                </div>
                
                <div class="modal fade cal_modal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                    &times;
                                </button>
                                <h4 class="modal-title"></h4>
                            </div>
                            <div class="modal-body">
                                <div class="error"></div>
                                <form>
                                    <input type="hidden" value="" name="eid" id="eid">
                                    <div class="form-group">
                                        <?= lang('title', 'title'); ?>
                                        <?= form_input('title', set_value('title'), 'class="form-control tip" id="title" required="required"'); ?>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <?= lang('start', 'start'); ?>
                                                <?= form_input('start', set_value('start'), 'class="form-control datetime" id="start" required="required"'); ?>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <?= lang('end', 'end'); ?>
                                                <?= form_input('end', set_value('end'), 'class="form-control datetime" id="end"'); ?>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <?= lang('event_color', 'color'); ?>
                                                <div class="input-group">
                                                    <span class="input-group-addon" id="event-color-addon" style="width:2em;"></span>
                                                    <input id="color" name="color" type="text" class="form-control input-md" readonly="readonly" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <?= lang('description', 'description'); ?>
                                        <textarea class="form-control skip" id="description" name="description"></textarea>
                                    </div>

                                </form>
                            </div>
                            <div class="modal-footer"></div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script type="text/javascript">
    var currentLangCode = '<?= $cal_lang; ?>', moment_df = '<?= strtoupper($dateFormats['js_sdate']); ?> HH:mm', cal_lang = {},
    tkname = "<?=$this->security->get_csrf_token_name()?>", tkvalue = "<?=$this->security->get_csrf_hash()?>";
    cal_lang['add_event'] = '<?= lang('add_event'); ?>';
    cal_lang['edit_event'] = '<?= lang('edit_event'); ?>';
    cal_lang['delete'] = '<?= lang('delete'); ?>';
    cal_lang['event_error'] = '<?= lang('event_error'); ?>';
</script>
<script src='<?= $assets ?>fullcalendar/js/moment.min.js'></script>
<script src="<?= $assets ?>fullcalendar/js/fullcalendar.min.js"></script>
<script src="<?= $assets ?>fullcalendar/js/lang-all.js"></script>
<script src='<?= $assets ?>fullcalendar/js/bootstrap-colorpicker.min.js'></script>
<script src='<?= $assets ?>fullcalendar/js/main.js'></script>
