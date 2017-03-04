/* JS */
function addAlert(message, type) {
    $('.alerts-con').empty().append(
        '<div class="alert alert-' + type + '">' +
        '<button type="button" class="close" data-dismiss="alert">' +
        '&times;</button>' + message + '</div>');
}

function widthFunctions(e) {
    $(".tip").tooltip();
    $(".chzn-container").css('width', '100%');
    var bH = $('body').height();
    var nH = $('.navbar').outerHeight();
    var mH = $('.mainbar').outerHeight();
    var mmH = $('.mainbar .matter').outerHeight();
    var mphH = $('.mainbar .page-head').outerHeight();
    var emH = mmH + mphH;
    var sbH = $('.sidebar-inner').height();
    if ( mH > sbH ) {
        $('.sidebar-inner').css('min-height', (mH)+'px');
    } else if (emH > sbH) {
        $('.sidebar-inner').css('min-height', (emH)+'px');
    }
}

$(document).ready(function () {
    widthFunctions();
});
// $(window).load(function () {
//     setTimeout(widthFunctions, 2000);
// });
$(window).bind("resize", widthFunctions);
// $('.container').bind("resize", widthFunctions);

$(document).ready(function(){

    $(".has_submenu > a").click(function(e){
        e.preventDefault();
        var menu_li = $(this).parent("li");
        var menu_ul = $(this).next("ul");

        if(menu_li.hasClass("open")){
            menu_ul.slideUp(350);
            menu_li.removeClass("open")
        }
        else{
            $(".navi > li > ul").slideUp(350);
            $(".navi > li").removeClass("open");
            menu_ul.slideDown(350);
            menu_li.addClass("open");
        }
    });

    $('.modal').on('show.bs.modal', function (e) {
        $(".select").chosen({no_results_text: "No results matched", disable_search_threshold: 5, allow_single_deselect:true, width: '100%'});
    });


});

$(".totop").hide();

$(function() {
    $( "#todaydate" ).datepicker({
        onSelect: function(dateText, inst) {
            var sp = dateText.split('/')
            var href = Site.base_url+'calendar/get_day_event/' + sp[2]+'-'+sp[0]+'-'+sp[1];
            $.get(href, function( data ) {
                $("#simModal").html(data).appendTo("body").modal();
            });
        }
    });
});

/* Modal fix */
$('.modal').appendTo($('body'));

$(document).ready(function() {
    $('#gen_ref').click(function(){
        $(this).parent('.input-group').children('input').val(getRandomRef());
    });
    $("form select").chosen({no_results_text: "No results matched", disable_search_threshold: 5, allow_single_deselect:true, width: '100%'});
    $('#myTab a').click(function (e) {
        e.preventDefault()
        $(this).tab('show');
    });
    $('#myTab a').first().tab('show');
    if (location.hash !== '') $('a[href="' + location.hash + '"]').tab('show');
    return $('a[data-toggle="tab"]').on('shown', function(e) {
      return location.hash = $(e.target).attr('href').substr(1);
    });
});

function fld(oObj) {
    if (oObj != null) {
        var aDate = oObj.split('-');
        var bDate = aDate[2].split(' ');
        year = aDate[0], month = aDate[1], day = bDate[0], time = bDate[1];
        if (Site.dateFormats.js_sdate == 'dd-mm-yyyy')
            return day + "-" + month + "-" + year + " " + time;
        else if (Site.dateFormats.js_sdate === 'dd/mm/yyyy')
            return day + "/" + month + "/" + year + " " + time;
        else if (Site.dateFormats.js_sdate == 'dd.mm.yyyy')
            return day + "." + month + "." + year + " " + time;
        else if (Site.dateFormats.js_sdate == 'mm/dd/yyyy')
            return month + "/" + day + "/" + year + " " + time;
        else if (Site.dateFormats.js_sdate == 'mm-dd-yyyy')
            return month + "-" + day + "-" + year + " " + time;
        else if (Site.dateFormats.js_sdate == 'mm.dd.yyyy')
            return month + "." + day + "." + year + " " + time;
        else
            return oObj;
    } else {
        return '';
    }
}
function fsd(oObj) {
    if (oObj != null) {
        var aDate = oObj.split('-');
        if (Site.dateFormats.js_sdate == 'dd-mm-yyyy')
            return aDate[2] + "-" + aDate[1] + "-" + aDate[0];
        else if (Site.dateFormats.js_sdate === 'dd/mm/yyyy')
            return aDate[2] + "/" + aDate[1] + "/" + aDate[0];
        else if (Site.dateFormats.js_sdate == 'dd.mm.yyyy')
            return aDate[2] + "." + aDate[1] + "." + aDate[0];
        else if (Site.dateFormats.js_sdate == 'mm/dd/yyyy')
            return aDate[1] + "/" + aDate[2] + "/" + aDate[0];
        else if (Site.dateFormats.js_sdate == 'mm-dd-yyyy')
            return aDate[1] + "-" + aDate[2] + "-" + aDate[0];
        else if (Site.dateFormats.js_sdate == 'mm.dd.yyyy')
            return aDate[1] + "." + aDate[2] + "." + aDate[0];
        else
            return oObj;
    } else {
        return '';
    }
}
function formatNumber(x, d) {
    if(!d) { d = Site.Settings.decimals; }
    return accounting.formatNumber(x, d, Site.Settings.thousands_sep == 0 ? ' ' : Site.Settings.thousands_sep, Site.Settings.decimals_sep);
}
function formatMoney(x, symbol) {
    if(!symbol) { symbol = ""; }
    return accounting.formatMoney(x, symbol, Site.Settings.decimals, Site.Settings.thousands_sep == 0 ? ' ' : Site.Settings.thousands_sep, Site.Settings.decimals_sep, "%s%v");
}
function decimalFormat(x) {
    if (x != null) {
        return '<div class="text-center">'+formatNumber(x)+'</div>';
    } else {
        return '<div class="text-center">0</div>';
    }
}
function currencyFormat(x) {
    if (x != null) {
        return '<div class="text-right">'+formatMoney(x)+'</div>';
    } else {
        return '<div class="text-right">0</div>';
    }
}

function getRandomRef() {
    var min = 1000000000000000, max = 9999999999999999;
    return Math.floor(Math.random() * (max - min + 1)) + min;
}

function formatDecimal(x, d) {
    if(!d) { d = Site.Settings.decimals; }
    return parseFloat(accounting.formatNumber(x, d, ''));
}

function cf(x) { return currencyFormat(x); }
function pf(x) { return parseFloat(x); }

// for add edit pages 
function suggestions() {
    $(".suggestions").autocomplete({
        source: Site.base_url+'products/suggestions',
        select: function (event, ui) {
            var row = $(this).closest('tr');
            var sel_item = ui.item;
            row.find('.price').val(sel_item.price);
            row.find('.tax').val(sel_item.tac_rate);
            if(row.find('.quantity').val().length == 0){
                row.find('.quantity').val(1).change();
            }
            if (sel_item.details != '' && sel_item.details != null) {
                row.find('.details-con').css('display', 'block');
                row.find('.details').val(sel_item.details);
            }
            calculateTotal();
        },
        minLength: 1,
        autoFocus: false,
        delay: 250,
        response: function (event, ui) {
            if (ui.content.length == 1 && ui.content[0].id != 0) {
                ui.item = ui.content[0];
                $(this).val(ui.item.label);
                $(this).removeClass('ui-autocomplete-loading');
            }
        },
    });
}
function calculateTotal() {
    if (typeof counter !== 'undefined') {
        total = 0; var row_total = 0;
        for (i = 1; i < (counter+1); i++) {
            var shipping = parseFloat($('#shipping').val() ? $('#shipping').val() : 0);
            var row = $('#'+i);
            var quantity = row.find('.quantity').val(), 
            product = row.find('.suggestions').val(), 
            price = row.find('.price').val(), 
            discount = row.find('.discount').val(), 
            tax = row.find('.tax').val(),
            subtotal = row.find('.subtotal');
            if (quantity && product && price) {
                var product_discount = 0, product_tax = 0;

                if(Site.Settings.product_discount > 0) {
                    if (discount) {
                        if (discount.indexOf("%") !== -1) {
                            var pds = discount.split("%");
                            if (!isNaN(pds[0])) {
                                product_discount = formatDecimal((((price) * parseFloat(pds[0])) / 100), 4);
                            }
                        } else {
                             product_discount = formatDecimal(discount, 4);
                        }
                    }
                }

                if(Site.Settings.default_tax_rate > 0) {
                    $.each(tax_rates, function () {
                        if (this.id == tax) {
                            if (this.type == 1 && this.rate != 0) {
                                product_tax = formatDecimal((((price - product_discount) * this.rate) / 100), 4);
                            } else {
                                product_tax = parseFloat(this.rate);
                            }
                        }
                    });
                }
                row_total = (price - product_discount + product_tax) * quantity;
                subtotal.val(formatMoney(row_total));
                total += row_total;
            }
        }
        $('.total_amount').text(formatMoney(total));


        if ($('#order_discount').val()) {
            order_discount_val = $('#order_discount').val();
            if (order_discount_val.indexOf("%") !== -1) {
                var pds = order_discount_val.split("%");
                if (!isNaN(pds[0])) {
                    order_discount = formatDecimal((((total) * parseFloat(pds[0])) / 100), 4);
                }
            } else {
               order_discount = formatDecimal(order_discount_val, 4);
            }
        } else {
            order_discount = 0;
        }

        if ($('#order_tax').val()) {
            order_tax_val = $('#order_tax').val();
            $.each(tax_rates, function () {
                if (this.id == order_tax_val) {
                    if (this.type == 1 && this.rate != 0) {
                        order_tax = formatDecimal((((total - order_discount) * this.rate) / 100), 4);
                    } else {
                        order_tax = parseFloat(this.rate);
                    }
                }
            });
        } else {
            order_tax = 0;
        }

        grand_total = (total - order_discount) + order_tax + shipping;
        $('#order_discount_total').text(formatMoney(order_discount));
        $('#order_tax_total').text(formatMoney(order_tax));
        $('#grand_total').text(formatMoney(grand_total));
    }
}


$(document).ready(function() {

    $(document).on('click', '[data-toggle="ajax-modal"]', function (e) {
        e.preventDefault();
        var link = $(this).attr('href');
        $.get(link).done(function(data) {
            $('#myModal').html(data)
            // .append("<script src='"+assets+"js/modal.js' />")
            .modal();
        });
        return false;
    });

    $(document).on('click', '[data-toggle="modal"]', function (e) {
        e.preventDefault();
        var tm = $(this).attr('data-target');
        $(tm).appendTo('body').modal('show');
        return false;
    });

    $("#addButton").click(function () {

        var newTr = $('<tr></tr>').attr("id", counter);
        var row_hrml = '';

        row_hrml += '<td style="width: 20px; text-align: center; padding-right: 10px;">'+ counter +'</td>';
        row_hrml += '<td><input type="text" class="quantity form-control input-sm" name="quantity[]" id="quantity-' + counter + '" value="" style="min-width: 70px; text-align: center;" /></td>';
        row_hrml += '<td><div class="input-group"><input type="text" name="product[]" id="product-' + counter + '" value="" class="form-control input-sm suggestions" maxlength="80"><span class="input-group-addon"><i class="fa fa-file-text-o pointer details"></i></span></div><div class="details-con details-con-' + counter + '" style="display:none;"><textarea style="margin-top:5px;padding:5px 10px;height:60px;" class="form-control" name="details[]" id="details-' + counter + '" maxlength="255"></textarea></div></td>';
        row_hrml += '<td><input type="text" name="price[]" id="price-' + counter + '" value="" class="price form-control input-sm text-right" style="min-width: 100px;"></td>';
        if (Site.Settings.product_discount == 1) {
            row_hrml += '<td><input type="text" name="discount[]" id="discount-' + counter + '" value="" class="discount form-control input-sm"></td>';
        }
        if (Site.Settings.default_tax_rate > 0) {
            row_hrml += '<td><select class="tax form-control input-sm" style="min-width: 100px;" name="tax_rate[]" id="tax_rate-' + counter + '">';
            $.each(tax_rates, function () {
                row_hrml += '<option value="'+ this.id +'">'+ this.name +'</option>';
            });
            row_hrml += '</select></td>';
        }

        row_hrml += '<td><input type="text" name="subtotal[]" readonly id="subtotal-' + counter + '" value="" class="subtotal form-control input-sm text-right" tabindex="-1"></td>';

        newTr.html(row_hrml);
        newTr.appendTo("#dyTable");

        counter++;
        $("form select").chosen({no_results_text: "No results matched", disable_search_threshold: 5, allow_single_deselect:true, width: '100%'});

        suggestions();

    });

    $("#removeButton").click(function () {
        if (counter <= no_of_rows) {
            alert(lang.not_allowed);
            return false;
        }
        counter--;
        $("#"+counter).remove();
    });

    $( "#customer" ).change(function () {
        if($(this).val() == 'new')
            $('#customerForm').slideDown('100');
        else
            $('#customerForm').slideUp('100');
    });

    $(document).on ('blur', '.suggestions', function() {
        var row = $(this).closest('tr');
        var v = $(this).val();
        var q = row.find('.quantity');
        var qv = row.find('.quantity').val();
        if (qv.length == 0 && v.length != 0 ) {
            $(q).val(1).change();
        }
    });

    $(document).on('click', '.details', function(){
        $(this).parents('.input-group').next('.details-con').toggle();
    });

    $(document).on('change', '#shipping, #order_discount, #order_tax, .quantity, .price, .discount, .tax', function() {
        calculateTotal();
    });

    $(".notes").autocomplete({
        source: Site.base_url+'sales/notes',
        minLength: 2,
        autoFocus: false,
        delay: 500,
        response: function (event, ui) {
            if (ui.content.length == 1 && ui.content[0].id != 0) {
                ui.item = ui.content[0];
                $(this).val(ui.item.label);
                $(this).removeClass('ui-autocomplete-loading');
            }
        },
    });

    $("form select").chosen({no_results_text: "No results matched", disable_search_threshold: 5, allow_single_deselect:true, width: '100%'});
    $( ".datetime" ).datetimepicker({format: Site.dateFormats.js_ldate, autoclose: true, weekStart: 1, showMeridian: true, todayBtn: true});
    $( ".date" ).datetimepicker({format: Site.dateFormats.js_sdate, autoclose: true, todayBtn: true, minView: 2});

    $('.modal').on('show.bs.modal', function (e) {
        $( ".datetime" ).datetimepicker({format: Site.dateFormats.js_ldate, autoclose: true, weekStart: 1, showMeridian: true, todayBtn: true});
        $( ".date" ).datetimepicker({format: Site.dateFormats.js_sdate, autoclose: true, todayBtn: true, minView: 2});
    })

    suggestions();
    setTimeout(function(){ calculateTotal(); }, 1000);

});
