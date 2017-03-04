
<div class="page-head">
    <h2 class="pull-left"><?= $page_title; ?> <span class="page-meta"><?= lang("update_info"); ?></span> </h2>
</div>
<div class="clearfix"></div>
<div class="matter">
    <div class="container">
        <?php $attrib = array('class' => 'form-horizontal'); echo form_open("settings/system_setting");?>
        <div class="row">
        <div class="col-md-4"><div class="form-group">
                <label for="site_name"><?= lang("site_name"); ?></label>
                <div class="controls"> <?= form_input('site_name', $Settings->site_name, 'class="form-control" id="site_name"');?> </div>
            </div></div>
        <div class="col-md-4"><div class="form-group">
                <label for="theme"><?= lang("theme"); ?></label>
                <div class="controls">
                    <?php
                    $thm = array ('default' => 'Default');
                    echo form_dropdown('theme', $thm, $Settings->theme, 'class="form-control" id="theme"'); ?>
                </div>
            </div></div>
        <div class="col-md-4"><div class="form-group">
                <label for="language"><?= lang("language"); ?></label>
                <div class="controls">
                    <?php
                    $lang = array (
                        'english' => 'English',
                        'french' => 'French',
                        'spanish' => 'Spanish',
                        );
                    echo form_dropdown('language', $lang, $Settings->language, 'class="form-control" id="language"'); ?>
                </div>
            </div></div>
        <div class="col-md-4"><div class="form-group">
                <label class="control-label" for="email"><?= lang("default_email"); ?></label>
                <div class="controls"> <?php echo form_input('email', $Settings->default_email, 'class="form-control tip" required="required" id="email"'); ?> </div>
            </div></div>
        <div class="col-md-4"><div class="form-group">
                <label for="currency_prefix"><?= lang("currency_code"); ?></label>
                <div class="controls"> <?= form_input('currency_prefix', $Settings->currency_prefix, 'class="form-control" id="currency_prefix"');?> </div>
            </div></div>
        <div class="col-md-4"><div class="form-group">
                <label for="major"><?= lang("currency_major"); ?></label>
                <div class="controls"> <?= form_input('major', $Settings->major, 'class="form-control" id="major"');?> </div>
            </div></div>
        <div class="col-md-4"><div class="form-group">
                <label for="minor"><?= lang("currency_minor"); ?></label>
                <div class="controls"> <?= form_input('minor', $Settings->minor, 'class="form-control" id="minor"');?> </div>
            </div></div>
        <div class="col-md-4"><div class="form-group">
                <label for="tax_rate"><?= lang("tax_rate"); ?></label>
                <div class="controls">
                    <?php  $tr[0] = lang('disable');
                    foreach($tax_rates as $rate){
                        $tr[$rate->id] = $rate->name;
                    }

                    echo form_dropdown('tax_rate', $tr, $Settings->default_tax_rate, 'class="form-control" id="tax_rate"'); ?>
                </div>
            </div></div>

        <div class="col-md-4"><div class="form-group">
                <label for="tax_rate"><?= lang("display_to_words"); ?></label>
                <div class="controls">
                    <?php
                    $tw = array ( '0' => lang("disable"), '1' => lang("enable"));
                    echo form_dropdown('display_words', $tw, $Settings->display_words, 'class="form-control tip chzn-select" data-placeholder="'.lang("select").' '.lang("display_to_words").'" required="required" data-error="'.lang("display_to_words").' '.lang("is_required").'"'); ?>
                </div>
            </div></div>

        <div class="col-md-4"><div class="form-group">
                <label for="tax_rate"><?= lang("add_html_to_email"); ?></label>
                <div class="controls">
                    <?php
                    echo form_dropdown('email_html', $tw, $Settings->email_html, 'class="form-control tip chzn-select" data-placeholder="'.lang("select").' '.lang("email_html").'" required="required" data-error="'.lang("email_html").' '.lang("is_required").'"'); ?>
                </div>
            </div></div>

        <div class="col-md-4">
            <div class="form-group">
                <label class="control-label" for="date_format"><?= lang("date_format"); ?></label>

                <div class="controls">
                    <?php
                    foreach ($date_formats as $date_format) {
                        $dt[$date_format->id] = $date_format->js;
                    }
                    echo form_dropdown('date_format', $dt, $Settings->dateformat, 'id="date_format" class="form-control tip chzn-select" required="required" data-error="'.lang("date_format").' '.lang("is_required").'"');
                    ?>
                </div>
            </div>
        </div>

        <div class="col-md-4"><div class="form-group">
                <label for="product_serial"><?= lang("print_payment_on_invoice"); ?></label>
                <div class="controls">
                    <?php
                    $ps = array ( '0' => lang("disable"), '1' => lang("enable"));
                    echo form_dropdown('print_payment', $ps, $Settings->print_payment, 'class="form-control tip chzn-select" data-placeholder="'.lang("select").' '.lang("print_payment_on_invoice").'" required="required" data-error="'.lang("print_payment_on_invoice").' '.lang("is_required").'"'); ?>
                </div>
            </div></div>

        <div class="col-md-4"><div class="form-group">
                <label for="product_serial"><?= lang("calendar"); ?></label>
                <div class="controls">
                    <?php
                    $cl = array ( '0' => lang("shared"), '1' => lang("private"));
                    echo form_dropdown('calendar', $cl, $Settings->calendar, 'class="form-control tip chzn-select" data-placeholder="'.lang("select").' '.lang("calendar").'"'); ?>
                </div>
            </div></div>
        <div class="col-md-4"><div class="form-group">
                <label for="restrict_sales"><?= lang("restrict_sales"); ?></label>
                <div class="controls">
                    <?php
                    $rs = array ( '0' => lang("disable"), '1' => lang("enable"));
                    echo form_dropdown('restrict_sales', $rs, $Settings->restrict_sales, 'class="form-control tip chzn-select" data-placeholder="'.lang("select").' '.lang("restrict_sales").'"'); ?>
                </div>
            </div></div>
        <div class="col-md-4"><div class="form-group">
                <label for="rows_per_page"><?= lang("rows_per_page"); ?></label>
                <div class="controls">
                    <?php
                    $options = array (
                        '10' => '10',
                        '25' => '25',
                        '50' => '50',
                        '100' => '100',
                        '-1' => 'All (not recommended)');
                    echo form_dropdown('rows_per_page', $options, $Settings->rows_per_page, 'class="form-control" id="rows_per_page"'); ?>
                </div>
            </div></div>
        <div class="col-md-4"><div class="form-group">
                <label for="no_of_rows"><?= lang("no_of_rows"); ?></label>
                <div class="controls"> <?= form_input('no_of_rows', $Settings->no_of_rows, 'class="form-control" id="no_of_rows"');?> </div>
            </div></div>

        <div class="col-md-4"><div class="form-group">
                <label for="customer_user"><?= lang("auto_create_customer_user"); ?></label>
                <div class="controls"> <?= form_dropdown('customer_user', $rs, $Settings->customer_user, 'class="form-control" id="customer_user"');?> </div>
            </div></div>
        <div class="col-md-4">
            <div class="form-group">
                <?= lang('product_discount', 'product_discount'); ?>
                <?= form_dropdown('product_discount', $rs, $Settings->product_discount, 'class="form-control" id="product_discount" required="required" style="width:100%;"'); ?>
            </div>
        </div>

        <div class="clearfix"></div>
        <div class="col-md-4"><div class="form-group">
                <label class="control-label" for="decimals"><?= lang("decimals"); ?></label>
                <div class="controls"> <?php
                    $decimals = array(0 => lang('disable'), 1 => '1', 2 => '2');
                    echo form_dropdown('decimals', $decimals, $Settings->decimals, 'class="form-control tip" id="decimals"  style="width:100%;" required="required"');
                    ?>
                </div>
            </div></div>
        <div class="col-md-4"><div class="form-group">
                <label class="control-label" for="decimals_sep"><?= lang("decimals_sep"); ?></label>
                <div class="controls"> <?php
                    $dec_point = array('.' => lang('dot'), ',' => lang('comma'));
                    echo form_dropdown('decimals_sep', $dec_point, $Settings->decimals_sep, 'class="form-control tip" id="decimals_sep"  style="width:100%;" required="required"');
                    ?>
                </div>
            </div></div>
        <div class="col-md-4"><div class="form-group">
                <label class="control-label" for="thousands_sep"><?= lang("thousands_sep"); ?></label>
                <div class="controls"> <?php
                    $thousands_sep = array('.' => lang('dot'), ',' => lang('comma'), '0' => lang('space'));
                    echo form_dropdown('thousands_sep', $thousands_sep, $Settings->thousands_sep, 'class="form-control tip" id="thousands_sep"  style="width:100%;" required="required"');
                    ?>
                </div>
            </div></div>

        <div class="col-md-4"><div class="form-group">
                <label class="control-label" for="protocol"><?= lang("email_protocol"); ?></label>
                <div class="controls"> <?php
                    $popt = array('mail' => 'PHP Mail Function', 'sendmail' => 'Send Mail', 'smtp' => 'SMTP');
                    echo form_dropdown('protocol', $popt, $Settings->protocol, 'class="form-control tip" id="protocol"  style="width:100%;" required="required"');
                    ?>
                </div>
            </div></div>
        <div class="clearfix"></div>
        <div class="row" id="sendmail_config" style="display: none;">
            <div class="col-md-12">
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label" for="mailpath"><?= lang("mailpath"); ?></label>
                        <div class="controls"> <?php echo form_input('mailpath', $Settings->mailpath, 'class="form-control tip" id="mailpath"'); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row" id="smtp_config" style="display: none;">
            <div class="col-md-12">
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label" for="smtp_host"><?= lang("smtp_host"); ?></label>
                        <div class="controls"> <?php echo form_input('smtp_host', $Settings->smtp_host, 'class="form-control tip" id="smtp_host"'); ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label" for="smtp_user"><?= lang("smtp_user"); ?></label>
                        <div class="controls"> <?php echo form_input('smtp_user', $Settings->smtp_user, 'class="form-control tip" id="smtp_user"'); ?> </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label" for="smtp_pass"><?= lang("smtp_pass"); ?></label>
                        <div class="controls"> <?php echo form_password('smtp_pass', '', 'class="form-control tip" id="smtp_pass"'); ?> </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label" for="smtp_port"><?= lang("smtp_port"); ?></label>
                        <div class="controls"> <?php echo form_input('smtp_port', $Settings->smtp_port, 'class="form-control tip" id="smtp_port"'); ?> </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label" for="smtp_crypto"><?= lang("smtp_crypto"); ?></label>
                        <div class="controls"> <?php
                            $crypto_opt = array('' => lang('none'), 'tls' => 'TLS', 'ssl' => 'SSL');
                            echo form_dropdown('smtp_crypto', $crypto_opt, $Settings->smtp_crypto, 'class="form-control tip" id="smtp_crypto"');
                            ?> </div>
                    </div>
                </div>
            </div>
        </div>
        </div>

        <div class="form-group">
            <div class="controls"> <?= form_submit('submit', lang("update_settings"), 'class="btn btn-primary"');?> </div>
        </div>
        <?= form_close();?>

        <p><strong>Cron Job:</strong> <code>0 1 * * * wget -qO- <?= base_url(); ?>cron/run &gt;/dev/null 2&gt;&amp;1</code> to run at 1:00 AM daily.</p>
        <div class="clearfix"></div>
    </div>
    <div class="clearfix"></div>
</div>
<script>
    $(document).ready(function () {
        if ($('#protocol').val() == 'smtp') {
            $('#smtp_config').slideDown();
        } else if ($('#protocol').val() == 'sendmail') {
            $('#sendmail_config').slideDown();
        }
        $('#protocol').change(function () {
            if ($(this).val() == 'smtp') {
                $('#sendmail_config').slideUp();
                $('#smtp_config').slideDown();
            } else if ($(this).val() == 'sendmail') {
                $('#smtp_config').slideUp();
                $('#sendmail_config').slideDown();
            } else {
                $('#smtp_config').slideUp();
                $('#sendmail_config').slideUp();
            }
        });
    });
</script>