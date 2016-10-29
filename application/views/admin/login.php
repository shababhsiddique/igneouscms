<!DOCTYPE html>
<html>
    <head>
        <title></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>

        
        <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>resources/admin/css/bootstrap.min.css"/>
        <script type="text/javascript" src="http://code.jquery.com/jquery-1.11.0.min.js" ></script>
        <script type="text/javascript" src="<?php echo base_url()?>resources/admin/js/bootstrap.min.js" ></script>

    </head>  
    <body style="background-image: url('http://subtlepatterns.com/patterns/knitted-netting.png');" >
        <div class="container" style="margin-top:30px">
            <div class="col-md-4 col-md-offset-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <?php
                        $message = $this->session->userdata('message');
                        if ((isset($message)
                                && $message['title'] != "")) {
                            ?>  
                            <div class="alert alert-warning alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <strong><?php echo $message['title'] ?>!</strong> <?php echo $message['body'] ?>.
                            </div>
                            <?php
                            $this->session->unset_userdata('message');
                        }
                        ?> 
                        <h3 class="panel-title"><strong><i class="glyphicon glyphicon-user"></i> Sign in </strong></h3>
                    </div>
                    <div class="panel-body">
                        <form role="form"
                              action="<?php echo site_url('admin/login/authenticate') ?>"  
                              method="post">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Username or Email</label>
                                <input type="text" name="username" placeholder="Username" class="form-control" style="border-radius:0px" id="exampleInputEmail1">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Password</label>
                                <input type="password" name="password" class="form-control" style="border-radius:0px" id="exampleInputPassword1" placeholder="*******">
                            </div>
                            <button type="submit" class="btn btn-sm btn-primary">Sign in</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>        

        <script type="text/javascript" src="<?php echo base_url() ?>js/admin/vendor/jquery-1.9.1.min.js"></script>
        <script src="<?php echo base_url() ?>js/admin/vendor/bootstrap.min.js"></script>
        <script src="<?php echo base_url() ?>js/admin/main.js"></script>
    </body>
</html>

