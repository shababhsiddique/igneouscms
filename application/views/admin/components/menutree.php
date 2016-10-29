<?php

class Tree {

    public $render_log = "";
    private $categories_byID = array();
    private $tree = array();
    private $tagOpen = false;

    function openTag() {
        if (!$this->tagOpen) {
            echo "<ul>\n";
            $this->tagOpen = true;
        }
    }

    function closeTag() {
        if ($this->tagOpen) {
            echo "</ul>\n";
            $this->tagOpen = false;
        }
    }

    function __construct($menu) {

        $this->tree = $menu;

        foreach ($menu as $amenu) {
            $this->categories_byID[$amenu["menu_id"]] = $amenu;
        }
    }

    function printNode($node_id) {

        echo "<li id='node$node_id'><a data-published='";

        if ($this->categories_byID[$node_id]['status_id'] == 3)
            echo "published";
        else
            echo "unpublished";

        echo "' href=''>" . $this->categories_byID[$node_id]["menu_display_link"] . "</a>\n";


        $tagOpen = false;
        foreach ($this->tree as $aNode) {
            //This one belongs to the current parent
            if ($aNode["menu_parent_id"] == $node_id) {

                if ($tagOpen == false) {
                    echo "<ul>\n";
                    $tagOpen = true;
                }

                $this->printNode($aNode["menu_id"]);
            }
        }

        if ($tagOpen == TRUE) {
            echo "</ul>\n";
            $tagOpen = false;
        }

        echo "</li>\n";
    }

    function render() {

        echo '<ul id="menu_tree" class="dhtmlgoodies_tree">' . "\n";

        foreach ($this->tree as $aNode) {

            if ($aNode["menu_parent_id"] == 0) {
                $this->printNode($aNode["menu_id"]);
            }
        }

        $this->closeTag();
        echo "</ul>\n";
    }

}
?>


<div class="row">
    <div class="col-lg-12">
        <h4 class="page-header">Menu</h4>
    </div>
</div>


<!-- /.row -->
<div class="row">
    <div class="col-lg-8">
        <?php
        $menuTree = new Tree($menu);
        $menuTree->render();
        ?> 
    </div>
    <div class="col-md-4">
        <div class="alert well">
            <h4>Organizing Categories</h4>
            <p>You can simply drag drop items in the tree to reorganize the menu items. Items are save automatically after you drag / rename. Note: update request may take a while to process on the server side.</p>
        </div>
    </div>
    <!-- /.col-lg-12 -->
</div>
<a class="btn btn-success" href="<?php echo site_url("admin/dashboard/menu_auth") ?>"><i class="glyphicon glyphicon-plus"></i>&nbsp;&nbsp;<strong><?php echo $this->lang->line("Add New") ?></strong></a>
<a class="btn btn-info" href="<?php echo site_url("admin/dashboard/menu") ?>"><i class="glyphicon glyphicon-refresh"></i>&nbsp;&nbsp;<strong><?php echo $this->lang->line("Reload") ?></strong></a>
<a class="btn btn-primary" onclick="saveMyTree()"><i class="glyphicon glyphicon-floppy-save"></i>&nbsp;&nbsp;<strong><?php echo $this->lang->line("Save") ?></strong></a>

<!-- /.row -->




<!-- Page-Level Demo Scripts - Forms - Use for reference -->
<script type="text/javascript" src="<?php echo base_url() ?>resources/admin/js/plugins/dgtree/js/ajax.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>resources/admin/js/plugins/dgtree/js/context-menu.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>resources/admin/js/plugins/dgtree/js/drag-drop-folder-tree.js"></script>



<script>
    /**
     * Save functions for tree
     **/
    var ajaxObjects = new Array();  /*Arra representation of objects*/
    var prevTreeString =  '';  /* Previous string */
    var changeMade = false;  /* Change flag */
    var initialSize = 0; /* initial elements count */
        

    /*
     * Publish / unpublish  node, triggered on checkbox click
     **/
    function publishNode(item){
        var pub = item.getAttribute("data-published");
        var id = item.getAttribute("data-id");
    
        //    id = id.substr(8,id.length);

        //console.log(id);
        //console.log(pub);
        
        $("#process_underway").show();  
        if(pub == "published"){
                
            $.ajax({
                type: 'GET',
                url: '<?php echo site_url("admin/dashboard/ajaxTreeHandler") ?>?stateId='+id+"&state=4",
                beforeSend:function(){
                
                },
                success:function(data){
                    if(data != "OK")
                        alert("Error");
                    $("#process_underway").hide();  
                },
                error:function(){      
                    alert("Error");
                }
            });      
           
            item.setAttribute("data-published", "unpublished");
        }else{
        
            $.ajax({
                type: 'GET',
                url: '<?php echo site_url("admin/dashboard/ajaxTreeHandler") ?>?stateId='+id+"&state=3",
                beforeSend:function(){
                
                },
                success:function(data){
                    if(data != "OK")
                        alert("Error");
                    $("#process_underway").hide();  
                },
                error:function(){           
                    alert("Error");
                }
            });      
        
            item.setAttribute("data-published", "published");        
        }
    }


       
    /*
     * Save tree changes
     **/
    function saveMyTree()
    {
        $("#process_underway").show();
        saveString = treeObj.getNodeOrders();
    
        $("#saveString").val(saveString);
        
        var ajaxIndex = ajaxObjects.length;
        ajaxObjects[ajaxIndex] = new sack();
        var url = '<?php echo site_url("admin/dashboard/ajaxTreeHandler") ?>?saveString=' + saveString;
        ajaxObjects[ajaxIndex].requestFile = url;	// Specifying which file to get
        ajaxObjects[ajaxIndex].onCompletion = function() {
            if(ajaxObjects[ajaxIndex].response == "OK"){
                $("#process_underway").hide();            
            }else{
                alert("Error occured");
            }                            
            $("#process_underway").hide();            
            
        } ;	
        ajaxObjects[ajaxIndex].runAJAX();		// Execute AJAX function			
		
    }

    /*
     * look for unsaved changes every 1.5 second
     **/
    window.setInterval(function(){
        if(changeMade == true){
            console.log("Saving..");
            saveMyTree();
            changeMade = false;
        }
        
    }, 1500);

    


    /*
     * Determine whether changes are actually made
     **/
    function checkEdit(){
    
        saveString = treeObj.getNodeOrders();
        
        var newSize = (saveString.split(",").length);
        
        /*Keep Prev value*/
        prevTreeString = $("#saveString").val();

        /*Populate new value*/
        $("#saveString").val(saveString);
        
        console.log("Activity : "+saveString);
        /*If prev = new*/
        if(prevTreeString == saveString){            
            console.log("no change made");
        }else if(newSize != initialSize){
            console.log("false alarm");
        }else{
            console.log("change made");
            changeMade= true;
        }
    }

  
  
    /*
     * Initialize tree
     **/	
            
    treeObj = new JSDragDropTree();
    
    treeObj.setTreeId('menu_tree');
    treeObj.setImageFolder('<?php echo base_url() ?>resources/admin/js/plugins/dgtree/images/');
    treeObj.setMaximumDepth(7);
    treeObj.setMessageMaximumDepthReached('Maximum depth reached'); // If you want to show a message when maximum depth is reached, i.e. on drop.
    
    treeObj.setFileNameRename("<?php echo site_url("admin/dashboard/ajaxTreeHandler") ?>");
    treeObj.setFileNameDelete("<?php echo site_url("admin/dashboard/ajaxTreeHandler") ?>");
    
    treeObj.initTree();
    treeObj.expandAll();
 
    prevTreeString = treeObj.getNodeOrders();
    initialSize = (prevTreeString.split(",").length);
   
    $("#process_underway").hide();
    
    /*
     * Possible edit scenarios
     **/    
    $("#menu_tree").bind("DOMSubtreeModified",checkEdit);  
    $("#menu_tree").mouseup(checkEdit);

</script>