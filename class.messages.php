<?php
//--------------------------------------------------------------------------------------------------
// Session-Based Flash Messages v1.0
// Copyright 2012 Mike Everhart (http://mikeeverhart.net)
//
//   Licensed under the Apache License, Version 2.0 (the "License");
//   you may not use this file except in compliance with the License.
//   You may obtain a copy of the License at
//
//     http://www.apache.org/licenses/LICENSE-2.0
//
//   Unless required by applicable law or agreed to in writing, software
//   distributed under the License is distributed on an "AS IS" BASIS,
//   WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
//   See the License for the specific language governing permissions and
//	 limitations under the License.
//
//------------------------------------------------------------------------------
// Description:
//------------------------------------------------------------------------------
//
//	Stores messages in Session data to be easily retrieved later on.
// 	This class includes four different types of messages:
//  - Success
//  - Error
//  - Warning
//  - Information
//
//  See README for basic usage instructions, or see samples/index.php for more advanced samples
//
//--------------------------------------------------------------------------------------------------
// Changelog
//--------------------------------------------------------------------------------------------------
//
//	2011-05-15 - v1.0 - Initial Version
//
//--------------------------------------------------------------------------------------------------

namespace helpers;

class Messages {

	//-----------------------------------------------------------------------------------------------
	// Class Variables
	//-----------------------------------------------------------------------------------------------
	static $msgId;
	static $msgTypes = array( 'warning', 'error', 'success', 'info' );
	static $msgClass = 'alert';
	static $msgWrapper = "<div class='%s alert-%s'><a href='#' class='closeMessage'></a>\n%s</div>\n";
	static $msgBefore = '';
	static $msgAfter = '';


	/**
	 * Constructor
	 * @author Mike Everhart
	 */
	public function __construct() {

		// Generate a unique ID for this user and session
		self::$msgId = md5(uniqid());
	}

	/**
	 * Add a message to the queue
	 *
	 * @author Mike Everhart
	 *
	 * @param  string   $type        	The type of message to add
	 * @param  string   $message     	The message
	 * @param  string   $redirect_to 	(optional) If set, the user will be redirected to this URL
	 * @return  bool
	 *
	 */
	public static function add($type, $message, $redirect_to = null) {

		// Create the session array if it doesnt already exist
		if( !array_key_exists('flash_messages', $_SESSION) ) $_SESSION['flash_messages'] = array();

		if( !isset($type) || !isset($message[0]) ) return false;

		// Replace any shorthand codes with their full version
		if( strlen(trim($type)) == 1 ) {
			$type = str_replace( array('w', 'e', 's', 'i'), array('warning', 'error', 'success', 'info'), $type );

			// Backwards compatibility...
		} elseif( $type == 'information' ) {
			$type = 'info';
		}

		// Make sure it's a valid message type
		if( !in_array($type, self::$msgTypes) ) die('"' . strip_tags($type) . '" is not a valid message type!' );

		// If the session array doesn't exist, create it
		if( !array_key_exists( $type, $_SESSION['flash_messages'] ) ) $_SESSION['flash_messages'][$type] = array();

		$_SESSION['flash_messages'][$type][] = $message;

		if( !is_null($redirect_to) ) {
			header("Location: $redirect_to");
			exit();
		}

		return true;

	}

	//-----------------------------------------------------------------------------------------------
	// display()
	// print queued messages to the screen
	//-----------------------------------------------------------------------------------------------
	/**
	 * Display the queued messages
	 *
	 * @author Mike Everhart
	 *
	 * @param  string   $type     Which messages to display
	 * @param  bool  	$print    True  = print the messages on the screen
	 * @return mixed
	 *
	 */
	public static function display($type='all', $print=true) {
		$messages = '';
		$data = '';

		if( !isset($_SESSION['flash_messages']) ) return false;

		// Print a certain type of message?
		if( in_array($type, self::$msgTypes) ) {
			foreach( $_SESSION['flash_messages'][$type] as $msg ) {
				$messages .= self::$msgBefore . $msg . self::$msgAfter;
			}

			$data .= sprintf(self::$msgWrapper, self::$msgClass, $type, $messages);

			// Clear the viewed messages
			self::clear($type);

			// Print ALL queued messages
		} elseif( $type == 'all' ) {
			foreach( $_SESSION['flash_messages'] as $type => $msgArray ) {
				$messages = '';
				foreach( $msgArray as $msg ) {
					$messages .= self::$msgBefore . $msg . self::$msgAfter;
				}
				$data .= sprintf(self::$msgWrapper, self::$msgClass, $type, $messages);
			}

			// Clear ALL of the messages
			self::clear();

			// Invalid Message Type?
		} else {
			return false;
		}

		// Print everything to the screen or return the data
		if( $print ) {
			echo $data;
		} else {
			return $data;
		}
		return false;
	}


	/**
	 * Check to  see if there are any queued error messages
	 *
	 * @author Mike Everhart
	 *
	 * @return bool  true  = There ARE error messages
	 *               false = There are NOT any error messages
	 *
	 */
	public static function hasErrors() {
		return !empty($_SESSION['flash_messages']['error']);
	}

	/**
	 * Check to see if there are any ($type) messages queued
	 *
	 * @author Mike Everhart
	 *
	 * @param  string   $type     The type of messages to check for
	 * @return bool
	 *
	 */
	public static function hasMessages($type=null) {
		if( !is_null($type) ) {
			if( !empty($_SESSION['flash_messages'][$type]) ) return $_SESSION['flash_messages'][$type];
		} else {
			foreach( self::$msgTypes as $type ) {
				if( !empty($_SESSION['flash_messages']) ) return true;
			}
		}
		return false;
	}

	/**
	 * Clear messages from the session data
	 *
	 * @author Mike Everhart
	 *
	 * @param  string   $type     The type of messages to clear
	 * @return bool
	 *
	 */
	public static function clear($type='all') {
		if( $type == 'all' ) {
			unset($_SESSION['flash_messages']);
		} else {
			unset($_SESSION['flash_messages'][$type]);
		}
		return true;
	}

	public function __toString() { return (string)self::hasMessages();	}

	public function __destruct() {
		//$this->clear();
	}


}
