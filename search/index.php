<?php
    // START SESSION
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

// LOAD WEBSITE
$admin_page_title = '<a href="../index.php">Smartfalt</a> > <a href="index.php">Zoekgeschiedenis</a>';
require_once('../config.php');
$page_Title = 'Smartfalt - Search';
require_once('../site/site_header_search.php');
require_once('../db/connect_' . $_SERVER['SERVER_NAME'] . '.php');
require_once('../db/db_connect.php');
require_once('search_history.php');

