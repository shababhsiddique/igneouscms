
<?php
$message = $this->session->userdata('message');
if ((isset($message)
        && $message['title'] != "")) {
    ?>
    <div id="admin-alert-box" class="alert alert-<?php echo $message['type'] ?> alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<strong><?php echo $message['title'] ?></strong>&nbsp;&nbsp;<?php echo $message['body'] ?>.
    </div>
    <?php
    $this->session->unset_userdata('message');
}
?>  
