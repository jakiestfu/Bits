<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />

    <title>Bits</title>

    <meta name="app-route" 	content="<?PHP echo get_controller().'/'.get_action(); ?>">
    <meta name="app-url" 	content="<?PHP echo home_url(); ?>">

    <?PHP echo asset( 'Bits.css' ); ?>

    <!--[if IE]>
		<script src="http://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.6.1/html5shiv.js"></script>
	<![endif]-->

</head>
<body class="controller-<?PHP echo get_controller(); ?> action-<?PHP echo get_action(); ?>">

<div id="auth" class="code-font">
	
	<header>
		<a href="http://coolbitsbro.com/"><span class="bit-embed"></span> Bits</a>
	</header>
	<?PHP if(isset($_GET['invalid'])){ ?><p>Invalid username or password</p><?PHP } ?>
	<?PHP if(isset($_GET['loggedout'])){ ?><p>Catch ya later</p><?PHP } ?>
	<form action="<?PHP echo home_url('auth/new'); ?>" method="POST">
		<div>
			<label>
				<input autofocus="true" type="text" placeholder="Username" name="username" class="text">
			</label>
			<label>
				<input type="password" placeholder="Password" name="password" class="text">
			</label>
		</div>
		<div>
			<input type="submit" class="pull-right btn btn-positive login-btn code-font" value="login">
		</div>
	</form>
</div>

<?PHP get_footer(); ?>
