<?php

namespace DotPack\PhpBoilerPipe;

use DotPack\PhpBoilerPipe\Filters\Heuristics\DocumentTitleMatchClassifier;
use DotPack\PhpBoilerPipe\Filters\Heuristics\TrailingHeadlineToBoilerplateFilter;
use DotPack\PhpBoilerPipe\Filters\Heuristics\BlockProximityFusion;
use DotPack\PhpBoilerPipe\Filters\Heuristics\KeepLargestBlockFilter;
use DotPack\PhpBoilerPipe\Filters\Heuristics\ExpandTitleToContentFilter;
use DotPack\PhpBoilerPipe\Filters\Heuristics\LargeBlockSameTagLevelToContentFilter;
use DotPack\PhpBoilerPipe\Filters\Heuristics\ListAtEndFilter;

use DotPack\PhpBoilerPipe\Filters\Simple\BoilerplateBlockFilter;

use DotPack\PhpBoilerPipe\Filters\English\TerminatingBlocksFinder;
use DotPack\PhpBoilerPipe\Filters\English\NumWordsRulesClassifier;
use DotPack\PhpBoilerPipe\Filters\English\IgnoreBlocksAfterContentFilter;

class ArticleExtractor
{
    protected static function process(TextDocument $doc)
    {
        return (new TerminatingBlocksFinder())->process($doc)
        | (new DocumentTitleMatchClassifier)->process($doc)
        | (new NumWordsRulesClassifier)->process($doc)
        | (new IgnoreBlocksAfterContentFilter(60))->process($doc)
        | (new TrailingHeadlineToBoilerplateFilter)->process($doc)
        | (new BlockProximityFusion(1))->process($doc)
        | (new BoilerplateBlockFilter(TextLabels::TITLE))->process($doc)
        | (new BlockProximityFusion(1, true, true))->process($doc)
        | (new KeepLargestBlockFilter(true, 150))->process($doc)
        | (new ExpandTitleToContentFilter)->process($doc)
        | (new LargeBlockSameTagLevelToContentFilter)->process($doc)
        | (new ListAtEndFilter)->process($doc);
    }

    public static function extractFromURL($url)
    {
		$html = self::_getContent($url);
		
		if($html === FALSE) 
		{
			return;
		}
		
        $content = new HtmlContent($html);
        $document = $content->getTextDocument();
        
		self::process($document);

        $description = $document->getContent();
		return (object)array('text' => $description);
    }
	
	protected static function _getContent($url)
	{
		$parse = parse_url($url);
		$host = $parse['host'];
		$scheme = $parse['scheme'];
		$handle = curl_init($url);
		
		curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($handle, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($handle, CURLOPT_FOLLOWLOCATION, TRUE); 
		
		
		if(in_array($host, array("www.thenewsminute.com", "www.forbes.com"))) {
			
			curl_setopt($handle, CURLOPT_ENCODING, 'identity');
			
		}

		curl_setopt($handle, CURLOPT_HTTPHEADER, array(					
				"Referer: ".$scheme."//".$host,
				"Host: ".$host,
			));
		
		/* Get the HTML or whatever is linked in $url. */
		$response = curl_exec($handle);
		// response total time
		$time = curl_getinfo($handle, CURLINFO_TOTAL_TIME);
		/* Check for 404 (file not found). */
		$httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
		// log_message('error', $httpCode);
		curl_close($handle);
		// print_r($response);exit;
		return $response;
	}
}