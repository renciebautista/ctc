<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Sign In | Control Panel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="<?php echo base_url('css/admin/bootstrap.css') ?>" rel="stylesheet">
    <style type="text/css">
      body {
        padding-top: 120px;
        padding-bottom: 40px;
        background-color: #1B1B1B;
      }

      .form-signin {
        max-width: 300px;
        padding: 19px 29px 29px;
        margin: 0 auto 20px;
        background-color: #fff;
        border: 1px solid #e5e5e5;
        -webkit-border-radius: 5px;
           -moz-border-radius: 5px;
                border-radius: 5px;
        -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
           -moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
                box-shadow: 0 1px 2px rgba(0,0,0,.05);
      }
      .form-signin .form-signin-heading,
      .form-signin .checkbox {
        margin-bottom: 10px;
      }
      .form-signin input[type="text"],
      .form-signin input[type="password"] {
        font-size: 16px;
        height: auto;
        margin-bottom: 15px;
        padding: 7px 9px;
      }

    </style>

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="../assets/js/html5shiv.js"></script>
    <![endif]-->

  </head>

  <body>

    <div class="container">

	<?php echo form_open('admin/auth/login',array('class' => 'form-signin'));?>
		<?php if(isset($message)):?>
		<p class="text-error" style="text-align:center;"><b><?php echo $message;?></b></p>
		<?php endif; ?>											
        <input type="text" class="input-block-level" name="user" placeholder="Email address">
        <input type="password" class="input-block-level" name="pass" placeholder="Password">
        <button class="btn btn-small btn-primary" type="submit">Sign in</button>
    <?php form_close(); ?>

    </div> <!-- /container -->


  </body>
</html>
