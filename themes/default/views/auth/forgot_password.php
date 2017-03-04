<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title><?= lang("forgot_pw")." ".$Settings->site_name; ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link href="<?= $assets; ?>style/bootstrap.min.css" rel="stylesheet">
  <link href="<?= $assets; ?>style/style.css" rel="stylesheet">
  
  <!--[if lt IE 9]>
  <script src="js/html5shim.js"></script>
  <![endif]-->

  <link rel="shortcut icon" href="assets/img/favicon.png">
  <style> body { background:#111; } .alert { margin-bottom: 20px; padding: 10px; } </style>
</head>

<body>

<div class="admin-form">
  <div class="container">

    <div class="row">
      <div class="col-md-12">
      <div><h1 style="text-align:center; padding-bottom:10px; font-size:32px; line-height: 36px; text-transform: uppercase; font-weight: bold; color:#FFF; display:block;"><?= $Settings->site_name; ?></h1><!--<img src="<?= $assets; ?>img/<?= INVOICE_LOGO; ?>" alt="<?= $Settings->site_name; ?>"/>--></div>
            <div class="widget worange">
              <div class="widget-head">
               <?= lang("forgot_pw"); ?> 
              </div>

              <div class="widget-content">
                <div class="padd" style="padding-bottom:0;">
                 <?php $attib = array('class' => 'form-horizontal'); echo form_open("auth/forgot_password", $attib); ?>
                  
                  <?php if($error) { echo "<div class=\"alert alert-danger\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $error . "</div>"; } ?>
        
                   
        <p><?= lang("email_to_reset_pw"); ?></p>
        
         
                    <div class="form-group">
                      <label class="control-label col-lg-3" for="inputEmail"><?= lang("email"); ?></label>
                      <div class="col-lg-9">
                        <?= form_input($email, '', 'class="form-control" placeholder="'.lang("email_address").'" autofocus="autofocus"');?>
                        
                      </div>
                    </div>

                                 
                    <div class="form-group">
                    <div class="control-label col-lg-3">&nbsp;</div>
                        <div class="col-lg-9">
							<button type="submit" class="btn btn-primary btn-block"><?= lang("submit"); ?></button>
							<!--<button type="reset" class="btn btn-default">Reset</button>-->
						</div>
                    </div>
                  <?= form_close();?>
				  
				</div>
                </div>
              
                <div class="widget-foot">
                <strong><?= lang("go"); ?></strong> <a href="<?= site_url('auth/login'); ?>"><?= lang("back_to_login"); ?></a>
                 
                </div>
            </div>  
      </div>
    </div>
  </div> 
</div>
	
		
<script src="<?= $assets; ?>js/jquery.js"></script>
<script src="<?= $assets; ?>js/bootstrap.js"></script>
</body>
</html>
