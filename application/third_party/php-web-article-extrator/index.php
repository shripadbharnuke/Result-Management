<?php

// This file is generated by Composer
require_once 'vendor/autoload.php';

// Extract article directly from a URL
$extractionResult = WebArticleExtractor\Extract::extractFromURL($_GET['url']);

header('Content-Type: application/json');

// Display the extracted article in JSON form
echo json_encode($extractionResult);

?>