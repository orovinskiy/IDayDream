<?php

// Start the session
session_start();

// Destroy the session
session_destroy();
$_SESSION = array();

// Redirect to index.php
header('location: login.php');


