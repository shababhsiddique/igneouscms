<?php
$admin_logged_in = $this->session->userdata('admin_logged_in');
if ($admin_logged_in == true) {
    ?>

    <script type = "text/javascript" src = "<?php echo base_url() ?>resources/admin/js/plugins/nicedit/nicEdit.js"></script>
    
    <script type="text/javascript">

                                           
        var myNicEditor;
        if (window.self === window.top) {

        } else {
                                        
            var under_edit = false;
            
                                                                
            $(window).on('beforeunload', function() {
                console.log(under_edit);
                if(under_edit == true ){
                    return 'Your own message goes here...';
                } 
            });
            
                                
            //<![CDATA[
            bkLib.onDomLoaded(function() {
                myNicEditor = new nicEditor({
                    iconsPath: '<?php echo base_url() ?>resources/admin/js/plugins/nicedit/nicEditorIcons.gif',
                    fullPanel: true,
                    onSave: function(content, id, instance) {
                        
                        var table = $("#"+id).data("tbl");
                        var primary_key = $("#"+id).data("pk");
                        var update_column = $("#"+id).data("dc");
                        var content_id = $("#"+id).data("id");
                                                                                    
                        $.ajax({
                            type: 'POST',
                            url: "<?php echo site_url('admin/dashboard/ajaxWysiwygHandler') ?>",
                            data: {
                                id: content_id,
                                table: table,
                                primary_key: primary_key,
                                update_column: update_column,
                                update: content
                            },
                            beforeSend: function() {
                                $("#process_underway").css("visibility", "visible");
                            },
                            success: function(data) {
                                // successful request; do something with the data
                                $("#process_underway").css("visibility", "hidden");
                                alert(data);

                            },
                            error: function() {
                                // failed request; give feedback to user
                            }
                        });

                    }
                });
                myNicEditor.setPanel('myNicPanel');
                myNicEditor.addEvent('blur',  function(instance) {
                    // Your code here that is called whenever the user blurs (stops editing) the nicedit instance
                    if(instance!=null){
                        id = instance.e.id;
                        content = $("#"+id).html();
                                           
                        var table = $("#"+id).data("tbl");
                        var primary_key = $("#"+id).data("pk");
                        var update_column = $("#"+id).data("dc");
                        var content_id = $("#"+id).data("id");
                        
                        $.ajax({
                            type: 'POST',
                            url: "<?php echo site_url('admin/dashboard/ajaxWysiwygHandler') ?>",
                             data: {
                                id: content_id,
                                table: table,
                                primary_key: primary_key,
                                update_column: update_column,
                                update: content
                            },
                            beforeSend: function() {
                                $("#process_underway").css("visibility", "visible");
                            },
                            success: function(data) {
                                // successful request; do something with the data
                                $("#process_underway").css("visibility", "hidden");
                                console.log("Update Success");
                                under_edit = false;
                            },
                            error: function() {
                                // failed request; give feedback to user
                            }
                        });
                    }

                });
                myNicEditor.addEvent('focus',  function() {
                    under_edit = true;     
                });
            });
            //]]>
        }
                                                
                                         


    </script>
    <style type="text/css">
        #process_underway{
            width: 100px;
            height: 100px;

            background-color: rgba(0,136,204,0.03);

            /*border-radius: 50px;*/

            background-image: url("<?php echo base_url() ?>css/admin/images/ajax-loader.gif");
            background-repeat: no-repeat;
            background-position: center center;

            visibility: hidden;
            position: absolute;
            top:0;
            bottom: 0;
            left: 0;
            right: 0;

            font-size: 20px;
            font-weight: bold;

            margin: auto;
            color: #0088cc;
        }
        div#myNicPanel{
            margin: 5px;
            position: fixed;
            top: 0px;
            background-color: transparent;
            z-index: 999999;               
        }
        div#myNicPanelBottom{
            margin: 5px;
            position: fixed;
            bottom: 0px;
            right: 0px;
            z-index: 999;               
        }            
    </style>

    <?php
}
?>