<div class="page-head">
    <h2 class="pull-left"><?= $page_title; ?> <span class="page-meta"><?= lang("backups_heading"); ?></span> </h2>
  </div>
  <div class="clearfix"></div>
  <div class="matter">
    <div class="container">

<div class="well" style="margin-bottom: 15px;">
    <div style="border-bottom: 1px solid #CCC;">
        <h4 class="blue"><i class="fa fa-folder"></i> <?= lang('file_backups'); ?>
        <a href="#" id="backup_files" class="btn btn-primary pull-right"><i class="icon fa fa-files-o"></i> <span class="padding-right-10"><?=lang('backup_files');?></span></a>
        </h4>
    </div>

        <div class="row">            
            <div class="col-lg-12">
                <p class="introtext"><?= lang('restore_heading'); ?></p>

                <div class="row">            
                    <div class="col-md-12">
                    <ul class="list-group">
                        <?php
                        foreach ($files as $file) {
                            $file = basename($file);
                            echo '<li class="list-group-item">';
                            $date_string = substr($file, 12, 10);
                            $time_string = substr($file, 23, 8);
                            $date = $date_string.' '.str_replace('-', ':', $time_string);
                            $bkdate = $this->sim->hrld($date);
                            echo '<strong>'.lang('backup_on').' <span class="text-primary">'.$bkdate.'</span><div class="btn-group pull-right" style="margin-top:-4px;">'.anchor('settings/download_backup/'.substr($file, 0, -4), '<i class="fa fa-download"></i> ' . lang('download'), 'class="btn btn-primary"').' '.anchor('settings/restore_backup/'.substr($file, 0, -4), '<i class="fa fa-database"></i> ' . lang('restore'), 'class="btn btn-warning restore_backup"').' '.anchor('settings/delete_backup/'.substr($file, 0, -4), '<i class="fa fa-trash-o"></i> ' . lang('delete'), 'class="btn btn-danger delete_file"').' </div></strong>';
                            echo '</li>';
                        }
                        ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>                         

</div>
<div class="well">
<div style="border-bottom: 1px solid #CCC;">
    <h4 class="blue"><i class="fa fa-database"></i> <?= lang('database_backups'); ?>
    <a href="<?=site_url('settings/backup_database')?>" class="btn btn-primary pull-right"><i class="icon fa fa-database"></i> <span class="padding-right-10"><?=lang('backup_database');?></span></a>
    </h4>
</div>

        <div class="row">            
            <div class="col-lg-12">
                <p class="introtext"><?= lang('restore_heading'); ?></p>

                <div class="row">            
                    <div class="col-md-12">
                    <ul class="list-group">
                        <?php
                        foreach ($dbs as $file) {
                            $file = basename($file);
                            echo '<li class="list-group-item">';
                            $date_string = substr($file, 13, 10);
                            $time_string = substr($file, 24, 8);
                            $date = $date_string.' '.str_replace('-', ':', $time_string);
                            $bkdate = $this->sim->hrld($date);
                            echo '<strong>'.lang('backup_on').' <span class="text-primary">'.$bkdate.'</span><div class="btn-group pull-right" style="margin-top:-4px;">'.anchor('settings/download_database/'.substr($file, 0, -4), '<i class="fa fa-download"></i> ' . lang('download'), 'class="btn btn-primary"').' '.anchor('settings/restore_database/'.substr($file, 0, -4), '<i class="fa fa-database"></i> ' . lang('restore'), 'class="btn btn-warning restore_db"').' '.anchor('settings/delete_database/'.substr($file, 0, -4), '<i class="fa fa-trash-o"></i> ' . lang('delete'), 'class="btn btn-danger delete_file"').' </div></strong>';
                            echo '</li>';
                        }
                        ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>                         

</div>
<div class="modal fade" id="wModal" tabindex="-1" role="dialog" aria-labelledby="wModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="wModalLabel"><?=lang('please_wait');?></h4>
      </div>
      <div class="modal-body">
        <?=lang('backup_modal_msg');?>
      </div>
    </div>
  </div>
</div>

</div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('#backup_files').click(function(e) {
            e.preventDefault();
            $('#wModalLabel').text('<?=lang('backup_modal_heading');?>');
            $('#wModal').modal({backdrop:'static',keyboard:true}).appendTo('body').modal('show');
            window.location.href = '<?= site_url('settings/backup_files'); ?>';
        });
        $('.restore_backup').click(function(e) {
            e.preventDefault();
            var href = $(this).attr('href');
            var result = confirm("<?=lang('restore_confirm');?>");
            if (result) {
                $('#wModalLabel').text('<?=lang('restore_modal_heading');?>');
                $('#wModal').modal({backdrop:'static',keyboard:true}).appendTo('body').modal('show');
                window.location.href = href;
            }
        });
        $('.restore_db').click(function(e) {
            e.preventDefault();
            var href = $(this).attr('href');
            var result = confirm("<?=lang('restore_confirm');?>"); 
            if (result) {
                window.location.href = href;
            }
        });
        $('.delete_file').click(function(e) {
            e.preventDefault();
            var href = $(this).attr('href');
            var result = confirm("<?=lang('delete_confirm');?>");
            if (result) {
                window.location.href = href;
            }
        });
    });
</script>