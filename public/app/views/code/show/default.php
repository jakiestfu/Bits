<?PHP

/*
 * Output page, yo
 */
?>
<?= $settings->html_docType . "\n"; ?>
<html>
  <head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <title><?= $settings->bit_title; ?></title>
    <meta name="description" content="<?= _html($settings->bit_description, true); ?>">
    
<?PHP 

/*
 * JS Lib Output
 */

if($settings->javascript_lib && $settings->javascript_lib!='none'){
	foreach($libs['js'][ $settings->javascript_lib ] as $lib ){ ?>
    	<script type="text/javascript" src="<?= $lib; ?>"></script> <?PHP
	} 
}

/*
 * JS External Output
 */
if($settings->javascript_external){ ?>
    
    <script type="text/javascript" src="<?= $settings->javascript_external; ?>"></script><?PHP 
}

/*
 * CSS Lib Output
 */
if($settings->css_framework && $settings->css_framework!='none'){ 
	foreach($libs['css'][ $settings->css_framework ] as $lib ){ ?>
    	
    	<link rel="stylesheet" type="text/css" href="<?= $lib; ?>" data-noprefix> <?PHP
	} 
}

/*
 * CSS External Output
 */
if($settings->css_external){ ?>
    
    <link rel="stylesheet" type="text/css" href="<?= $settings->css_external; ?>" data-noprefix><?PHP 
}

/*
 * CSS Output
 */
if($bit->css){ ?>
    
    <style type="text/css">
      <?= base64_decode( $bit->css ) . "\n"; ?>
    </style><?PHP 
}

/*
 * Prefix Free Output
 */
if($settings->css_prefixFree=='yes'){ ?>
    
    <script type="text/javascript" src="<?= end($libs['js'][ 'PrefixFree' ]); ?>"></script><?PHP 
}

/*
 * JS Output
 */
if( $bit->javascript && $settings->javascript_location != 'body' ) { ?>
    
    <script type='text/javascript'>
    //<![CDATA[
      <?PHP 
          
          switch($settings->javascript_location){
              case 'onLoad':
                echo 'window.onload = function(){' . "\n";
                break;
              case 'domReady':
                echo 'var BitsDomReady = function() {' . "\n";
                break;
          }
          
          echo base64_decode( $bit->javascript ) . "\n";
          
          echo ($settings->javascript_location != 'head') ? '      }' ."\n" : '';
          
          if($settings->javascript_location == 'domReady'){ ?>
          /*!
           * domready (c) Dustin Diaz 2012 - License MIT
           */
          !function(a,b){typeof module!="undefined"?module.exports=b():typeof define=="function"&&typeof define.amd=="object"?define(b):this[a]=b()}("domready",function(a){function m(a){l=1;while(a=b.shift())a()}var b=[],c,d=!1,e=document,f=e.documentElement,g=f.doScroll,h="DOMContentLoaded",i="addEventListener",j="onreadystatechange",k="readyState",l=/^loade|c/.test(e[k]);return e[i]&&e[i](h,c=function(){e.removeEventListener(h,c,d),m()},d),g&&e.attachEvent(j,c=function(){/^c/.test(e[k])&&(e.detachEvent(j,c),m())}),a=g?function(c){self!=top?l?c():b.push(c):function(){try{f.doScroll("left")}catch(b){return setTimeout(function(){a(c)},50)}c()}()}:function(a){l?a():b.push(a)}})
          
          domready(BitsDomReady);
          
          <?PHP }
          
      ?>
    //]]> 
    </script>
    <?PHP 
} 

// End JS Output

?>
  </head>
  <?= stripslashes( $settings->html_bodyTag ) . "\n"; ?>
    <?= base64_decode( $bit->html ) . "\n"; ?>
    
    <?PHP if( $bit->javascript && $settings->javascript_location == 'body' ) { ?>
    
    <script type='text/javascript'>
    //<![CDATA[
      <?PHP echo base64_decode( $bit->javascript ) . "\n"; ?>
    //]]> 
    </script>
    <?PHP } ?>
  </body>
</html>