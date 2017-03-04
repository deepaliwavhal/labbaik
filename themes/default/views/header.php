<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <title><?= $page_title." &middot; ".$Settings->site_name; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="<?= $assets; ?>img/favicon.png">
    <link href="<?= $assets; ?>style/plugins.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= $assets; ?>datatables/datatables.min.css">
    <link href="<?= $assets; ?>style/style.css" rel="stylesheet">
    <script src="<?= $assets; ?>js/jquery.js"></script>
</head>

<body>
    <div class="navbar navbar-inverse bs-docs-nav" role="banner">
        <div class="container">
            <div class="navbar-header">
                <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".bs-navbar-collapse"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
                <a href="<?= base_url(); ?>" class="navbar-brand" style="padding:15px; font-size:20px; text-transform:uppercase;"><i class="fa fa-file-text"></i> <?= $Settings->site_name; ?><!--<img src="<?= $assets; ?>img/<?= $Settings->logo; ?>" alt="<?= $Settings->site_name; ?>" />--></a> 
            </div>
            <ul class="nav navbar-nav visible-lg visible-md">
                <li class="dropdown"> <a class="dropdown-toggle" data-toggle="dropdown" href="#"><img src="<?= $assets; ?>img/<?= $Settings->selected_language; ?>.png" style="margin-top:-1px" align="middle"></a>
                    <ul class="dropdown-menu" style="min-width: 60px;" role="menu" aria-labelledby="dLabel">
                        <?php if ($handle = opendir('app/language/')) {
                            while (false !== ($entry = readdir($handle))) {
                                if ($entry != "." && $entry != ".." && $entry != "index.html") {
                                    ?>
                                    <li><a href="<?= site_url('home/language?lang='.$entry); ?>"><img src="<?= $assets; ?>img/<?= $entry; ?>.png" class="language-img"> &nbsp;&nbsp;
                                        <?= ucwords($entry); ?>
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
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown"> <a data-toggle="dropdown" class="dropdown-toggle" href="#"> <i class="fa fa-user"></i> Hi, <?= $this->session->userdata('username'); ?> <b class="caret"></b> </a>
                            <ul class="dropdown-menu">
                                <li><a href="<?= site_url('auth/change_password'); ?>"><i class="fa fa-key"></i> <?= lang('change_password'); ?></a></li>
                                <li><a href="<?= site_url('auth/logout'); ?>"><i class="fa fa-sign-out"></i> <?= lang('logout'); ?></a></li>
                            </ul>
                        </li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right" style="margin-right:0px;">
                        <?php  if (DEMO) {
                            echo '<li class="blightblue"><a href="http://codecanyon.net/item/simple-invoice-manager-invoicing-made-easy/4259689?ref=tecdiary" target="_blank"><i class="fa fa-shopping-cart"></i> Buy Now</a></li>';
                        } ?>
                        <li><a href="<?= base_url(); ?>"><i class="fa fa-dashboard"></i> <?= lang('home'); ?></a></li>
                        <li><a href="<?= site_url('calendar'); ?>"><i class="fa fa-calendar"></i> <?= lang('calendar'); ?></a></li>
                        <li class="dropdown dropdown-big"> <a class="dropdown-toggle" href="#" data-toggle="dropdown"> <i class="fa fa-list"></i> <?= lang('events'); ?> </a>
                            <ul class="dropdown-menu">
                                <?php if ($events) { foreach ($events as $event) { ?>
                                <li><strong><?= $this->sim->hrld($event->start).':</strong><br>'.$event->title; ?></span><div class="clearfix"></div><hr /></li>
                                <?php } } else { ?>
                                <li><h5><i class="fa fa-list"></i> <?php echo $this->lang->line('no_upcoming_events'); ?></h5></li>
                                <?php } ?>
                            </ul>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
        <div class="content">
            <div class="sidebar">
                <div class="navbar-header">
                    <div class="sidebar-dropdown">
                        <a href="#" class="navbar-toggle" role="button" data-toggle="collapse" data-target=".bs-navbar-collapse2">Navigation</a>
                    </div>
                </div> 
                <nav class="sidebar-inner collapse navbar-collapse bs-navbar-collapse2" role="navigation" style="padding:0;">
                    <ul class="navi">
                        <li class="nred"><a class="mm_home" href="<?= base_url(); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                        <li class="nblue"> <a class="mm_reports" href="<?=site_url('trip');?>"> <i class="fa fa-bar-chart-o"></i> 
                            <?= lang('Trip'); ?> <span class="pull-right"></span> </a>

                        <li class="has_submenu nlightblue"> <a class="mm_sales" href="#"> <i class="fa fa-file-text"></i> <?= lang('sales'); ?> <span class="pull-right"><b class="fa fa-sort-down"></b></span> </a>
                            <ul>
                                <li><a id="sales_index" href="<?= site_url('sales'); ?>"><?= lang('list_invoices'); ?></a></li>
                                <li><a id="sales_add" href="<?= site_url('sales/add'); ?>"><?= lang('add_invoice'); ?></a></li>
                                <li class="divider"></li>
                                <li><a id="sales_quotes" href="<?= site_url('sales/quotes'); ?>"><?= lang('list_quotes'); ?></a></li>
                                <li><a id="sales_add_quote" href="<?= site_url('sales/add_quote'); ?>"><?= lang('add_quote'); ?></a></li>
                            </ul>
                        </li>
                        <li class="has_submenu nblue"> <a class="mm_products" href="#"> <i class="fa fa-list"></i> <?= lang('products'); ?> <span class="pull-right"><b class="fa fa-sort-down"></b></span> </a>
                            <ul>
                                <li><a id="products_index" href="<?= site_url('products'); ?>"><?= lang('list_products'); ?></a></li>
                                <li><a id="products_add" href="<?= site_url('products/add'); ?>"><?= lang('add_product'); ?></a></li>
                                <?php if($this->sim->in_group('admin')) { ?>
                                <li><a id="products_import" href="<?= site_url('products/import'); ?>"><?= lang('import_products'); ?></a></li>
                                <?php } ?>
                            </ul>
                        </li>
                        <li class="has_submenu nviolet"> <a class="mm_customers" href="#"> <i class="fa fa-users"></i> <?= lang('customers'); ?> <span class="pull-right"><b class="fa fa-sort-down"></b></span> </a>
                            <ul>
                                <li><a id="customers_index" href="<?= site_url('customers'); ?>"><?= lang('list_customers'); ?></a></li>
                                <li><a id="customers_add" href="<?= site_url('customers/add'); ?>"><?= lang('add_customer'); ?></a></li>
                                <li><a id="customers_import" href="<?= site_url('customers/import'); ?>"><?= lang('import_customers'); ?></a></li>
                            </ul>
                        </li>
                        <?php if($this->sim->in_group('admin')) { ?>
                        <li class="has_submenu ngreen"> <a class="mm_auth" href="#"> <i class="fa fa-users"></i> <?= lang('users'); ?> <span class="pull-right"><b class="fa fa-sort-down"></b></span> </a>
                            <ul>
                                <li><a id="auth_users" href="<?= site_url('auth/users'); ?>"><?= lang('list_users'); ?></a></li>
                                <li><a id="auth_create_user" href="<?= site_url('auth/create_user'); ?>"><?= lang('new_user'); ?></a></li>
                            </ul>
                        </li>
                        <li class="has_submenu norange"> <a class="mm_settings" href="#"> <i class="fa fa-cog"></i> <?= lang('settings'); ?> <span class="pull-right"><b class="fa fa-sort-down"></b></span> </a>
                            <ul>
                                <li><a id="settings_system_setting" href="<?= site_url('settings/system_setting'); ?>"><?= lang('system_setting'); ?></a></li>
                                <li><a id="settings_paypal" href="<?= site_url('settings/paypal'); ?>"><?= lang('paypal_settings'); ?></a></li>
                                <li><a id="settings_skrill" href="<?= site_url('settings/skrill'); ?>"><?= lang('skrill_settings'); ?></a></li>
                                <li><a id="settings_stripe" href="<?= site_url('settings/stripe'); ?>"><?= lang('stripe_settings'); ?></a></li>
                                <li><a id="settings_companies" href="<?= site_url('settings/companies'); ?>"><?= lang('companies'); ?></a></li>
                                <li><a id="settings_add_company" href="<?= site_url('settings/add_company'); ?>"><?= lang('add_company'); ?></a></li>
<!--<li><a href="<?= site_url('settings/change_logo'); ?>"><?= lang('change_logo'); ?></a></li>
    <li><a class="settings_system_settings" href="<?= site_url('settings/change_invoice_logo'); ?>"><?= lang('change_invoice_logo'); ?></a></li>-->
    <li class="divider"></li>
    <li><a id="settings_email_templates" href="<?= site_url('settings/email_templates'); ?>"><?= lang('email_templates'); ?></a></li>
    <li class="divider"></li>
    <li><a id="settings_tax_rates" href="<?= site_url('settings/tax_rates'); ?>"><?= lang('tax_rates'); ?></a></li>
    <li><a id="settings_add_tax_rate" href="<?= site_url('settings/add_tax_rate'); ?>"><?= lang('add_tax_rate'); ?></a></li>
    <li><a id="settings_notes" href="<?= site_url('settings/notes'); ?>"><?= lang('notes'); ?></a></li>
    <li class="divider"></li>
    <li><a href="<?= site_url('settings/backups'); ?>"><?= lang('backups'); ?></a></li>
    <li><a href="<?= site_url('settings/updates'); ?>"><?= lang('updates'); ?></a></li>
</ul>
</li>
<?php } ?>
<li class="has_submenu nblue"> <a class="mm_reports" href="#"> <i class="fa fa-bar-chart-o"></i> <?= lang('reports'); ?> <span class="pull-right"><b class="fa fa-sort-down"></b></span> </a>
    <ul>
        <li><a id="reports_daily_sales" href="<?= site_url('reports/daily_sales'); ?>"><?= lang('daily_sales'); ?></a></li>
        <li><a id="reports_monthly_sales" href="<?= site_url('reports/monthly_sales'); ?>"><?= lang('monthly_sales'); ?></a></li>
        <li><a id="reports_sales" href="<?= site_url('reports/sales'); ?>"><?= lang('sales_report'); ?></a></li>
        <li><a id="reports_payments" href="<?= site_url('reports/payments'); ?>"><?= lang('payment_reports'); ?></a></li>
    </ul>
</li>
<li class="has_submenu nred"> <a href="#"> <i class="fa fa-user"></i> Hi, <?= $this->session->userdata('username'); ?>! <span class="pull-right"><b class="fa fa-sort-down"></b></span> </a>
    <ul>
        <li><a href="<?= site_url('auth/change_password'); ?>"><?= lang('change_password'); ?></a></li>
        <li class="divider"></li>
        <li><a href="<?= site_url('auth/logout'); ?>"><?= lang('logout'); ?></a></li>
    </ul>
</li>
</ul>
<div class="sidebar-widget">
    <div id="todaydate"></div>
</div>
<div class="sidebar-widget" style="text-align:center; letter-spacing:2px; color:#666; text-transform:uppercase;"> <?= $Settings->site_name.' v'.$Settings->version; ?> </div>
</div>
</div>
<div class="mainbar">
    <div class="alerts-con"></div>
    <?php if($error) { echo "<div class=\"alert alert-danger\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $error . "</div>"; } ?>
    <?php if($message) { echo "<div class=\"alert alert-success\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $message . "</div>"; } ?>
