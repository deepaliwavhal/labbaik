<?php $title_trip = array(
    'name'        => 'title_trip',
    'id'          => 'title_trip',
    'value'       => $title->title_trip,
    'class'       => 'form-control',
    );

    ?>

    <div class="page-head">
        <h2 class="pull-left"><?= $page_title; ?> <span class="page-meta"><?= lang("enter_info"); ?></span> </h2>
    </div>
    <div class="clearfix"></div>
    <div class="matter">
        <div class="container">

            <?php $attrib = array('class' => 'form-horizontal'); echo form_open("packages/edit_title?id=".$id);?>
            <div class="row">
                <div class="col-md-6">
                     <div class="form-group">
                    <label for="name">Tip Title</label>
                    <div class="controls"> <?= form_input($title_trip);?>
                    </div>
                </div>                 
                               
                </div>
            </div>
            <div class="form-group">
                <div class="controls"> <?= form_submit('submit', 'Update Title', 'class="btn btn-primary"');?> </div>
            </div>
            <?= form_close();?> 
        </div>
    </div>
