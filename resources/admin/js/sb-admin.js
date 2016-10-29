var base_url = $("body").data("baseurl");

$(function() {

    $('#side-menu').metisMenu();

});

//Loads the correct sidebar on window load,
//collapses the sidebar on window resize.
$(function() {
    $(window).bind("load resize", function() {
        width = (this.window.innerWidth > 0) ? this.window.innerWidth : this.screen.width;
        if (width < 768) {
            $('div.sidebar-collapse').addClass('collapse')
        } else {
            $('div.sidebar-collapse').removeClass('collapse')
        }
        
        $("#page-wrapper").css("min-height", window.innerHeight - 50);
        $("#iframe_live").css("min-height", window.innerHeight - 100);
    });
    

   
});

function confirmDelete() {

    var chk = confirm('Are you Sure You Want To Delete');
    return chk;
}

function collapsesidebar(){
    var sidebar = $(".sidebar-collapse").css("height");
    if(sidebar == "0px"){
        $("#side-menu").show();
        $(".sidebar-collapse").css("height","auto");
        $("#page-wrapper").css("margin-left", "250px");
    }else{
        $("#side-menu").hide();
        $(".sidebar-collapse").css("height","0px");
        $("#page-wrapper").css("margin-left", "10px");
    }
//    
}

function deleteImage(img,cnt,tbl,col){
    
  
    $("#process_underway").show(); 
    $.ajax({
        type: 'GET',
        url: base_url+"admin/dashboard/ajaxDelImg/"+img+"/"+tbl+"/"+col,
        beforeSend:function(){
                    
        },
        success:function(data){
           if(data == "ok"){
               $("#i_"+cnt).hide();
           }else{
               alert("file was not deleted");
           }
        },
        error:function(){           
            alert("Error");
            return false;
        }
    });      
           
    
}

function menuFilter(){

    var filterString = $("#side-menu input").val().toLowerCase();
    
    if(filterString.length >= 3){
    
        $('ul#side-menu li').each(function( index ) {        
            var link = $(this).find("> a");
            
            
            
            var html = $(this).html().toLowerCase();   
            var text = link.text().toLowerCase();            
            var srch = text.search(filterString);
            var srchh = html.search(filterString);
            //            var urlsrch = href.search(filterString);
        
        
            if(srch!= -1){
                $(this).addClass(" collapse in");
                link.addClass("highligtMenuItem ");
            //                link.css("border-right","5px solid #2ecc71");
            }
            if(srchh!= -1){
                $(this).addClass(" collapse in");
                link.addClass("highligtMenuItem ");
            //                link.css("border-right","5px solid #2ecc71");
            }else{            
                $(this).removeClass(" collapse in");
                link.removeClass("highligtMenuItem ");
            //                link.css("border-right","none");
            }
        
        });
        
    }else{
        $('ul#side-menu li a').removeClass("highligtMenuItem");
    }
}
 
 
/* DataTable initialisation */
$(document).ready(function() {
    
    $("#process_underway").hide();  


    //    $('a').each(function(){ 
    //        $(this).click(function(){ 
    //            var href= $(this).attr("href");
    //            var target = $(this).attr("target");
    //           
    //            if(target != "_blank" && href != "#"){               
    //               
    //                $("#process_underway").show();  
    //                $.ajax({
    //                    type: 'GET',
    //                    url: href+"?ajax=y",
    //                    beforeSend:function(){
    //                
    //                    },
    //                    success:function(data){
    //                        $("#contents-inner-wrapper").html(data);
    //                        $("#process_underway").hide(); 
    //                        return false 
    //                    },
    //                    error:function(){           
    //                        alert("Error");
    //                        return false;
    //                    }
    //                });      
    //            }
    //            return false;
    //        }); 
    //    }); 

    $('.prefilled_select').each(function( index ) {        
        $(this).val($(this).data("value"));
    });
  
    var dataSource = $('#datatableSource').val();
    var sSearch =  $('#datatableSearch').val();

    if (dataSource == "dom") {

        $('.datatableObject').dataTable({
            "sDom": "<'row'<'col-md-6'l><'col-md-6'f>r>t<'row'<'col-md-6'i><'col-md-6'p>>",
            "sPaginationType": "bootstrap",
            "sServerMethod": "POST",
            "oSearch": {
                "sSearch": sSearch
            },
            "bProcessing": true,  
            "oLanguage": {                         
                "sLengthMenu": '<select class="form-control input-sm">'+
                '<option value="10">10</option>'+
                '<option value="25">20</option>'+
                '<option value="50">50</option>'+
                '<option value="-1">All</option>'+
                '</select> Records per page',
                "sProcessing": "<span id='process_underway'></span>" /*Process loading indicator html*/
            }
        });

    } else {

        $('.datatableObject').dataTable({            /*Initialize datatable by class datatableObject*/
            "sDom": "<'row'<'col-md-6'l><'col-md-6'f>r>t<'row'<'col-md-6'i><'col-md-6'p>>",    /*Special dom rule for using bootstrap styles*/
            "sPaginationType": "bootstrap",         /*Bootstrap pagination*/
            "bServerSide": true,                     /*Use server data*/
            "sAjaxSource": dataSource,              /*URL of json data source*/
            "sServerMethod": "POST",                /*POST method used to for server side operations*/
            "oSearch": {
                "sSearch": sSearch                      /*Set initial search text*/
            },
            "fnInitComplete": function() {             /*Set focus to the search filter box on load*/
                $('#datatableObject_filter label input[type=text]').focus(); 
                $('#datatableObject_filter label input[type=text]').addClass("form-control");
            },
            "bProcessing": true,                    /*Enable processing indicator */
            "oLanguage": {                         
                //                            "sLengthMenu": "_MENU_ records per page", 
                "sLengthMenu": '<select class="form-control input-sm">'+
                '<option value="10">10</option>'+
                '<option value="25">20</option>'+
                '<option value="50">50</option>'+
                '<option value="-1">All</option>'+
                '</select> Per page',
                "sProcessing": "<span id='process_underway'></span>" /*Process loading indicator html*/
            }
        });
    }

});
            

function openKCFinder(field_name, url, type, win) {
    tinyMCE.activeEditor.windowManager.open({
        file: base_url + 'resources/admin/js/plugins/kcfinder/browse.php?opener=tinymce&type=' + type,
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
    editor_selector: "rich-textarea",
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