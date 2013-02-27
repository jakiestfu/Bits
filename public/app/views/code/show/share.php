<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    
    <title><?PHP echo $settings->bit_title.' | '; ?>Bits</title>
    
    <meta name="app-route" 	content="<?PHP echo get_controller().'/'.get_action(); ?>">
    <meta name="app-url" 	content="<?PHP echo home_url(); ?>">
    
    <?PHP echo asset( 'Bits.css' ); ?>
    
</head>
<body class="controller-<?PHP echo get_controller(); ?> action-<?PHP echo get_action(); ?>">
	<div class="data-wrap">
		<div id="top-bar">
			<nav>
				<ul>
					<li class="brand">
						<a href="<?PHP echo home_url(); ?>"><span class="bit-embed"></span> Bits</a>
					</li>
					
					<li class="share-item share-tw">
						<a href="https://twitter.com/share" class="twitter-share-button" data-url="<?PHP echo home_url('code/share/'.$bit->slug.'/'.$bit->version); ?>" data-text="<?PHP echo $settings->bit_title; ?>">Tweet</a>
						<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
					</li>
					
					<li class="share-item share-fb">
						<script>(function(d){
                          var js, id = 'facebook-jssdk'; if (d.getElementById(id)) {return;}
                          js = d.createElement('script'); js.id = id; js.async = true;
                          js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
                          d.getElementsByTagName('head')[0].appendChild(js);
                        }(document));</script>
                        <div class="fb-like" data-href="<?PHP echo home_url('code/share/'.$bit->slug.'/'.$bit->version); ?>" data-send="false" data-layout="button_count" data-width="250" data-show-faces="false"></div>
					</li>
				</ul>
				
				<header>
					<div><?PHP echo _html($settings->bit_title); ?></p><?PHP if(isset($bit->version)){ echo '<span class="version"> &middot; Version '.$bit->version.'</span>'; }?> </div>
				</header>
			</nav>
		</div>
		<div id="share-wrap">
			<iframe src="<?PHP echo home_url('code/show/'.$bit->slug.'/'.$bit->version); ?>">
		</div>
	</div>
	<?PHP echo asset('jquery-1.9.0.min.js'); ?>
	<?PHP echo asset('Bits.js'); ?>
</body>