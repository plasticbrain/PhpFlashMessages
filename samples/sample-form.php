<?php
//------------------------------------------------------------------------------
// A session is required for the messages to work
//------------------------------------------------------------------------------
if( !session_id() ) session_start();

//------------------------------------------------------------------------------
// Include the Messages class and instantiate it
//------------------------------------------------------------------------------
require_once('../class.messages.php');
$msg = new Messages();

//------------------------------------------------------------------------------
// Process the form if it was submitted
//------------------------------------------------------------------------------
if( isset($_POST['btn_submit']) ) {
	
	//
	// Step 1
	// Check for the required fields
	//

	if( strlen(trim(@$_POST['field1'])) == 0 ) $msg->add('e', 'Field 1 is required!');	
	if( strlen(trim(@$_POST['field2'])) == 0 ) $msg->add('e', 'Field 2 is required!');	
	
	//
	// Step 2
	// After all the fields have been validated then check for any errors before proceeding
	//
	
	// If there are no errors then the form was valid. 
	if( !$msg->hasErrors() ) {
		
		// To help demonstrate functionality we'll add a "success" message and redirect the user
		$msg->add('s', 'The form was valid!');
		
		// You could technically redirect to any page, and the messages will be displayed as long as the
		// $msg->display(); code is there. For our sake, we're redirecting back to this page to clear the POST data.
		header('Location: sample-form.php');
		
		// Always be sure to exit() after a redirect! If not, the rest of the script will still be processed.
		exit(); 
	
	} else {
		// If there are any errors then you should take an appropriate action.
		// Since we are displaying this page again if there is an error
		// then there is nothing else for us to do.	
	}
}


//------------------------------------------------------------------------------
// Print out the HTML page as usual
//------------------------------------------------------------------------------
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>Session-Based Flash Messages</title>
		<link href="../style.css" rel="stylesheet" type="text/css" />
	</head>
	<body>
		
		<h1>How to Handle Form Validation</h1>
		<?php
		//------------------------------------------------------------------------
		// Display any messages
		//------------------------------------------------------------------------
		echo $msg->display();
		?>
		
		<form action="" method="post">
			<span style="color:#c00;">*</span> Field 1: <input type="text" name="field1" value="" /><br />
			<span style="color:#c00;">*</span> Field 2: <input type="text" name="field2" value="" /><br />
			&nbsp; &nbsp;Field 3: <input type="text" name="field3" value="" /><br /><br />
			<input type="submit" class="button" value="Validate Form" name="btn_submit" /><br />
			<p><span style="font-size: 11px; color:#c00;">*</span> = Required Field</p>
		</form> 
		
		<br /><hr /><br />	
		<p><a href="index.php">Go Back</a></p>
	</body>
</html>