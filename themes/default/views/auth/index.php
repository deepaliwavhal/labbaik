<script>
    $(document).ready(function() {
        $('#fileData').dataTable( {
            "aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            "aaSorting": [[ 0, "asc" ]],
            "iDisplayLength": 10,
            "oTableTools": {
                "sSwfPath": "<?= $assets; ?>media/swf/copy_csv_xls_pdf.swf",
                "aButtons": [ "csv", "xls", { "sExtends": "pdf", "sPdfOrientation": "landscape", "sPdfMessage": "" }, "print" ]
            },
            "aoColumns": [ null, null, null, null, null, { "bSortable": false } ]
        });
    });
</script>

<div class="page-head">
    <h2 class="pull-left"><?= $page_title; ?> <span class="page-meta"><?= lang("list_results"); ?></span> </h2>
</div>
<div class="clearfix"></div>
<div class="matter">
    <div class="container">
        <table id="fileData" class="table table-bordered table-hover table-striped" style="margin-bottom: 5px;">
            <thead>
                <tr>
                    <th><?= lang("first_name"); ?></th>
                    <th><?= lang("last_name"); ?></th>
                    <th><?= lang("email_address") ?></th>
                    <th><?= lang("phone"); ?></th>
                    <th><?= lang("user_role"); ?></th>
                    <th style="width:100px;"><?= lang("actions"); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user):?>
                    <tr>
                        <td><?= $user->first_name;?></td>
                        <td><?= $user->last_name;?></td>
                        <td><?= $user->email;?></td>
                        <td><?= $user->phone;?></td>
                        <td><?php foreach ($user->groups as $group):?>
                            <?= $group->description;?>
                        <?php endforeach?></td>
                        <td style="text-align:center;"><?php /* echo ($user->active) ? anchor("auth/deactivate/".$user->id, 'Active') : anchor("auth/activate/". $user->id, 'Inactive'); */ ?>
                            <?= '<center><div class="btn-group">
                            <a class="tip btn btn-primary btn-xs" title="'.lang("edit_user").'" href="'.site_url('auth/edit_user/').'?id=' . $user->id . '"> <i class="fa fa-edit"></i> </a>';
                            if($this->sim->in_group('admin')) {
                                echo '<a class="tip btn btn-danger btn-xs" title="'.lang("delete_user").'" href="'.site_url('auth/delete_user/').'?id=' . $user->id . '" onClick="return confirm(\''. lang('alert_x_user') .'\');">
                                <i class="fa fa-trash-o"></i>
                            </a></div></center>
                            '; }  ?></td>
                        </tr>
                    <?php endforeach;?>
                </tbody>
            </table>
            <p><a href="<?= site_url('auth/create_user');?>" class="btn btn-primary"><?= lang("add_user"); ?></a></p>
            <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
    </div>
