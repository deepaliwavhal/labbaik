<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title><?= $page_title." &middot; ".$Settings->site_name; ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="<?= $assets; ?>img/favicon.png">
  <link href="<?= $assets; ?>style/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="<?= $assets; ?>datatables/datatables.min.css">
  <link href="<?= $assets; ?>style/style.css" rel="stylesheet">
  <script src="<?= $assets; ?>js/jquery.js"></script>
<!--[if lt IE 9]>
  <script src="<?= $assets; ?>js/html5shim.js"></script>
  <![endif]-->
  <script type="text/javascript"  charset="UTF-8">
  var js_date = '<?= $dateFormats['js_sdate']; ?>', thousands_sep = '<?=$Settings->thousands_sep;?>', decimals_sep = '<?=$Settings->decimals_sep;?>', decimals = <?=$Settings->decimals;?>;
  </script>
  <style type="text/css" media="screen">
  .content { background: #fff; }
    .navbar .container, .content {
      max-width: 1170px !important;
      margin: 0 auto;
      padding: 0;
    }
    .page-head {
      border-bottom: 1px solid #ccc;
      margin-bottom: 20px;
      padding: 10px 15px;

    }
    .totop {
      left: auto;
      right: 0;
    }
    table td { vertical-align: middle !important; }
  </style>

</head>

<body>
  <div class="navbar navbar-inverse bs-docs-nav" role="banner">
    <div class="container">
      <div class="navbar-header">
        <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".bs-navbar-collapse"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
        <a href="<?= site_url('clients'); ?>" class="navbar-brand" style="padding:15px 15px 15px 30px; font-size:20px; text-transform:uppercase;"><?= $Settings->site_name; ?></a> </div>
        <ul class="nav navbar-nav visible-lg visible-md">
          <li class="dropdown"> <a class="dropdown-toggle" data-toggle="dropdown" href="#"><img src="<?= $assets; ?>img/<?= $Settings->language; ?>.png" style="margin-top:-1px" align="middle"></a>
            <ul class="dropdown-menu" style="min-width: 60px;" role="menu" aria-labelledby="dLabel">
              <?php if ($handle = opendir('app/language/')) {
                while (false !== ($entry = readdir($handle))) {
                 if ($entry != "." && $entry != ".." && $entry != "index.html") {
                   ?>
                   <li><a href="<?= site_url('clients/language?lang='.$entry); ?>"><img src="<?= $assets; ?>img/<?= $entry; ?>.png" class="language-img"> &nbsp;&nbsp;
                    <?php echo ucwords($entry); ?>
                  </a></li>
                  <?php }
                }
                closedir($handle);
              } 
              ?>
            </ul>
          </li>
        </ul>
        <nav class="collapse navbar-collapse bs-navbar-collapse" role="navigation">
          <ul class="nav navbar-nav navbar-right" style="margin-right:0px; padding: 0 0 0 15px;">
           <?php  if (DEMO) {
             echo '<li class="blightblue"><a href="http://codecanyon.net/item/simple-invoice-manager-invoicing-made-easy/4259689?ref=tecdiary" target="_blank"><i class="glyphicon glyphicon-shopping-cart"></i> Buy Now</a></li>';
           } ?>
           <li class="nred"><a id="index" href="<?= site_url('clients'); ?>"><i class="glyphicon glyphicon-dashboard"></i> <?= lang('dashboard'); ?></a></li>
           <li class="nblue"><a id="sales" href="<?= site_url('clients/sales'); ?>"><i class="glyphicon glyphicon-th-list"></i> <?= lang('invoices'); ?></a></li>
           <li class="nviolet"><a id="quotes" href="<?= site_url('clients/quotes'); ?>"><i class="glyphicon glyphicon-list"></i> <?= lang('quotes'); ?></a></li>
           <li class="norange"><a id="company_details" href="<?= site_url('clients/company_details'); ?>"><i class="glyphicon glyphicon-tower"></i> <?= lang('company_details'); ?></a></li>
           <li class="dropdown"> <a data-toggle="dropdown" class="dropdown-toggle" href="#"> <i class="glyphicon glyphicon-user"></i> Hi, <?= $this->session->userdata('username'); ?> <b class="caret"></b> </a>
            <ul class="dropdown-menu">
              <li><a href="<?= site_url('clients/change_password'); ?>"><i class="glyphicon glyphicon-lock"></i> <?= lang('change_password'); ?></a></li>
              <li><a href="<?= site_url('auth/logout'); ?>"><i class="glyphicon glyphicon-log-out"></i> <?= lang('logout'); ?></a></li>
            </ul>
          </li>
        </ul>
      </nav>
    </div>
  </div>
  <div class="content">
  <?php if($message) { echo "<div class=\"alert alert-success\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $message . "</div>"; } ?>
<?php if($error) { echo "<div class=\"alert alert-danger\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $error . "</div>"; } ?>
