<div class="page-head">
    <h2 class="pull-left"><?= $page_title; ?> <span class="page-meta"><?= lang("update_heading"); ?></span> </h2>
</div>
<div class="clearfix"></div>
<div class="matter">

    <div class="col-md-12">
        <div class="well">
            <ul class="list-group" style="margin-bottom:0;">
                <?php 
                if(!$this->Settings->purchase_code || !$this->Settings->envato_username){
                    echo form_open('settings/updates');
                    ?>
                    <div class="form-group">
                        <?= lang('purchase_code', 'purchase_code'); ?>
                        <?= form_input('purchase_code', '', 'class="form-control tip" id="purchase_code"  required="required"'); ?>
                    </div>
                    <div class="form-group">
                        <?= lang('envato_username', 'envato_username'); ?>
                        <?= form_input('envato_username', '', 'class="form-control tip" id="envato_username"  required="required"'); ?>
                    </div>
                    <div class="form-group">
                        <?= form_submit('update', lang('update'), 'class="btn btn-primary"'); ?>
                    </div>
                    <?php
                    echo form_close();
                } else {
                    if(! empty($updates->data->updates)) {
                        $c = 1;
                        foreach ($updates->data->updates as $update) {
                            echo '<li class="list-group-item">';
                            echo '<h3><strong>'.lang('version').' '.$update->version.'</strong> ';
                            if ($c == 1 && !empty($update->filename)) {
                                echo anchor('settings/install_update/' . substr($update->filename, 0, -4) . '/' . (!empty($update->mversion) ? $update->mversion : 0) . '/' . $update->version, '<i class="fa fa-download"></i> ' . lang('install'), 'class="btn btn-primary pull-right"') . ' ';
                            }
                            echo '</h3><h3>'.lang('changelog').'<h3><pre>'.$update->changelog.'</pre>';
                            echo '</li>';
                            $c++;
                        }
                    } else {
                        echo '<li class="list-group-item"><strong>'.lang('using_latest_update').'</strong></li>';
                    }
                }
                ?>
            </ul>
        </div>
    </div>
</div>
