<script>
    $(document).ready(function() {
        $('#fileData').dataTable( {
            "LengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            "ordering": [[ 0, "asc" ]],
            "Length": 10,
            "columns": [ { "bSortable": false }, null, { "bSortable": false } ]
        });
    });         
</script>

<div class="page-head">
    <h2 class="pull-left"><?= $page_title; ?> <span class="page-meta"><?= lang("list_results"); ?></span> </h2>
</div>
<div class="clearfix"></div>
<div class="matter">
    <div class="container">
        <table id="fileData" class="table table-bordered table-condensed table-hover table-striped" style="margin-bottom: 5px;">
            <thead>
                <tr>
                    <th style="width:33px;"><?= lang('no'); ?></th>
                    <th><?= lang('description'); ?></th>
                    <th style="width:80px;"><?= lang('actions'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $r = 1;
                foreach ($notes as $row):?>
                <tr id="<?= $row->id; ?>">
                    <td style="width:30px;" class="text-center"><?= $r; ?></td>
                    <td class="description"><?= $row->description; ?></td>
                    <td style="width:80px;" class="text-center">
                        <?= '<center><div class="btn-group"> <a class="tip btn btn-primary btn-xs edit" title="'. lang('edit_note').'"  href="#"> <i class="fa fa-edit"></i> </a> <a class="tip btn btn-danger btn-xs delete" title="'.lang('delete_note').'" href="#"> <i class="fa fa-trash-o"></i> </a></div></center>'; ?>
                    </td>
                </tr>
                <?php $r++; endforeach;?>
            </tbody>
        </table>
        <p><a href="#" class="btn btn-primary add"><?= lang('new_note'); ?></a></p>
        <div class="clearfix"></div>
    </div>
    <div class="clearfix"></div>
</div>

<div class="modal fade" id="nModal" tabindex="-1" role="dialog" aria-labelledby="nModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="nModalLabel"><?= lang('new_note'); ?></h4>
      </div>
      <?= form_open('settings/note', 'style="margin:0;"'); ?>
      <div class="modal-body">
        <div class="form-group">
            <?= lang('description', 'description'); ?>
            <?= form_textarea('description', '', 'class="form-control" id="description" required="required"'); ?>
        </div>
        <input type="hidden" name="action" id="action">
        <input type="hidden" name="id" id="id">
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary"><?= lang('submit'); ?></button>
      </div>
      <?= form_close(); ?>
    </div>
  </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $(document).on('click', '.edit', function() {
            var row = $(this).closest('tr');
            var desc = row.find('.description').text();
            var id = row.attr('id');
            $('#nModalLabel').text('<?= lang('edit_note'); ?>');
            $('#description').val(desc);
            $('#id').val(id);
            $('#action').val('edit');
            $('#nModal').modal();
            console.log(id, desc);
            return false;
        });

        $('.add').click(function() {
            $('#nModalLabel').text('<?= lang('new_note'); ?>');
            $('#action').val('add');
            $('#description').val('');
            $('#nModal').modal();
            return false;
        });

        $(document).on('click', '.delete', function() {
            var row = $(this).closest('tr');
            var id = row.attr('id');
            var con = confirm('<?= lang('alert_x_note'); ?>');
            if (con) {
                $.get(Site.base_url+'settings/delete_note/'+id).done(function(data) {
                    row.remove();
                    addAlert(data, 'success');
                });
            }
            return false;
        });
    });
</script>
