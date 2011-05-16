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
// Add some messages
//------------------------------------------------------------------------------
//$msg->add('s', 'The is a sample Success Message');
//$msg->add('e', 'The is a sample Error Message');
//$msg->add('w', 'The is a sample Warning Message');
//$msg->add('i', 'The is a sample Information Message');

//------------------------------------------------------------------------------
// Print the HTML page as usual
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
		
		<h1>Simple, Session-Based Flash Messages</h1>
		<?php
		//------------------------------------------------------------------------
		// Display any messages
		//------------------------------------------------------------------------
		echo $msg->display();
		?>
		
		
		<h3>Create a New Message</h3>
		<form action="process-form.php" method="post">
			Message Text: <input style="width: 300px;" type="text" class="text" name="text" value="" /> <br />
			Message Type:
			<label id="m_error"><input type="radio" name="type[]" value="e" id="m_error" checked="checked" /> Error</label>
			<label id="m_success"><input type="radio" name="type[]" value="s" id="m_success" /> Success</label>
			<label id="m_info"><input type="radio" name="type[]" value="i" id="m_info" /> Information</label>
			<label id="m_warning"><input type="radio" name="type[]" value="w" id="m_warning" /> Warning</label><br /><br />
			<input type="submit" class="button" name="btn_submit" value="Create Message" />
		</form>
		
		<br /><hr /><br />	
		
		<h3>How to Handle Form Validation</h3>
		<p><a href="sample-form.php">View Sample Form</a></p>
	</body>
</html>
