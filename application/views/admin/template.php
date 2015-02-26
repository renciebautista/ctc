<?php $class = strtolower($this->uri->segment(2));?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Control Panel | <?php echo $title; ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <!-- Le styles -->
        <link href="<?php echo base_url('css/admin/bootstrap.css') ?>" rel="stylesheet">
        <link href="<?php echo base_url('css/admin/admin.css') ?>" rel="stylesheet">
        <link href="<?php echo base_url('css/admin/jquery-ui-1.8.22.custom.css') ?>" rel="stylesheet">
        <link href="<?php echo base_url('css/admin/bootstrap-wysihtml5-0.0.2.css') ?>" rel="stylesheet">
        <style type="text/css">
        body {
        padding-top: 60px;
        padding-bottom: 40px;
        }
        </style>
        <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
        <script src="../assets/js/html5shiv.js"></script>
        <![endif]-->
    </head>
    <body>
        <div class="navbar navbar-inverse navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container">
                    <div class="nav-collapse collapse">
                        <ul class="nav">
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">File Maintenance <b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                <?php if(ROLE_ID == 2): ?>
                                    <li><a href="<?php echo base_url('admin/product_category'); ?>">Product Category</a></li>
                                    <li><a href="<?php echo base_url('admin/product'); ?>">Products</a></li>
                                    <li><a href="<?php echo base_url('admin/industry_category'); ?>">Industry Category</a></li>
                                    <li><a href="<?php echo base_url('admin/industry'); ?>">Industry</a></li>
                                    <li><a href="<?php echo base_url('admin/whatwedo'); ?>">What We Do</a></li>
                                <?php endif; ?>
                                <?php if(ROLE_ID == 3): ?>
                                    <li><a href="<?php echo base_url('admin/careers'); ?>">Careers</a></li>
                                    <li><a href="<?php echo base_url('admin/settings'); ?>">Career Header</a></li>
                                    <li><a href="<?php echo base_url('admin/holidays'); ?>">Holidays</a></li>
                                <?php endif; ?>
                                <?php if(ROLE_ID == 1): ?>
                                    <li><a href="<?php echo base_url('admin/group'); ?>">Contact Group</a></li>
                                    <li><a href="<?php echo base_url('admin/subgroup'); ?>">Contact Sub Group</a></li>
                                <?php endif; ?>
                                </ul>
                            </li>
                         <?php if(ROLE_ID == 1): ?>
                            <li><a href="<?php echo base_url('admin/users'); ?>">Users</a></li>
                         <?php endif; ?>
                            <!-- <li><a href="#contact">Settings</a></li> -->
                        <?php if(ROLE_ID == 2): ?>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Filters <b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <li><a href="<?php echo base_url('admin/pending'); ?>">Pending Filters</a></li>
                                    <li><a href="<?php echo base_url('admin/blacklist'); ?>">Blacklist Filters</a></li>
                                </ul>
                            </li>
                        <?php endif; ?>
                        </ul>
                    </div><!--/.nav-collapse -->
                                            <p class="navbar-text pull-right">
                        Logged in as <?php echo DISPLAYNAME;?> :
                        <a class="navbar-link" href="<?php echo base_url('admin/auth/logout');?>">Logout</a>
                        </p>
                </div>
            </div>
        </div>
        <div class="container">
                
                <?php
                    if(stristr($view, '/') === FALSE)
                    {
                        //'/' not found in string, load usual view
                        $this->load->view("admin/$class/$view");
                    }
                    else
                    {
                        //'/' FOUND in string, load view w/o class name (used for categories)
                        $this->load->view("admin/$view");
                    }
                ?>

                <hr>
                <footer>
                    <p>&copy; Company 2013</p>
                </footer>
        </div> <!-- /container -->
        <!-- Le javascript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <script src="<?php echo base_url('/jquery/admin/jquery.js'); ?>"></script>
        <script src="<?php echo base_url('/jquery/admin/bootstrap.js'); ?>"></script>
        <script src="<?php echo base_url('/jquery/admin/jquery-ui-1.10.3.custom.min.js'); ?>"></script>
        <script src="<?php echo base_url('/jquery/admin/jquery.maskedinput.min.js'); ?>"></script>
        <script src="<?php echo base_url('/jquery/admin/wysihtml5-0.3.0.js'); ?>"></script>
        <script src="<?php echo base_url('/jquery/admin/bootstrap-wysihtml5-0.0.2.js'); ?>"></script>
        <script src="<?php echo base_url('/jquery/jquery.numericonly.js'); ?>"></script>
        <script src="<?php echo base_url('/jquery/admin/admin.js'); ?>"></script>
    </body>
</html>