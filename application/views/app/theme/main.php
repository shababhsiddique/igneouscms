<!DOCTYPE html>
<html>
    <head>
        <title></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

        <link rel="stylesheet" type="text/css" href="http://netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css"/>
        <script type="text/javascript" src="http://code.jquery.com/jquery-1.11.0.min.js" ></script>
        <script type="text/javascript" src="http://netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js" ></script>

        <?php $this->load->view("admin/components/wysiwyg/nicinit"); ?>
    </head>    
    <body>
        <?php $this->load->view("admin/components/wysiwyg/nicpanel"); ?>
        <div class="container">
            <div class="jumbotron">
                <h1>Hello, world!</h1>
                <p>...</p>
                <p><a class="btn btn-primary btn-lg" role="button">Learn more</a></p>
            </div>
            <nav class="navbar navbar-default" role="navigation">
                <div class="container-fluid">
                    <!-- Brand and toggle get grouped for better mobile display -->
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="#">Brand</a>
                    </div>

                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <ul class="nav navbar-nav">
                            <li class="active"><a href="#">Link</a></li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <li><a href="#">Action</a></li>
                                    <li><a href="#">Another action</a></li>
                                    <li class="divider"></li>
                                    <li><a href="#">One more separated link</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div><!-- /.navbar-collapse -->
                </div><!-- /.container-fluid -->
            </nav>
            <div class="row">
                <div class="col-md-3">
                    <img src="http://placehold.it/280x280" class="img-responsive" alt="Responsive image">
                </div>
                <div class="col-md-9">
                    <?php 
                    if(isset($content)){
                        echo $content;
                    }
                    echo $this->content->block("home_block_main");
                    ?>
                </div>
            </div>
            <div id="table.col" class="row"></div>
        </div>

    </body>
</html>