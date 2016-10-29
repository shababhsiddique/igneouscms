<?php
$entity["action_val"] = $this->uri->segment(4);
?>

<div class="row">
    <div class="col-lg-12">
        <h4 class="page-header"><?php echo $this->formfactory->title($entity["from"]); ?></h4>
    </div>
</div>

<image class="img-polaroid"/>
<!-- /.row -->
<div class="row">
    <div class="col-lg-8">
        <form class="form-horizontal" method="POST" action="" enctype="multipart/form-data">
            <fieldset>              
                <?php
                echo $this->formfactory->generate($entity, $oldEntityData, $item_id);
                ?>
            </fieldset>
        </form>

    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
