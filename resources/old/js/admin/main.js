$('.typeahead').typeahead({                                
    name: 'articlecategory',    
    remote: base_url + indexphp + "admin/dashboard/jsonArticleCategories",                                                     
    prefetch: base_url + indexphp + "admin/dashboard/jsonArticleCategories",                                         
    limit: 5                                                                   
});

$(function() {
    $(".datepicker").datepicker();
    $("ul.sortable").sortable({
        connectWith: "ul",
        cancel: ".ui-state-disabled"
    });

    $(".sortable,.sortable li, .listTitle").disableSelection();

    $(".primary_focus").focus();
    $('form:first *:input[type!=hidden]:first').focus();

});


function validatePass(p1, p2) {
    if (p1.value != p2.value || p1.value == '' || p2.value == '') {
        p2.setCustomValidity('Password incorrect');
    } else {
        p2.setCustomValidity('');
    }
}

function openKCFinder(field_name, url, type, win) {
    tinyMCE.activeEditor.windowManager.open({
        file: base_url + 'js/kcfinder/browse.php?opener=tinymce&type=' + type,
        title: 'KCFinder',
        width: 700,
        height: 500,
        resizable: "yes",
        inline: true,
        close_previous: "no",
        popup_css: false
    }, {
        window: win,
        input: field_name
    });
    return false;
}

tinyMCE.init({
    mode: "specific_textareas",
    editor_selector: "richtextarea",
    theme: "advanced",
    plugins: "table",
    file_browser_callback: 'openKCFinder',
    theme_advanced_buttons3_add: "tablecontrols",
    document_base_url: base_url,
    relative_urls: false,
    remove_script_host: false,
    convert_urls: true,
    height: "350px",
    width: "100%"
});

tinyMCE.init({
    mode: "specific_textareas",
    editor_selector: "htmlblockeditor",
    theme: "advanced",
    plugins: "table",
    file_browser_callback: 'openKCFinder',
    theme_advanced_buttons3_add: "tablecontrols",
    document_base_url: base_url,
    relative_urls: false,
    remove_script_host: false,
    convert_urls: true,
    force_br_newlines: false,
    force_p_newlines: false,
    forced_root_block: '',
    height: "350px",
    width: "100%"
});

function confirmDelete() {

    var chk = confirm('Are you Sure You Want To Delete');
    return chk;
}

/* DataTable initialisation */
$(document).ready(function() {


    var min_height = $(window).height() - 158;

    $("footer").css('visibility', 'visible');

    $(".main_content").css('min-height', min_height)

    var dataSource = $('#datatableSource').val();
    var sSearch = $('#datatableSearch').val();

    if (dataSource == "dom") {

        $('.datatableObject').dataTable({
            "sDom": "<'row'<'span6'l><'span6'f>r>t<'row'<'span6'i><'span6'p>>",
            "sPaginationType": "bootstrap",
            "sServerMethod": "POST",
            "oSearch": {
                "sSearch": sSearch
            },
            "bProcessing": true,  
            "oLanguage": {
                "sLengthMenu": "_MENU_ records per page",
                "sProcessing": "<span id='process_underway'></span>"
            }
        });

    } else {

        $('.datatableObject').dataTable({            /*Initialize datatable by class datatableObject*/
            "sDom": "<'row'<'span6'l><'span6'f>r>t<'row'<'span6'i><'span6'p>>",    /*Special dom rule for using bootstrap styles*/
            "sPaginationType": "bootstrap",         /*Bootstrap pagination*/
            "bServerSide": true,                     /*Use server data*/
            "sAjaxSource": dataSource,              /*URL of json data source*/
            "sServerMethod": "POST",                /*POST method used to for server side operations*/
            "oSearch": {
                "sSearch": sSearch                      /*Set initial search text*/
            },
            "fnInitComplete": function() {             /*Set focus to the search filter box on load*/
                $('#datatableObject_filter label input[type=text]').focus();                
            },
            "bProcessing": true,                    /*Enable processing indicator */
            "oLanguage": {                         
                "sLengthMenu": "_MENU_ records per page", 
                "sProcessing": "<span id='process_underway'></span>" /*Process loading indicator html*/
            }
        });
    }


});


function editBlock(item) {

    //var indx = $(item).parent("a").parent("li").find("a.block_id").attr("href");
    var indx = $(item).parent("a").parent("li").index();

    var blocktype = $(item).parent("a").parent("li").data('blocktype');
    var blockref = $(item).parent("a").parent("li").data('blockref');

    if (blocktype == "ajax") {
        $("#data_source").val(blocktype);
        $("#data_url").val(blockref);
        $("#ajax_block_group").css("visibility", "visible");
    } else {
        $("#data_source").val(blocktype + "_" + blockref);
        $("#data_url").val('');
        $("#ajax_block_group").css("visibility", "hidden");
    }


    $("#block_index").val(indx);

//    console.log(indx);

//    alert("time to edit item "+indx);
}

$("#myModalForm").submit(changeBlockProperties);

function changeBlockProperties() {
    var index = parseInt($("#block_index").val()) + 1;
    var blocktype = $("#data_source").val();
    var blocktitle = $("#data_source option:selected").text();
    var blockref = $("#data_url").val();

    $('#gridster_ul li:nth-child(' + index + ')').data('blocktype', blocktype);
    
    var commonHTML = "<span class='pull-right icon-remove' onclick='removeBlock(this)'> </span> <a href='#myModal' role='button' data-toggle='modal'><span class='pull-right icon-pencil' onclick='editBlock(this)'></span></a>";
    $('#gridster_ul li:nth-child(' + index + ')').html(commonHTML+blocktitle);


    if (blocktype == "ajax") {
        $('#gridster_ul li:nth-child(' + index + ')').data('blocktype', blocktype);
        $('#gridster_ul li:nth-child(' + index + ')').data('blockref', blockref);
    } else {
        blocktype = blocktype.split("_");
        if (blocktype[0] == "view") {
            $('#gridster_ul li:nth-child(' + index + ')').data('blocktype', blocktype[0]);
            $('#gridster_ul li:nth-child(' + index + ')').data('blockref', blocktype[1]);
        } else if (blocktype[0] == "block") {
            $('#gridster_ul li:nth-child(' + index + ')').data('blocktype', blocktype[0]);
            $('#gridster_ul li:nth-child(' + index + ')').data('blockref', blocktype[1]);
        }
    }

    sendUpdatedLayout();
}

function preview() {
    var gridster = $(".gridster ul").gridster().data('gridster');

}


function colorSpan(rowspan, colspan) {
    
    for(var i=0 ; i<rowspan; i++){
        var rows = $("tr.spanSelectorGridRow").slice(i, i+1);
        rows.children("td:lt("+colspan+")").css('opacity', '1');       
    }
    
    $("#spanCurrentVal").html(rowspan + "x" + colspan);
}

function colorSpanOld(colspan) {
    $(".spanSelectorGridRow td").slice(0, colspan).css('opacity', '1');
    $("#spanCurrentVal").html(colspan);
}

function unColorSpan() {
    $(".spanSelectorGridRow td").css('opacity', '0.5');
}


function addBlock(colspan,rowspan) {

    var gridster = $(".gridster ul").gridster().data('gridster');
    gridster.add_widget("<li " +
        " data-row='1' " +
        " data-col='1'" +
        " data-sizex='3' " +
        " data-sizey='1'" +
        " data-blocktype='block'" +
        " data-blockref='b1'>" +
        " <span class='pull-right icon-remove' onclick='removeBlock(this)'> </span>" +
        ' <a href="#myModal" role="button" data-toggle="modal"><span class="pull-right icon-pencil" onclick="editBlock(this)"></span></a> ' +
        " </li>", rowspan, colspan);

    $("html, body").animate({
        scrollTop: $(document).height()
    }, 1000);
}

function removeBlock(item) {


    var indx = $(item).parent('li').index();

    var gridster = $(".gridster ul").gridster().data('gridster');

    gridster.remove_widget($('.gridster li').eq(indx));

    $("html, body").animate({
        scrollTop: $(document).height()
    }, 1000);
}


function buildLayoutEditor() {

    var cols = 12;


    $(".gridster").ready();

    var total = $(".gridster ul").width();

    total = total - 4 * cols * 2;

    $(".gridster ul").gridster({
        min_cols: cols,
        max_size_x: 12,
        max_size_y: 12,
        widget_margins: [4, 4],
        widget_base_dimensions: [total / cols, total / cols + total / cols]
    });
}


$(function() { //DOM Ready 
    buildLayoutEditor();
});

$(".gridster ul li").mousedown(sendUpdatedLayout);

function sendUpdatedLayout() {
    var gridster = $(".gridster ul").gridster().data('gridster');

    var jsonAsString = JSON.stringify(gridster.serialize());

    $("#gridster_ul_serialized").val(jsonAsString);

    console.log(jsonAsString);

    return true;
}


function toggleinput(currentval) {


    var itemToHide = "ajax_block_group";
    var itemToDisplay = "ajax_block_group";

    var rawtext = $("#data_source option:selected").text();

    var text = rawtext.split("-");


    if (text[0] == "Controller") {
        itemToHide = "block_edit_link";
        itemToDisplay = "ajax_block_group";

    } else if (text[0] == "Block") {
        itemToHide = "ajax_block_group";
        itemToDisplay = "block_edit_link";

        if (text[1] == "New") {
            newPopup(base_url + indexphp + "admin/dashboard/block_auth");
        } else {
            var href = "JavaScript:newPopup('" + base_url + indexphp + "admin/dashboard/block_auth/";
            console.log(href);


            href = href + text[1] + "'); ";
            console.log(href);

            $("#block_edit_link").attr("href", href);
        }
    } else {
        itemToHide = "ajax_block_group,#block_edit_link";
        itemToDisplay = "";
    }

    $("#" + itemToHide).css("visibility", "hidden");
    $("#" + itemToDisplay).css("visibility", "visible");

}


$(function() {

    $('.colorPicker').colorpicker();



    $('.prefilled_select').each(function( index ) {        
        $(this).val($(this).data("value"));
    });




});



// Popup window code
function newPopup(url) {

    popupWindow = window.open(url, 'popUpWindow', 'height=700,width=800,left=10,top=10,resizable=yes,scrollbars=yes,toolbar=yes,menubar=no,location=no,directories=no,status=yes');

    var id = $("#data_source").val();

    var timer = setInterval(function() {
        if (popupWindow.closed) {
            clearInterval(timer);


            $.ajax({
                type: 'GET',
                url: base_url + indexphp + 'admin/dashboard/httpCellOptions',
                beforeSend: function() {
                // this is where we append a loading image
                },
                success: function(data) {
                    // successful request; do something with the data
                    $("#data_source").html(data);

                    if (id != "block") {
                        $("#data_source").val(id);
                    } else {
                        id = $('#block_group_opt option:last-child').val();
                        $("#data_source").val(id);
                    }
                },
                error: function() {
                // failed request; give feedback to user
                }
            });

        }
    }, 1000);

}
