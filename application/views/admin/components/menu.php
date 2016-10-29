<ul class="nav" id="side-menu">
    <li class="sidebar-search">
        <div class="input-group custom-search-form">
            <input type="text" class="form-control" placeholder="Search..." onkeyup="menuFilter()">
            <span class="input-group-btn">
                <button class="btn btn-default" type="button" onclick="menuFilter()">
                    <i class="fa fa-search"></i>
                </button>
            </span>
        </div>
        <!-- /input-group -->
    </li>
    <li class="">
        <a href="<?php echo site_url("admin") ?>"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
    </li>
    <li>
        <a href="#"><i class="fa fa-files-o fa-fw"></i> Pages<span class="fa arrow"></span></a>
        <ul class="nav nav-second-level <?php checkCurrentMenu("page"); ?>">
            <li>
                <a href="<?php echo site_url("admin/dashboard/page_view") ?>">All Pages</a>
            </li>
            <li>
                <a href="<?php echo site_url("admin/dashboard/page_auth") ?>">Add new Page</a>
            </li>
        </ul>
        <!-- /.nav-second-level -->
    </li>
    <li>
        <a href="#"><i class="fa fa-pencil fa-fw"></i> Blog<span class="fa arrow"></span></a>
        <ul class="nav nav-second-level <?php checkCurrentMenu("article"); ?>">
            <li>
                <a href="<?php echo site_url("admin/dashboard/article_view") ?>">All Articles</a>
            </li>
            <li>
                <a href="<?php echo site_url("admin/dashboard/article_auth") ?>">Add new Article</a>
            </li>
        </ul>
        <!-- /.nav-second-level -->
    </li>
    <li>
        <a href="#"><i class="glyphicon glyphicon-th-large"></i> Blocks<span class="fa arrow"></span></a>
        <ul class="nav nav-second-level <?php checkCurrentMenu("block"); ?>">
            <li>
                <a href="<?php echo site_url("admin/dashboard/block_view") ?>">All Blocks</a>
            </li>
            <li>
                <a href="<?php echo site_url("admin/dashboard/block_auth") ?>">Create HTML Block</a>
            </li>
        </ul>
        <!-- /.nav-second-level -->
    </li>
    <li>
        <a href="#"><i class="fa fa-sitemap fa-fw"></i> Menu<span class="fa arrow"></span></a>
        <ul class="nav nav-second-level <?php checkCurrentMenu("menu"); ?>">
            <li>
                <a href="<?php echo site_url("admin/dashboard/menu") ?>">Manage</a>
            </li>
            <li>
                <a href="<?php echo site_url("admin/dashboard/menu_view") ?>">View As List</a>
            </li>
            <li>
                <a href="<?php echo site_url("admin/dashboard/menu_auth") ?>">Create Menu Entry</a>
            </li>
        </ul>
        <!-- /.nav-second-level -->
    </li>
    <li>
        <a href="#"><i class="fa fa-picture-o fa-fw"></i> Slider<span class="fa arrow"></span></a>
        <ul class="nav nav-second-level <?php checkCurrentMenu("slider"); ?>">
            <li>
                <a href="<?php echo site_url("admin/dashboard/slider") ?>">Manage Slider Images</a>
            </li>
        </ul>
        <!-- /.nav-second-level -->
    </li>
    <li>
        <a href="#"><i class="fa fa-rss fa-fw"></i> Subscribers<span class="fa arrow"></span></a>
        <ul class="nav nav-second-level <?php checkCurrentMenu("email"); ?>">
            <li>
                <a href="<?php echo site_url("admin/dashboard/email_view") ?>">All Emails</a>
            </li>
            <li>
                <a href="<?php echo site_url("admin/dashboard/email_auth") ?>">Enter new Email</a>
            </li>
        </ul>
        <!-- /.nav-second-level -->
    </li>
    <li>
        <a href="#"><i class="fa fa-user fa-fw"></i> Admins<span class="fa arrow"></span></a>
        <ul class="nav nav-second-level <?php checkCurrentMenu("admin_"); ?>">
            <li>
                <a href="<?php echo site_url("admin/dashboard/admin_view") ?>">List All Admins</a>
            </li>
            <li>
                <a href="<?php echo site_url("admin/dashboard/admin_auth") ?>">Create new Account</a>
            </li>
        </ul>
        <!-- /.nav-second-level -->
    </li>
    <li>
        <a href="<?php echo site_url("admin/dashboard/backup") ?>"><i class="glyphicon glyphicon-floppy-save"></i> Backup</a>
    </li>
    <li>
        <a href="#"><i class="fa fa-cogs fa-fw"></i> Settings<span class="fa arrow"></span></a>
        <ul class="nav nav-second-level <?php checkCurrentMenu("config"); ?>">
            <li>
                <a href="<?php echo site_url("admin/dashboard/config_view") ?>">All Site Settings</a>
            </li>
            <li>
                <a href="<?php echo site_url("admin/dashboard/config_auth") ?>">Add new setting</a>
            </li>
        </ul>
        <!-- /.nav-second-level -->
    </li>
    <li>
        <a href="<?php echo site_url("admin/dashboard/logout") ?>"><i class="fa fa-power-off fa-fw"></i> Logout</a>
    </li>
</ul>