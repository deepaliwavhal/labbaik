function showdataTable(resource, id, viewtype) {
    //alert("showdataTable"+id);
    resource1 = resource;
    if (id != '')
        resource1 = resource + '/' + id + '/' + viewtype;
    else
        resource1 = resource + '/0/' + viewtype;
    //alert(resource1);
    oTable = $('#right_datatable').dataTable({
        "bJQueryUI": true,
        "bProcessing": true,
        //"bServerSide": true,
        "sAjaxSource": siteurl + "ajax/" + resource1,
        //"sServerMethod": "POST",
        "sPaginationType": "full_numbers",
        "bPaginate": true,
        "bLengthChange": false,
        "iDisplayLength": 5,
        "sPaginationType": "full_numbers",
                /*"oLanguage": {
                 "oPaginate": {
                 "sFirst":    "",
                 "sPrevious": "&laquo; Prev",
                 "sNext":     "Next &raquo;",
                 "sLast":     ""
                 }
                 },
                 
                 "aoColumnDefs": [
                 { "bSortable": false, "aTargets": [2] }
                 ]*/
    });


}

       /* $("#itbm_datatable").dataTable({
            "bDestroy": true,
            "serverSide": true,
            "processing": true,
            "sPaginationType": "full_numbers",
            "bPaginate": true,
            "sAjaxSource": base_url + "/datatable/list",
            "iDisplayLength": 10,
            "aoAjaxData":"oPostData",
             "aLengthMenu": [[10,20,50,100],[10,20,50,100]],
            "fnServerData": function (sSource, aoData, fnCallback) {
                aoData.push( { "name": "resource", "value": $("#itbm_datatable").data("resource") });
                if(typeof $("#module_id").val()!='undefined')
                     aoData.push( { "name": "module_id", "value": $("#module_id").val() });
                if($("#itbm_datatable").data("edit"))
                    aoData.push( { "name": "editlink", "value": $("#itbm_datatable").data('edit') });
                if($("#itbm_datatable").data("changeorder"))
                    aoData.push( { "name": "changeorderlink", "value": $("#itbm_datatable").data('changeorder') });
                if($("#itbm_datatable").data("primary"))
                  aoData.push( { "name": "primary", "value": $("#itbm_datatable").data('primary') });
                if($("#itbm_datatable").data("moduleid"))
                  aoData.push( { "name": "module_id", "value": $("#itbm_datatable").data('moduleid') });
                if($("#itbm_datatable").data("delete"))
                  aoData.push( { "name": "deletelink", "value": $("#itbm_datatable").data('delete') });
              if($("#itbm_datatable").data("release"))
                  aoData.push( { "name": "releaselink", "value": $("#itbm_datatable").data('release') });
              if($("#itbm-show-datatable").data("kpifilter"))
                  aoData.push( { "name": "kpifilter", "value": $("#itbm-show-datatable").data('kpifilter') });

                if($("#itbm_datatable").data("colid"))
                    aoData.push( { "name": "colid", "value": $("#itbm_datatable").data('colid') });
                $.getJSON(sSource, aoData, function (json) {
                    fnCallback(json)
                    Metronic.init(); // init metronic core componets
                    $('.group-checkable').on('change',App.Common.TableGroupRowSelect);
                   // $('.disableDrag').on('mouseover',App.Common.DisableDrag);
                    $('.checkboxes').on('change',App.Common.TableRowSelect);
                    $('#itbm_datatable').find('.dataTables_length select').addClass("form-control input-xsmall input-inline"); // modify table per page dropdown
                });
            },
            "aoColumnDefs": aryJSONColTable,
           "aaSorting": [ ]
        });*/
