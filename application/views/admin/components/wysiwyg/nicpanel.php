<?php
$admin_logged_in = $this->session->userdata('admin_logged_in');
if ($admin_logged_in == true) {
    ?><div id="myNicPanel"></div>
    <span id="process_underway"></span>
<?php } ?>