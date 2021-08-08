<?php
if(isset($_GET['key'])){
	
	$keyword=$_GET['key'];
	$xml= simplexml_load_string(file_get_contents("https://news.google.com/rss/search?q=".$keyword."&hl=en-IN&gl=IN&ceid=IN:en")); 
	##Important-
	#If you are from different country remove the get requests and try the url on your browser and commit changes accordingly in $xml

	$arrtime=array();
	
	foreach ($xml->channel->item as $value) {
		array_push($arrtime, $value);  
	}
	

	function compareByTimeStamp($item1, $item2) #A function to compare two time values
	{
		$time1=$item1->pubDate;
		$time2=$item2->pubDate;
		if (strtotime($time1) < strtotime($time2))
			return 1;
		else if (strtotime($time1) > strtotime($time2)) 
			return -1;
		else
			return 0;
	}

	usort($arrtime, "compareByTimeStamp");#Sorts letest news

	foreach($arrtime as $currentarr){
		$title=$currentarr->title;
		$des=$currentarr->description;
		$posttime=$currentarr->pubDate;
		$postlink=$currentarr->link;
		
		echo '<b>Title:</b> '.$title.' <b>Published in:</b> '.$posttime.'<br>';
	}

}

?>

<form action="#" method="get">
keyword: <input type="text" name="key"><br><!--Simple Form-->
<input type="submit">
</form>