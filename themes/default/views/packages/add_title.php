
<div class="page-head">
    <h2 class="pull-left"><?= $page_title; ?> <span class="page-meta"><?= lang("enter_info"); ?></span> </h2>
</div>
<div class="clearfix"></div>
<div class="matter">
    <div class="container">

        <?php $attrib = array('class' => 'form-horizontal'); echo form_open("packages/add_title");?>
        <div class="row">
            <div class="col-md-6">              
                
                <div class="form-group">
                    <label for="title_trip">Trip Title</label>
                    <div class="controls"> <?= form_input('title_trip', '', 'class="form-control" id="title_trip"');?>
                    </div>
                </div>   
                
            </div>
        </div>
        <div class="form-group">
            <div class="controls"> <?= form_submit('submit', 'Add Title', 'class="btn btn-primary"');?> </div>
        </div>
        <?= form_close();?> 

        <div class="clearfix"></div>
    </div>
    <div class="clearfix"></div>
</div>
