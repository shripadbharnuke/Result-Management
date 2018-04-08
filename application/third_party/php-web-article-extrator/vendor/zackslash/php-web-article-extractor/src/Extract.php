<?php namespace WebArticleExtractor;
	/**
	 *	PHP Web Article Extractor
	 *	A PHP library to extract the primary article content of a web page.
	 *	
	 *	@author Luke Hines
	 *	@link https://github.com/zackslash/PHP-Web-Article-Extractor
	 *	@licence: PHP Web Article Extractor is made available under the MIT License.
	 */
	
	/**
	*	Extract is the package's main API providing the front extraction methods.
	*/
	class Extract 
	{

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
			
			if($host == "www.tribuneindia.com") {
				curl_setopt($handle, CURLOPT_ENCODING, "");
				curl_setopt($handle, CURLOPT_MAXREDIRS, 10);
				curl_setopt($handle, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
				curl_setopt($handle, CURLOPT_HTTPHEADER, array(
					"cache-control: no-cache",
					"postman-token: d64abdcd-8735-0978-5f84-bae374d81d9f"
				));
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
		/**
		*	Extracts an article directly from a URL
		*
		*	@param  string  $url the URL to extract an article from
		*	@return Article extraction result
		*/
		public static function extractFromURL($url)
		{
			$html = self::_getContent($url);
			
			if($html === FALSE) 
			{
				return;
			}
			
			return self::extractFromHTML($html, $url);
		}
		
		/**
		*	Extracts an article from HTML
		*
		*	@param  string  $rawHTMLPage the raw HTML from which to extract an article
		*	@return Article extraction result
		*/
		public static function extractFromHTML($rawHTMLPage, $source = "") 
		{
			$parser = new HTMLParser();
			
			// Parse HTML into blocks
			$article = $parser->parse($rawHTMLPage);
			
			// Filter out clean article title
			Filters\TitleFilter::filter($article);
			
			// Discover article 'end' points using syntactic terminators
			Filters\EndBlockFilter::filter($article);
			
			// Filter content using word count and link density using algorithm from Machine learning
			Filters\NumberOfWordsFilter::filter($article);
			
			// Filter blocks that come after content
			Filters\PostcontentFilter::filter($article);
			
			// Merge close blocks
			Mergers\CloseBlockMerger::merge($article);
			
			// Remove blocks that are not content
			Filters\NonContentFilter::filter($article);
			
			// Mark largest block as 'content'
			Filters\LargestBlockFilter::filter($article);
			
			// Mark blocks found between the title and main content as content as well
			Filters\BetweenTitleAndContentFilter::filter($article);
			
			// Post-extraction cleanup removing now irrelevant blocks and sets full title
			Filters\PostextractionFilter::filter($article);
			
			// Scans article line by line removing non-content on a per-line basis
			Filters\LineFilter::filter($article);
			
			// Determine document language
			Filters\LanguageFilter::filter($article);
			
			// Filter keywords from the article document
			Filters\KeywordFilter::filter($article);
			
			$article->source = $source;

			$article->text = "";

			foreach ($article->textBlocks as $val) {
				$article->text .= "<p>".$val->text."</p>";
			}
			
			return $article; 
		}
	}
?>