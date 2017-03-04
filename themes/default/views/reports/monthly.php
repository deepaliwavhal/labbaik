<link href="<?= $assets; ?>style/calender.css" rel="stylesheet">
<div class="page-head">
    <h2 class="pull-left"><?= $page_title; ?> <span class="page-meta"><?= lang('total'); ?> = <span class='violet'>Violet</span>, <?= lang('paid'); ?> = <span class='green'>Green</span> and <?= lang('balance'); ?> = <span class='orange'>Orange</span></span> </h2>
</div>
<div class="clearfix"></div>
<div class="matter">
    <div class="container">
        <p>&nbsp;</p>
        <style>
            .table td { width: 8.333%; }
            .table tr:first-child td { text-align:center; }
            .table tr:last-child td { text-align:right; }
        </style>

        <table class="table table-bordered" style="min-width:522px;">
            <thead>
                <tr>
                    <th><div class="text-center"> <a href="<?= site_url('reports/monthly_sales'); ?>?year=<?= $year-1; ?>">&lt;&lt;</a></div></th>
                    <th colspan="10"><div class="text-center"> <?= $year; ?> </div></th>
                    <th><div class="text-center"> <a href="<?= site_url('reports/monthly_sales'); ?>?year=<?= $year+1; ?>">&gt;&gt;</a></div></th>
                </tr>
            </thead> 
            <tr>
                <td><?= lang('cal_january'); ?></td>
                <td><?= lang('cal_february'); ?></td>
                <td><?= lang('cal_march'); ?></td>
                <td><?= lang('cal_april'); ?></td>
                <td><?= lang('cal_may'); ?></td>
                <td><?= lang('cal_june'); ?></td>
                <td><?= lang('cal_july'); ?></td>
                <td><?= lang('cal_august'); ?></td>
                <td><?= lang('cal_september'); ?></td>
                <td><?= lang('cal_october'); ?></td>
                <td><?= lang('cal_november'); ?></td>
                <td><?= lang('cal_december'); ?></td>
            </tr>
            <tr>
                <?php
                if(!empty($sales)) {
                    foreach($sales as $value) {
                        $array[date('n', strtotime($value->date))] = "<table class='table table-condensed table-striped'><tr><td style='text-align:left;'>".lang('total').
                        "</td></tr><tr><td style='font-weight:bold;'>{$this->sim->formatMoney($value->inv_total)}</td></tr><tr><td style='text-align:left;'>".lang('tax').
                        "</td></tr><tr><td style='font-weight:bold;'>{$this->sim->formatMoney($value->tax)}</td></tr><tr><td style='text-align:left;' class='violet'>".lang('grand_total').
                        "</td></tr><tr><td style='font-weight:bold;' class='violet'>{$this->sim->formatMoney($value->total)}</td></tr><tr><td style='text-align:left;' class='green'>".lang('paid').
                        "</td></tr><tr><td style='font-weight:bold;' class='green'>{$this->sim->formatMoney($value->paid)}</td></tr><tr><td style='text-align:left;' class='orange'>".lang('balance').
                        "</td></tr><tr><td style='font-weight:bold;' class='orange'>{$this->sim->formatMoney($value->total - $value->paid)}</td></tr></table>";
                    }

                    for ($i = 1; $i <= 12; $i++) {
                        echo "<td>";
                        if(isset($array[$i])) {
                            echo $array[$i];
                        }
                        echo "</td>";
                    }

                } else {
                    for($i=1; $i<=12; $i++) {
                        echo "<td>&nbsp;</td>";
                    }
                }
                ?>
            </tr>
        </table>
        <div class="clearfix"></div>
    </div>
    <div class="clearfix"></div>
</div>