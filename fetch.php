<?php
header("Content-Type: text/html; charset=utf-8");
$urls = file("feeds.txt", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$html = "";
foreach ($urls as $url) {
    $xml = @simplexml_load_file($url);
    if (!$xml || !isset($xml->channel->item)) continue;
    $html .= "<section><h2>" . htmlspecialchars($xml->channel->title) . "</h2><ul>";
    $count = 0;
    foreach ($xml->channel->item as $item) {
        if ($count++ >= 5) break;
        $title = htmlspecialchars($item->title);
        $link = htmlspecialchars($item->link);
        $date = date("Y/m/d H:i", strtotime($item->pubDate));
        $html .= "<li><a href=\"$link\" target=\"_blank\">$title</a><time>$date</time></li>";
    }
    $html .= "</ul></section>";
}
echo $html ?: "هیچ خبری در حال حاضر در دسترس نیست.";
?>
