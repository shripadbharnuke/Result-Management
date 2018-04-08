<?php

require 'vendor/autoload.php';

# html
// $path = "http://womansera.com/17171/top-story/want-to-remain-virgin-learn-to-say-no";
$path = (isset($_GET['url']) ? $_GET['url'] : 'http://www.example.com');
$data = file_get_contents($path);

# code
$ae = new DotPack\PhpBoilerPipe\ArticleExtractor::extractFromURL($path);
header("Content-Type:text/plain");
// print_r($ae);
echo $ae->getContent($data) . "\n";
