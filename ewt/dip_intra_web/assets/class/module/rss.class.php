<?php
class rss
{
    public static function getRss()
    {
        $_sql = "SELECT * FROM " . E_DB_NAME . ".rss WHERE rss_status = 'Y' ";
        $a_row = db::getRowCount($_sql);
        $a_data = db::getFetchAll($_sql);

        if ($a_data) {
            return $a_data;
        }
    }

    public static function getMoreRss($rss_id)
    {
        // ini_set("memory_limit", "-1");
        // set_time_limit(0);
        $wh = "";
        if ($rss_id) {
            $wh .= "AND rss_id = '{$rss_id}'";
        }

        $_sql = "SELECT * FROM " . E_DB_NAME . ".rss WHERE 1=1 {$wh}";
        $a_row = db::getRowCount($_sql);
        $a_data = db::getFetch($_sql);

        if ($a_data) {
            $rss_title = $a_data['rss_title'];
            $rss_url = $a_data['rss_url'];
            $rss_images = $a_data['rss_images'];
            $rss_row = $a_data['rss_row'];

            if ($rss_url) {
                $curl = curl_init();
                curl_setopt($curl, CURLOPT_URL, $rss_url);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($curl, CURLOPT_TIMEOUT, 10);

                $content = curl_exec($curl);
                curl_close($curl);

                // if ($content == false || $content == "") {
                //     $checkCurl = curl_error($curl)." --- ".curl_errno($curl);
                // } else {
                //     $checkCurl = $content;
                // }

                // return $content;
                // return strpos($content, "<item");
                if (strpos($content, "<item") !== false) {
                    $parsed_xml = simplexml_load_string($content);
                    $xml = new SimpleXMLElement($content);
                    $xml->registerXPathNamespace('rdf', 'http://www.w3.org/1999/02/22-rdf-syntax-ns#');
                    $xml->registerXPathNamespace('cd', 'http://www.recshop.fake/cd#');
                    $num = empty($parsed_xml->channel->item->title) ? count($parsed_xml->item) : count($parsed_xml->channel->item);
                    // $channel_title = $parsed_xml->channel->title;
                    // $channel_link = $parsed_xml->channel->link;
                    // $channel_description = $parsed_xml->channel->description;
                    // $channel_lastBuildDate = $parsed_xml->channel->lastBuildDate;

                    return array(
                        "rss_title" => $rss_title,
                        //"num" => $num,
                        // "channel_title" => $channel_title,
                        // "channel_link" => $channel_link,
                        // "channel_description" => $channel_description,
                        // "channel_lastBuildDate" => $channel_lastBuildDate,
                        "rss_url" => $rss_url,
                        "rss_images" => $rss_images,
                        "rss_row" => ($rss_row > $num ? $num : $rss_row),
                        "parsed_xml" => $xml,
                        "content" => $content
                    );
                } else {
                    return false;
                }
            }
        }
    }
}
