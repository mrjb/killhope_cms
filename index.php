<?php

//Set things up for development/deployment.
if( file_exists("setup.php") ){
  include 'setup.php';
}

//Check that the CIS user is an allowed user.
$users = array('gkvc57', 'dcs0www', 'dcs0sad', 'dch1hcg');
if( !in_array( $_SERVER['REMOTE_USER'], $users ) ){
?>
<html lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<meta charset="utf-8">
		<title>Killhope Android App Content Management</title>
	</head>
	<body>
Authentication Error: Your CIS account is not authorised to view this page.
	</body>
</html>

<?php
}else{
?>


<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<meta charset="utf-8">
		<title>Killhope Android App Content Management</title>
		<meta name="generator" content="Bootply" />
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
    <link href="assets/sce/minified/themes/default.min.css" rel="stylesheet">
		<link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/featherlight.min.css" rel="stylesheet">

		<!--[if lt IE 9]>
			<script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
		<link href="assets/css/custom.css" rel="stylesheet">
	</head>
	<body>
<div class="navbar navbar-default navbar-static-top">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <img src="assets/img/logo.png" id="nav-logo" class="img-responsive2"/>

    </div>
    <!--<div class="collapse navbar-collapse">
      <ul class="nav navbar-nav">
        <li class="active"><a href="#">Home</a></li>
        <li><a href="#contact">Contact</a></li>
      </ul>
    </div>/.nav-collapse -->
		<H2 id="navbar-title" class="navbar-right"> <b>Android App </b>| Content Management </H2>
  </div>
</div>
<!-- Wrap all page content here -->
<div id="wrap">
<div class="container" id="change-type"> 
	You are: <?php echo $_SERVER['REMOTE_USER'] ?> 
  <div class="text-center">
    <h1>What do you want to change?</h1>
        <p class="lead">Select below the type of content change you wish to make.</p>
        <p class="lead"> <button class="btn btn-primary btn-lg" id="minDat"> Mineral Data </button></p>
        <p class="lead"> <button class="btn btn-primary btn-lg" id="glosDat"> Glossary Data </button> </p>
        <p class="lead"> <button class="btn btn-primary btn-lg" id="quizzesDat"> Quiz Data </button></p>
        <p class="lead"> <button class="btn btn-primary btn-lg" id="trailsDat"> Trail Data </button></p>
  </div>
</div><!-- /.container -->

<div class="container"> 
<div class="above-form clearfix">
   <div id="lhs-btns"> 
		<a id="back-to-home" class="btn btn-lg btn-primary"> <span id="back-icon" class="glyphicon glyphicon-chevron-left"></span></span> Back To Home </a>
   </div>
	<div id="rhs-buttons" class="btn-group">
		<a id="revert-original" class="btn btn-lg btn-danger"> Revert to Original </a>
		<a id="revert-last-save" class="btn btn-lg btn-warning"> Revert to Last Save </a>
		<a id="download-json" class="btn btn-lg btn-primary" target="_blank"> Download Data </a>
		<a id="save-changes" class="btn btn-lg btn-success"> <span id="floppy-icon" class="glyphicon glyphicon-floppy-disk"></span> Save Changes </a>
	</div>
</div>
<form id="form"> </form>


</div><!-- /.container -->
</div><!-- /.wrap -->

<footer class="footer">
  <div class="container">

    <p class="text-muted">
	    Content Management System designed by Jonathan Berry.
    </p>
  </div>
</footer>
</body>
<div id="imageHtml" style='display:none'></div>
</html>


	  <!-- script references -->
    <script src="assets/js/jquery.js" type="text/javascript"></script>
		<script src="assets/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="assets/sce/development/jquery.sceditor.js" type="text/javascript"></script>
    <script src="assets/js/jsoneditor.js" type="text/javascript"></script>
    <!-- Stores the schema for each type of data -->    
		<script src="assets/js/schema.js" type="text/javascript"></script>  
    <script src="assets/js/featherlight.min.js" type="text/javascript"></script>

		<script type="text/javascript">

//------------------------------------------------------------------------------
//-------------------------THE JAVASCRIPT MACHINE ------------------------------
//------------------------------------------------------------------------------

$( document ).ready( function(){

JSONEditor.defaults.theme = 'bootstrap3';
JSONEditor.defaults.iconlib = 'bootstrap3';
JSONEditor.defaults.options.ajax = false;

JSONEditor.plugins.sceditor.toolbar = 
      'bold,italic,underline,strike,subscript,superscript|' +
			'left,center,right,justify|size,removeformat|' +
			'bulletlist,orderedlist,indent,outdent|' +
			'table|horizontalrule,image,email,link,unlink|' +
			'maximize,source';
JSONEditor.plugins.sceditor.resizeWidth = false;
JSONEditor.plugins.sceditor.width = "100%";
JSONEditor.plugins.sceditor.height = 100;
JSONEditor.plugins.sceditor.resizeMinHeight = 100;
JSONEditor.plugins.sceditor.resizeMaxHeight = -1;


var element = document.getElementById('form');

$.sceditor.command.set( "image", {
  exec: function(a) {
      var editor = this;
      var content = "<iframe style='height:80vh; width:80vw;' src='fileBrowser.html'></iframe>";
      $.featherlight(content, {closeOnClick:false});
      $('#imageHtml').bind('DOMSubtreeModified', function(e) {
        if (e.target.innerHTML.length > 0) {
          editor.insert( $('#imageHtml').text() );
          $.featherlight.current().close();
          $('#imageHtml').remove();
          $('body').append('<div id="imageHtml"></div>');
        }
      });
  },
  tooltip: "Insert an image"
});

function killEditor( editor ){
  if( editor.destroy ) editor.destroy();
  $('#revert-original').unbind('click');
  $('#revert-last-save').unbind('click');
  $('#download-json').unbind('click');
  $('#back-to-home').unbind('click');
  $('#save-changes').unbind('click');
}

function openNormalPage( formSchema, file ){
	
	var filePath = "../../data/"+file;
	$('#change-type').hide();
  $('.above-form ').show();

	var editor = {};

	// Get the saved JSON data and set the editor to equal it.
  $.ajaxSetup({ cache: false });
	$.getJSON( filePath, function(json) {
    editor = new JSONEditor(element, {no_additional_properties:true, schema:formSchema});
		editor.setValue(json);		
	});
	
	//Show the buttons.
 	$('.above-form ').show();

	//On a normal page the entire form should be saved to file. 
	$('#save-changes').click( function(){
		saveObject( filePath, editor.getValue() );
	});

	//Enable the download JSON button. 
	$('#download-json').attr('href',filePath);

	//Enable the revert to original button.
	$('#revert-last-save').click( function(){
		if( confirm("Are you sure?\nYou will lose changes made since the last save.") ){
			$.getJSON(filePath, function(json) {
				setJsonValue( formSchema, json, editor );
			});
		}
	});

	//Enable the revert to original button.
	$('#revert-original').click( function(){
		if( confirm("Are you sure?\nThis will set the form's data back to factory settings.\nIF YOU THEN CLICK \"SAVE\", ALL PREVIOUSLY SAVED DATA CHANGES WILL BE LOST.") ){
			$.getJSON("data/original/"+file, function(json) {
				setJsonValue( formSchema, json, editor );
			});
		}
	});

	//Back to home button
	$('#back-to-home').click( function() {
		if( confirm("Are you sure?\nAny unsaved changes will be lost.") ){
			location.reload(); 
		}
	});
	
}

function openMineralPage(data, id){

	var filePath = "../../data/MineralData.json";

	$('#change-type').hide();
  $('.above-form ').show();

	// Initialize the editor
	var editor = {};
	var completeData = data ? data : {};
	var mineralID = id ? id : "0";

  //If we've been given data, we don't need to fetch it with ajax.
  if( data ) initialiseEditor();
  else{
    // Get the saved JSON data and set the editor to equal it.
    $.ajaxSetup({ cache: false });
    $.getJSON( filePath, function(json) {
	    completeData = json;
      initialiseEditor();
    });
  }

  function initialiseEditor(){
    editor = new JSONEditor(element, {no_additional_properties:true, schema:mineral_schema});
    console.log( completeData[mineralID]);
    editor.setValue(completeData[mineralID]);
	  createDropdown();

    //Hacky hack hack to get the SCEditors created in a hidden DOM element to have the correct size.
    //There is a bug in SCEditor width calculations for editors nested inside a hidden DOM element.
    $('.list-group-item').click( function() { $(window).resize(); });
  }

  function setJsonValue( completeData, minID ){
    killEditor( editor );
    openMineralPage( completeData, minID );
  }
	
  function createDropdown(){
		$('#minSelector').remove();
    //Draw dropdown
		var dropDown = "<div class='dropdown' id='minSelector'>" +
                   "<button class='btn btn-default btn-lg dropdown-toggle' type='button' " +
                   "data-toggle='dropdown' class='minSelect'> Mineral <span class='caret'>" +
                   "</span></button><ul class='dropdown-menu'>";
		for( var key in completeData ){
			dropDown = dropDown + "<li><a href='#' class='minSelect'  minID='"+key+"'>"+completeData[key].name+"</a></li>";
		}
		dropDown = dropDown +"</ul></div>";
    console.log( dropDown );
		$('#lhs-btns').append(dropDown);	
	
		//Listen to the mineral selector.
		$( '.minSelect' ).on( 'click', function(){
			mineralID = $(this).attr('minID');
			setJsonValue( completeData, mineralID );
		}); 
  }

	//Show the buttons.
 	$('.above-form ').show();

	//On the mineral page we have to first insert the forms details into the complete data set.
	$('#save-changes').click( function(){
		completeData[mineralID] = editor.getValue();
		saveObject( filePath, completeData );
	});

	//Enable the download JSON button. 
	$('#download-json').attr('href',filePath);

	//Enable the revert to original button.
	$('#revert-last-save').click( function(){
		if( confirm("Are you sure?\nYou will lose changes made since the last save.") ){
			$.getJSON(filePath, function(json) {
				setJsonValue( json, mineralID);
			});
		}
	});

	//Enable the revert to original button.
	$('#revert-original').click( function(){
		if( confirm("Are you sure?\nThis will set the form's data back to factory settings.\nIF YOU THEN CLICK \"SAVE\", ALL PREVIOUSLY SAVED DATA CHANGES WILL BE LOST.") ){
			$.getJSON("assets/data/original/MineralData.json", function(json) {
				setJsonValue( json, mineralID );
			});
		}
	});

	//Back to home button
	$('#back-to-home').click( function() {
		if( confirm("Are you sure?\nAny unsaved changes will be lost.") ){
			location.reload(); 
		}
	});
	
}

 


function openQuizPage(data, id){

	var filePath = "../../data/QuizData.json";

	$('#change-type').hide();
  $('.above-form ').show();

	// Initialize the editor
	var editor = {};
	var completeData = data ? data : {};
	var quizID = id ? id : 0;

  //If we've been given data, we don't need to fetch it with ajax.
  if( data ) initialiseEditor();
  else{
    // Get the saved JSON data and set the editor to equal it.
    $.ajaxSetup({ cache: false });
    $.getJSON( filePath, function(json) {

	    //Save the complete data and set the form values to the initial quiz.
	    completeData = json;
      initialiseEditor();

    });
  }

  function initialiseEditor(){
    editor = new JSONEditor(element, {no_additional_properties:true, schema:quiz_schema});
    if( quizID >-1 ) editor.setValue(completeData.quizzes[quizID]);
	  createDropdown();

    //Hacky hack hack to get the SCEditors created in a hidden DOM element to have the correct size.
    //There is a bug in SCEditor width calculations for editors nested inside a hidden DOM element.
    $('.list-group-item').click( function() { $(window).resize(); });
  }

  function setJsonValue( completeData, trailID ){
    killEditor( editor );
    console.log(completeData );
    openQuizPage( completeData, trailID );
  }

	function createDropdown(){

		$('#itemSelector').remove();

    //Create the quiz selector
		var dropDown = "<div class='dropdown' id='itemSelector'><button class='btn btn-default btn-lg dropdown-toggle' type='button' data-toggle='dropdown' class='itemSelect'> Quiz <span class='caret'></span></button><ul class='dropdown-menu'>";
		for( var i = 0; i< completeData.quizzes.length; i++ ){
			dropDown = dropDown + "<li><a href='#' class='itemSelect'  quizid='"+i+"'>"+completeData.quizzes[i].name+"</a><a href='#' data-toggle='tooltip' title='Delete this quiz' class='itemDelete' quizid='"+i+"'><span class='glyphicon glyphicon-remove'></span> </a></li>";
		}
		dropDown = dropDown + "<li class='divider'></li>";
		dropDown = dropDown + "<li><a href='#' class='newItem itemSelect'  quizid='-1'>New Quiz</a> </li>";
		dropDown = dropDown +"</ul></div>";
		$('#lhs-btns').append(dropDown);	

		//Listen to the quiz selector.
		$( '.itemSelect' ).on( 'click', function(){
			quizID = $(this).attr('quizid');
		  setJsonValue(completeData, quizID);
		}); 

		//Listen to the quiz selector.
		$( '.itemDelete' ).on( 'click', function(){	
	
			if( completeData.quizzes.length == 1 ){
				alert( "You cannot delete all quizzes.  At least one quiz must remain available at all times." );
			}else{
				qID = $(this).attr('quizid');
				if( confirm( "Are you sure? The quiz will be lost forever.\nConsider setting the quiz property 'hidden' to true if you may wish to use the quiz again.\nIf you click 'yes', the quiz '" + completeData.quizzes[qID].name + "' will be deleted and you will be directed back to the home page."  )){

          completeData.quizzes.splice(qID,1);
          saveObject( filePath, completeData );
          if( quizID == qID ) setJsonValue(completeData, 0); 
					else createDropdown();

				}
			}
		});
	}
	
	
	//Show the buttons.
 	$('.above-form ').show();

	//On the quiz page we have to first insert the form's details into the complete data set.
	//If the quiz is a new quiz, we have to add the quiz to the data set.
	$('#save-changes').click( function(){
    console.log( completeData );
		if( quizID == -1 ){
			quizID = completeData.quizzes.length;
			completeData.quizzes[quizID] = editor.getValue();
			createDropdown();
		}else{
			completeData.quizzes[quizID] = editor.getValue();
		}
    console.log( completeData );
		saveObject( filePath, completeData );
		
	});

	//Enable the download JSON button. 
	$('#download-json').attr('href',filePath);

	//Enable the revert to original button.
	$('#revert-last-save').click( function(){
		if( confirm("Are you sure?\nYou will lose changes made since the last save.") ){
			if( quizID==-1 ){
				setJsonValue( completeData, quizID);
			}else{
				//If trying to revert to last save of a new quiz, just empty the form.
				$.getJSON(filePath, function(json) {
						completeData = json;
						setJsonValue( completeData, quizID );
				});
			}
		}
	});

	//Enable the revert to original button.
	$('#revert-original').click( function(){
		if( confirm("Are you sure?\nThis will set the form's data back to factory settings.\nIF YOU THEN CLICK \"SAVE\", ALL PREVIOUSLY SAVED DATA CHANGES WILL BE LOST.") ){
			//If the quiz is a new quiz, change the revert to orginal button to a "delete new quiz" button
			$.getJSON("assets/data/original/QuizData.json", function(json) {
				setJsonValue( json, 0 );
			});
		}
	});

	//Back to home button
	$('#back-to-home').click( function() {
		if( confirm("Are you sure?\nAny unsaved changes will be lost.") ){
			location.reload(); 
		}
	});
	
}

function openTrailPage( data, id ){

	var filePath = "../../data/TrailData.json";

	$('#change-type').hide();
  $('.above-form ').show();

	// Declare page-wide variables.
  //Only actually initialise the editor once json has been fetched - SCEditor throws a horrible bug.
	var editor = {}; 
	var completeData = data ? data : {};
	var trailID = id ? id : 0;

  //If we've been given data, we don't need to fetch it with ajax.
  if( data ) initialiseEditor();
  else{
    // Get the saved JSON data and set the editor to equal it.
    $.ajaxSetup({ cache: false });
    $.getJSON( filePath, function(json) {

	    //Save the complete data and set the form values to the initial quiz.
	    completeData = json;
      initialiseEditor();

    });
  }

  function initialiseEditor(){
    editor = new JSONEditor(element, {no_additional_properties:true, schema:trail_schema});
    if( trailID >-1 ) editor.setValue(completeData.trails[trailID]);
	  createDropdown();

    //Hacky hack hack to get the SCEditors created in a hidden DOM element to have the correct size.
    //There is a bug in SCEditor width calculations for editors nested inside a hidden DOM element.
    $('.list-group-item').click( function() { $(window).resize(); });

    //Hacky hack hack to make the auto-generate qr poster button stand out a bit.
    $("a[href*='qrPoster.php']").attr("style","margin-bottom: 10px; text-align: right; padding: 10px; text-decoration: none; color: white; background: grey none repeat scroll 0% 0%; display: inline-block; border-radius: 5px; float: right;");
  }


  function setJsonValue( completeData, trailID ){
    killEditor( editor );
    openTrailPage( completeData, trailID );
  }

	function createDropdown(){

		$('#itemSelector').remove();

    //Create the quiz selector
		var dropDown = "<div class='dropdown' id='itemSelector'><button class='btn btn-default btn-lg dropdown-toggle' type='button' data-toggle='dropdown' class='itemSelect'> Trail <span class='caret'></span></button><ul class='dropdown-menu'>";
    console.log( completeData.trails.length ); 
		for( var i = 0; i< completeData.trails.length; i++ ){
			dropDown = dropDown + "<li><a href='#' class='itemSelect'  trailid='"+i+"'>"+completeData.trails[i].name+"</a><a href='#' data-toggle='tooltip' title='Delete this quiz' class='itemDelete' trailid='"+i+"'><span class='glyphicon glyphicon-remove'></span> </a></li>";
		}

		dropDown = dropDown + "<li class='divider'></li>";
		dropDown = dropDown + "<li><a href='#' class='newItem itemSelect'  trailid='-1'>New Trail</a> </li>";
		dropDown = dropDown +"</ul></div>";
		$('#lhs-btns').append(dropDown);	

		//Listen to the quiz selector.
		$( '.itemSelect' ).on( 'click', function(){
			tID = $(this).attr('trailid');
			trailID = tID
      setJsonValue( completeData, tID );
		}); 

		//Listen to the quiz selector.
		$( '.itemDelete' ).on( 'click', function(){	
	
			if( completeData.trails.length == 1 ){
				alert( "You cannot delete all trails.  At least one trail must remain available at all times." );
			}else{
				tID = $(this).attr('trailid');
				if( confirm( "Are you sure? The trail will be lost forever.\nConsider setting the trail property 'published' to false if you may wish to use the trail again.\nIf you click 'yes', the trail '" + completeData.trails[tID].name + "' will be deleted and you will be directed back to the home page."  )){

          completeData.trails.splice(tID,1);
          saveObject( filePath, completeData );

          if( trailID == tID ) setJsonValue(completeData, 0); 
					else createDropdown();
				}
			}
		});
	}
	
	//Show the buttons.
 	$('.above-form ').show();

	//On the trail page we have to first insert the form's details into the complete data set.
	//If the trail is a new trail, we have to add the trail to the data set.
	$('#save-changes').click( function(){
		  if( trailID == -1 ){
			  trailID = completeData.trails.length;
			  completeData.trails[trailID] = editor.getValue();
			  createDropdown();
		  }else{
			  completeData.trails[trailID] = editor.getValue();
		  }
		  saveObject( filePath, completeData );
      createDropdown();
	});

	//Enable the download JSON button. 
	$('#download-json').attr('href',filePath);

	//Enable the revert to last save button.
	$('#revert-last-save').click( function(){
		if( confirm("Are you sure?\nYou will lose changes made since the last save.") ){

			if( trailID==-1 ){
				setJsonValue( completeData, -1 );
			}else{
				$.getJSON(filePath, function(json) {
            setJsonValue( json, trailID );
				});
			}
		}
	});

	//Enable the revert to original button.
	$('#revert-original').click( function(){
		if( confirm("Are you sure?\nThis will set the form's data back to factory settings.\nIF YOU THEN CLICK \"SAVE\", ALL PREVIOUSLY SAVED DATA CHANGES WILL BE LOST.") ){
			//If the quiz is a new quiz, change the revert to orginal button to a "delete new quiz" button
			$.getJSON("assets/data/original/TrailData.json", function(json) {
        setJsonValue( json, 0 );
			});
		}
	});

	//Back to home button
	$('#back-to-home').click( function() {
		if( confirm("Are you sure?\nAny unsaved changes will be lost.") ){
			location.reload(); 
		}
	});

 
	
}


//-----FUNCTION----
function saveObject(filePath, jsonObject){
	var json = JSON.stringify(jsonObject);
  console.log('json=' + json + '&file='+filePath)
  console.log(typeof(json))
  $.ajax({
    type: 'POST',
    url: 'writeJSON.php',
    data: 'json=' + json + '&file='+filePath,
    headers: {'Content-type':'application/x-www-form-urlencoded'},
    success: function(msg){
      if( $.trim(msg) != "success" ) alert(msg);
      else alert("Object Saved");
    },
    error: function(x, status, error){
      alert("An error occurred: " + status + "\nnError: " + error);
    }
  });
}

$('#minDat').click( function() {
	openMineralPage();
});

$('#glosDat').click( function() {
	openNormalPage( glossary_schema, "GlossaryData.json" );
});

$('#quizzesDat').click( function() {
	openQuizPage( );
});


$('#trailsDat').click( function() {
	openTrailPage( );
});

});//End document.ready


		</script>

<?php } ?>
