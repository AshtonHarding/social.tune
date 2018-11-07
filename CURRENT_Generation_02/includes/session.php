<?php
	// save as /includes/session.php

		// Disable transparent session id support (makes sessions shaerable via url, we do not want this!)... 
	ini_set('session.use_trans_sid', 0);
	
		// Have PHP give us a new session ID and destroy the old one and everything associated with it, this is an additional step to help prevent session hijacking...
	session_regenerate_id(true);
	
		// Start the session...
	session_start();

?>