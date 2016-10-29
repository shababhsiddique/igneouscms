<input type="hidden" name="datatableSource" id="datatableSource" value="<?php echo current_url() . "/true"; ?>"/>
<input type="hidden" name="datatableConfig" id="datatableConfig"/>
<input type="hidden" name="datatableSearch" id="datatableSearch" value="<?php echo $this->input->get("sSearch"); ?>"/>

<div class="row">
    <div class="col-lg-12">
        <h4 class="page-header"><?php echo $this->formfactory->title($from); ?></h4>
    </div>
</div> 



<!--<div class="panel panel-default">
    <div class="panel-heading">-->
<div class="row">
    <div class="btn-toolbar col-md-12">
        <?php if (isset($actions['edit'])) {
            ?><a class="btn btn-primary" href="<?php
        $dash = "admin/dashboard";
        if (isset($dashboard)) {
            $dash = $dashboard;
        }
        echo site_url($dash . '/' . $actions['edit'])
            ?>"><span class="glyphicon glyphicon-plus"></span> <?php echo $this->lang->line("New") ?></a><?php
       } elseif (isset($customlinks)) {
           echo $customlinks;
       }
       $tableEntityTitle = str_replace("tbl_", "", $from);
       $tableEntityTitle = str_replace("lookup_", "", $tableEntityTitle);
       $tableEntityTitle = str_replace("_", " ", $tableEntityTitle);
       $tableEntityTitle = ucwords($tableEntityTitle);
        ?>
    </div>
</div>
<!--    </div>-->
<!-- /.panel-heading -->
<!--    <div class="panel-body">-->
<br/>    

<table class="table table-striped table-bordered table-hover datatableObject" id="datatableObject">
    <thead>
        <tr>
            <?php
            /**
             * Generate column headers
             */$indx = 1;
            foreach ($select as $aColumn => $prop) {

                if (strstr($prop, "image") || strstr($prop, "text")) {
                    
                } else {
                    $st = explode(".", $aColumn);

                    $words = explode("_", $st[1]);

                    if (count($words) >= 2 && $words[1] == "id")
                        $title = $words[0];
                    else
                        $title = implode(" ", $words);

                    $title = ucwords($title);

                    if ($indx == 1) {
                        echo "<th style='width: 30px'>#</th>";
                    } else {
                        if (isset($words[1])) {
                            if (($words[1] == "body") ||
                                    ($words[1] == "structure") ||
                                    ($words[1] == "html"))
                                echo "<th>$title</th>";
                            else
                                echo "<th style='max-width: 37px;'>$title</th>";
                        }
                        else
                            echo "<th style='max-width: 37px;'>$title</th>";
                    }
                    $indx++;
                }
            }
            ?>
            <th style="min-width: <?php echo (sizeof($actions) * 25) ?>px; width: <?php echo sizeof($actions) * 26 ?>px ; max-width: <?php echo (sizeof($actions) * 27) ?>px;"></th><!-- reserved for actions-->
        </tr>
    </thead>
    <!-- body template-->
    <tbody>
        <tr class="odd">
            <?php echo str_repeat("<td></td>", count($select)); ?>
            <td class="center"></td>
        </tr>
        <tr class="even">
            <?php echo str_repeat("<td></td>", count($select)); ?>
            <td class="center"></td>
        </tr>
    </tbody>
</table>
<!--    </div>-->
<!--</div>-->