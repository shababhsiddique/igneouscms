<?php
$controller = $this->uri->segment(2);
$function = $this->uri->segment(3);
if ($function != "")
    $root_function = explode("_", $function);
?>
<ol id="admin-bread-crumb" class="breadcrumb">
    <li><a href="<?php echo site_url("admin") ?>">Admin</a></li>
    <?php if ($function != "") {
        ?>
        <li><a href="<?php echo site_url("admin/$controller") ?>"><?php echo ucfirst($controller) ?></a></li>
        <?php if (sizeof($root_function) == 2) { ?>
            <li><a href="<?php echo site_url("admin/$controller/$root_function[0]_view") ?>"><?php echo ucfirst($root_function[0]) ?></a></li>
            <li class="active"><?php echo ucfirst($root_function[1]) ?></li>
        <?php } else { ?>
            <li class="active"><?php echo ucfirst($root_function[0]) ?></li>
            <?php
        }
    } else {
        ?>
        <li class="active">Dashboard</li>
    <?php } ?>
</ol>