<!DOCTYPE html>
<html lang="en" moznomarginboxes mozdisallowselectionprint>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<meta charset="utf-8">
		<title>Killhope Android App Content Management</title>
		<meta name="generator" content="Bootply" />
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
		<link href="assets/css/bootstrap.min.css" rel="stylesheet">

		<!--[if lt IE 9]>
			<script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
		<link href="assets/css/custom.css" rel="stylesheet">
    <style>
    @page{margin:0px auto;}
    @media print{ 
      html, body{ height: 95% }
      body{ margin: 30px }
      #wrap {
        min-height: 100%;
        height: auto;
        margin: 0 auto -40px;
        padding: 0 0 40px;
      }
      footer{
        height: 40px;
        page-break-after: auto;
      }
      #poster-title{
        text-align: right;
      }
    }
    </style>
	</head>
	<body>

<!-- Wrap all page content here -->
<div id="wrap">

  <div class="container" > 
	  <div class="col-xs-4">
      <img src="assets/img/logo.png" id="poster-logo" class="img-responsive2"/>
    </div>
    <div class="col-xs-8">
      <H2 id="poster-title" class="navbar-right"> <b>The Android App </b> </H2>
    </div>
  </div>

  <div class="container poster-body" > 
    <H2 class="museum-trails" >Museum Trail QR Code</H2>
	  <div id="qrcode"></div>
    <p class="lead">
	    To download the Killhope Lead Mining Museum Android App, search for "Killhope" in the Google play store. Free wireless available in reception.
    </p>
  </div><!-- /.container -->

</div><!-- /.wrap -->



<footer class="footer">
  <div class="container">
<div class="text-muted qr-text pull-right"> <?php echo $_GET['qrcode']; ?> </div>
    
  </div>
</footer>

</body>
<div id="imageHtml" style='display:none'></div>
</html>

<script src="assets/js/jquery.js" type="text/javascript"></script>
<script src="assets/js/jquery-qrcode.js" type="text/javascript"></script>
<script type="text/javascript">
console.log( "hello" );
$("#qrcode").qrcode({
  text:"<?php echo $_GET['qrcode']; ?>",
  size: 400,
  render: 'image'
});

</script>

