
<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-2x">&times;</i></button>
            <h4 class="modal-title" id="myModalLabel"><?= lang('users')." (".$customer->company.")"; ?></h4>
        </div>
       
        <div class="modal-body">
            <!--<p><?= lang('list_results'); ?></p>-->
             
            <div class="table-responsive">
                    <table id="CSUData" cellpadding="0" cellspacing="0" border="0" class="table table-bordered table-condensed table-hover table-striped" style="margin-bottom:0;">
                        <thead>
                            <tr class="primary">
                                <!--<th style="width:55px;"><?= lang("id"); ?></th>-->
                                <th><?= lang("first_name"); ?></th>
                                <th><?= lang("last_name"); ?></th>
                                <th><?= lang("email_address"); ?></th>
                                <th style="width:85px;"><?= lang("actions"); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($users)) {
                             foreach($users as $user) {   
                                 echo '<tr>'.
                                        //'<td class="text-center">'.$user->id.'</td>'.
                                        '<td>'.$user->first_name.'</td>'.
                                        '<td>'.$user->last_name.'</td>'.
                                        '<td>'.$user->email.'</td>'.
                                        '<td class="text-center"><div class="btn-group"><a class="tip btn btn-primary btn-xs" href="'.site_url('auth/edit_user/').'?id='.$user->id .'&customer=1" class="tip" title="' . lang("edit_profile") . '"><i class="fa fa-edit"></i></a> <a class="tip btn btn-danger btn-xs" title="'.lang("delete_user").'" href="'.site_url('auth/delete_user/').'?id=' . $user->id . '" onClick="return confirm(\''. lang('alert_x_user') .'\');"><i class="fa fa-trash-o"></i></a></div></td>'.
                                        '</tr>';
                            }
                            } else { ?>
                            <tr>
                                <td colspan="6" class="dataTables_empty"><?=lang('sEmptyTable')?></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                   
            </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?=lang('close')?></button>
      </div>
</div>

