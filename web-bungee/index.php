<?php
$useragent=$_SERVER['HTTP_USER_AGENT'];
if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4)))
header('Location: http://m.textimz.com');
?>

<?php
    session_start();
    include "config.php";
    $today = date("Y-m-d");
    //echo $today;

    // ---------- FOR RECENTS AND POPOLAR NEWS------------------------
    $stmt = $conn->prepare("SELECT a.pk_i_id , a.s_headline, a.s_create_time, a.s_slug, a.s_content, b.s_source from t_news_item as a, t_media as b where a.pk_i_id = b.fk_i_item_id and b_active = 1 group by a.pk_i_id order by a.pk_i_id desc LIMIT 100");
    $stmt->execute();
    $ids         = array();
    $createTimes = array();
    $headlines   = array();
    $slugs       = array();
    $sources     = array();
    $contents = array();
    $card_date = array();
    while ($result = $stmt->fetch(PDO::FETCH_ASSOC))
            {
                    $ids[]         = $result['pk_i_id'];
                    $createTimes[] = $result['s_create_time'];
                    $headlines[]   = $result['s_headline'];
                    $slugs[]       = $result['s_slug'];
                    $sources[]     = $result['s_source'];
                    $contents[]     = $result['s_content'];
                    $card_date[] = date('j M', strtotime($result['s_create_time']));
            }
    $totalIds = count($ids);
    // ---------- FOR CATEGORY IN INDEX MENU------------------------
    $stmt1 = $conn->prepare("SELECT * FROM s_categories");
    $stmt1->execute();
    $categories = array();
    while ($cat = $stmt1->fetch(PDO::FETCH_ASSOC)) {
        $categories[] = $cat['categories_name'];
    }
    $totalCats = count($categories);
    //echo $totalIds;
    // print_r($ids);

    // ---------- FOR FEATURED NEWS------------------------

     $stmt1 = $conn->prepare("SELECT a.pk_i_id , a.s_headline, a.s_create_time, a.s_slug, a.s_content, b.s_source from t_news_item as a, t_media as b where a.pk_i_id = b.fk_i_item_id and b_publish = 1 group by a.pk_i_id order by a.pk_i_id desc LIMIT 10");
    $stmt1->execute();
    $featured_ids         = array();
    $featured_createTimes = array();
    $featured_headlines   = array();
    $featured_slugs       = array();
    $featured_sources     = array();
    $featured_contents = array();
    $featured_card_date = array();
    while ($result1 = $stmt1->fetch(PDO::FETCH_ASSOC))
            {
                    $featured_ids[]         = $result1['pk_i_id'];
                    $featured_createTimes[] = $result1['s_create_time'];
                    $featured_headlines[]   = $result1['s_headline'];
                    $featured_slugs[]       = $result1['s_slug'];
                    $featured_sources[]     = $result1['s_source'];
                    $featured_contents[]     = $result1['s_content'];
                    $featured_card_date[] = date('j M', strtotime($result1['s_create_time']));
            }
    // ---------- FOR EVENT MARKEE------------------------

    $query2 = $conn->prepare("SELECT a.pk_i_id , a.event_name,a.date_start, a.date_end, a.fk_country_id, a.city, a.venue, a.details ,a.product , a.fk_category_id, a.attendee , a.link ,a.media_link, a.tags, a.fk_user_id, a.b_active, a.b_publish ,b.s_source ,b.fk_event_id, c.categories_name, c.pk_i_id ,d.country_name,d.pk_i_id, e.s_fname, e.s_lname ,e.pk_i_id from t_events as a, t_media_events as b, s_categories as c, s_country as d, t_user as e where a.pk_i_id = b.fk_event_id and a.fk_country_id = d.pk_i_id and a.fk_category_id = c.pk_i_id and a.fk_user_id = e.pk_i_id and a.b_publish = 1 and a.date_start >= :today group by a.pk_i_id order by a.pk_i_id DESC  ");
    $query2->bindparam(":today", $today);

    $query2->execute();

    $ev_id         = array();
    $ev_event = array();
    $ev_country   = array();
    $ev_tag = array();
    $ev_source = array();
    $ev_card_date_start = array();
    $ev_card_date_end = array();

    while ($res1 = $query2->fetch(PDO::FETCH_ASSOC))
            {
                    $ev_id[]         = $res1['pk_i_id'];
                    $ev_event[] = $res1['event_name'];
                    $ev_country[]     = $res1['country_name'];
                    $ev_tag[] = $res1['tags'];
                    $ev_source[] = $res1['s_source'];
                    $ev_card_date_start[] = date('j M', strtotime($res1['date_start']));
                    $ev_card_date_end[] = date('j M', strtotime($res1['date_end']));
            }

        // ---------- FOR EVENTS--------------------------------
    $query = $conn->prepare("SELECT a.pk_i_id , a.event_name,a.date_start, a.date_end, a.fk_country_id, a.city, a.venue, a.details ,a.product , a.fk_category_id, a.attendee , a.link ,a.media_link, a.tags, a.fk_user_id, a.b_active, a.b_publish ,b.s_source ,b.fk_event_id, c.categories_name, c.pk_i_id ,d.country_name,d.pk_i_id, e.s_fname, e.s_lname ,e.pk_i_id from t_events as a, t_media_events as b, s_categories as c, s_country as d, t_user as e where a.pk_i_id = b.fk_event_id and a.fk_country_id = d.pk_i_id and a.fk_category_id = c.pk_i_id and a.fk_user_id = e.pk_i_id and a.b_active = 1  and a.date_start >= :today  group by a.pk_i_id order by a.pk_i_id ASC");
    $query->bindparam(":today", $today);
    $query->execute();

    $ev_ids         = array();
    $ev_events = array();
    $ev_countrys   = array();
    $ev_tags = array();
    $ev_sources = array();
    $ev_card_date_starts = array();
    $ev_card_date_ends = array();

    while ($res2 = $query->fetch(PDO::FETCH_ASSOC))
            {
                    $ev_ids[]         = $res2['pk_i_id'];
                    $ev_events[] = $res2['event_name'];
                    $ev_countrys[]     = $res2['country_name'];
                    $ev_tags[] = $res2['tags'];
                    $ev_sources[] = $res2['s_source'];
                    $ev_card_date_starts[] = date('j M', strtotime($res2['date_start']));
                    $ev_card_date_ends[] = date('j M', strtotime($res2['date_end']));
            }
 $totalevents = count($ev_ids);

    // ---------- FOR APPAREL NEWS--------------------------------
    $stmt3 = $conn->prepare("SELECT a.pk_i_id , a.s_headline,a.s_content, a.s_create_time, a.s_slug, b.s_source, c.link_name, c.link , e.fk_i_category_id , e.fk_i_item_id , f.categories_name, f.pk_i_id from t_news_item as a, t_media as b, t_link as c, t_categories as e, s_categories as f where a.pk_i_id = b.fk_i_item_id and c.fk_i_news_item_id = a.pk_i_id and a.pk_i_id = e.fk_i_item_id and e.fk_i_category_id = 1 group by a.pk_i_id order by a.pk_i_id desc LIMIT 10");
    $stmt3->execute();

    //print_r($a_news_ids);
    //echo $totalNewsIds;
    $a_createTimes = array();
    $a_headlines   = array();
    $a_slugs       = array();
    $a_sources     = array();
    $a_contents = array();
    $a_card_date = array();
    while ($apparel = $stmt3->fetch(PDO::FETCH_ASSOC))
            {
                    $a_createTimes[] = $apparel['s_create_time'];
                    $a_headlines[]   = $apparel['s_headline'];
                    $a_slugs[]       = $apparel['s_slug'];
                    $a_sources[]     = $apparel['s_source'];
                    $a_contents[]     = $apparel['s_content'];
                    $a_card_date[] = date('j M', strtotime($apparel['s_create_time']));
            }
    $a_totalIds = count($a_headlines);
    
    // ---------- FOR TEXTILE NEWS--------------------------------

    $stmt4 = $conn->prepare("SELECT a.pk_i_id , a.s_headline,a.s_content, a.s_create_time, a.s_slug, b.s_source, c.link_name, c.link , e.fk_i_category_id , e.fk_i_item_id , f.categories_name, f.pk_i_id from t_news_item as a, t_media as b, t_link as c, t_categories as e, s_categories as f where a.pk_i_id = b.fk_i_item_id and c.fk_i_news_item_id = a.pk_i_id and a.pk_i_id = e.fk_i_item_id and e.fk_i_category_id = 2 group by a.pk_i_id order by a.pk_i_id desc LIMIT 10");
    $stmt4->execute();

    //print_r($a_news_ids);
    //echo $totalNewsIds;
    $t_createTimes = array();
    $t_headlines   = array();
    $t_slugs       = array();
    $t_sources     = array();
    $t_contents = array();
    $t_card_date = array();
    while ($textile = $stmt4->fetch(PDO::FETCH_ASSOC))
            {
                    $t_createTimes[] = $textile['s_create_time'];
                    $t_headlines[]   = $textile['s_headline'];
                    $t_slugs[]       = $textile['s_slug'];
                    $t_sources[]     = $textile['s_source'];
                    $t_contents[]     = $textile['s_content'];
                    $t_card_date[] = date('j M', strtotime($textile['s_create_time']));
            }
    $t_totalIds = count($t_headlines);

        // ---------- FOR FASHION NEWS--------------------------------
    $stmt5 = $conn->prepare("SELECT a.pk_i_id , a.s_headline,a.s_content, a.s_create_time, a.s_slug, b.s_source, c.link_name, c.link , e.fk_i_category_id , e.fk_i_item_id , f.categories_name, f.pk_i_id from t_news_item as a, t_media as b, t_link as c, t_categories as e, s_categories as f where a.pk_i_id = b.fk_i_item_id and c.fk_i_news_item_id = a.pk_i_id and a.pk_i_id = e.fk_i_item_id and e.fk_i_category_id = 3 group by a.pk_i_id order by a.pk_i_id desc LIMIT 10");
    $stmt5->execute();

    //print_r($a_news_ids);
    //echo $totalNewsIds;
    $f_createTimes = array();
    $f_headlines   = array();
    $f_slugs       = array();
    $f_sources     = array();
    $f_contents = array();
    $f_card_date = array();
    while ($Fashion = $stmt5->fetch(PDO::FETCH_ASSOC))
            {
                    $f_createTimes[] = $Fashion['s_create_time'];
                    $f_headlines[]   = $Fashion['s_headline'];
                    $f_slugs[]       = $Fashion['s_slug'];
                    $f_sources[]     = $Fashion['s_source'];
                    $f_contents[]     = $Fashion['s_content'];
                    $f_card_date[] = date('j M', strtotime($Fashion['s_create_time']));
            }
    $f_totalIds = count($f_headlines);
    
    // ---------- FOR INSTITUTION NEWS--------------------------------

   $stmt6 = $conn->prepare("SELECT a.pk_i_id , a.s_headline,a.s_content, a.s_create_time, a.s_slug, b.s_source, c.link_name, c.link , e.fk_i_category_id , e.fk_i_item_id , f.categories_name, f.pk_i_id from t_news_item as a, t_media as b, t_link as c, t_categories as e, s_categories as f where a.pk_i_id = b.fk_i_item_id and c.fk_i_news_item_id = a.pk_i_id and a.pk_i_id = e.fk_i_item_id and e.fk_i_category_id = 11 group by a.pk_i_id order by a.pk_i_id desc LIMIT 10");
    $stmt6->execute();

    //print_r($a_news_ids);
    //echo $totalNewsIds;
    $inst_createTimes = array();
    $inst_headlines   = array();
    $inst_slugs       = array();
    $inst_sources     = array();
    $inst_contents = array();
    $inst_card_date = array();
    while ($Institutional = $stmt6->fetch(PDO::FETCH_ASSOC))
            {
                    $inst_createTimes[] = $Institutional['s_create_time'];
                    $inst_headlines[]   = $Institutional['s_headline'];
                    $inst_slugs[]       = $Institutional['s_slug'];
                    $inst_sources[]     = $Institutional['s_source'];
                    $inst_contents[]     = $Institutional['s_content'];
                    $inst_card_date[] = date('j M', strtotime($Institutional['s_create_time']));
            }
    $inst_totalIds = count($inst_headlines);
    // ---------- FOR CORPORATE NEWS--------------------------------

    $stmt8 = $conn->prepare("SELECT a.pk_i_id , a.s_headline,a.s_content, a.s_create_time, a.s_slug, b.s_source, c.link_name, c.link , e.fk_i_category_id , e.fk_i_item_id , f.categories_name, f.pk_i_id from t_news_item as a, t_media as b, t_link as c, t_categories as e, s_categories as f where a.pk_i_id = b.fk_i_item_id and c.fk_i_news_item_id = a.pk_i_id and a.pk_i_id = e.fk_i_item_id and e.fk_i_category_id = 6 group by a.pk_i_id order by a.pk_i_id desc LIMIT 10");
    $stmt8->execute();

    //print_r($a_news_ids);
    //echo $totalNewsIds;
    $c_createTimes = array();
    $c_headlines   = array();
    $c_slugs       = array();
    $c_sources     = array();
    $c_contents = array();
    $c_card_date = array();
    while ($Corporate = $stmt8->fetch(PDO::FETCH_ASSOC))
            {
                    $c_createTimes[] = $Corporate['s_create_time'];
                    $c_headlines[]   = $Corporate['s_headline'];
                    $c_slugs[]       = $Corporate['s_slug'];
                    $c_sources[]     = $Corporate['s_source'];
                    $c_contents[]     = $Corporate['s_content'];
                    $c_card_date[] = date('j M', strtotime($Corporate['s_create_time']));
            }
    $c_totalIds = count($c_headlines);

    // ---------- FOR RETAIL NEWS--------------------------------

    $stmt9 = $conn->prepare("SELECT a.pk_i_id , a.s_headline,a.s_content, a.s_create_time, a.s_slug, b.s_source, c.link_name, c.link , e.fk_i_category_id , e.fk_i_item_id , f.categories_name, f.pk_i_id from t_news_item as a, t_media as b, t_link as c, t_categories as e, s_categories as f where a.pk_i_id = b.fk_i_item_id and c.fk_i_news_item_id = a.pk_i_id and a.pk_i_id = e.fk_i_item_id and e.fk_i_category_id = 9 group by a.pk_i_id order by a.pk_i_id desc LIMIT 10");
    $stmt9->execute();

    //print_r($a_news_ids);
    //echo $totalNewsIds;
    $r_createTimes = array();
    $r_headlines   = array();
    $r_slugs       = array();
    $r_sources     = array();
    $r_contents = array();
    $r_card_date = array();
    while ($Retail = $stmt9->fetch(PDO::FETCH_ASSOC))
            {
                    $r_createTimes[] = $Retail['s_create_time'];
                    $r_headlines[]   = $Retail['s_headline'];
                    $r_slugs[]       = $Retail['s_slug'];
                    $r_sources[]     = $Retail['s_source'];
                    $r_contents[]     = $Retail['s_content'];
                    $r_card_date[] = date('j M', strtotime($Retail['s_create_time']));
            }
    $r_totalIds = count($r_headlines);

    // ---------- FOR INNOVATION NEWS--------------------------------

    $stmt10 = $conn->prepare("SELECT a.pk_i_id , a.s_headline,a.s_content, a.s_create_time, a.s_slug, b.s_source, c.link_name, c.link , e.fk_i_category_id , e.fk_i_item_id , f.categories_name, f.pk_i_id from t_news_item as a, t_media as b, t_link as c, t_categories as e, s_categories as f where a.pk_i_id = b.fk_i_item_id and c.fk_i_news_item_id = a.pk_i_id and a.pk_i_id = e.fk_i_item_id and e.fk_i_category_id = 13 group by a.pk_i_id order by a.pk_i_id desc LIMIT 10");
    $stmt10->execute();

    //print_r($a_news_ids);
    //echo $totalNewsIds;
    $i_createTimes = array();
    $i_headlines   = array();
    $i_slugs       = array();
    $i_sources     = array();
    $i_contents = array();
    $i_card_date = array();
    while ($Innovation = $stmt10->fetch(PDO::FETCH_ASSOC))
            {
                    $i_createTimes[] = $Innovation['s_create_time'];
                    $i_headlines[]   = $Innovation['s_headline'];
                    $i_slugs[]       = $Innovation['s_slug'];
                    $i_sources[]     = $Innovation['s_source'];
                    $i_contents[]    = $Innovation['s_content'];
                    $i_card_date[]   = date('j M', strtotime($Innovation['s_create_time']));
            }
    $i_totalIds = count($i_headlines);

    // ---------- FOR TECHNICAL TEXTILE NEWS--------------------------------

    $stmt11 = $conn->prepare("SELECT a.pk_i_id , a.s_headline,a.s_content, a.s_create_time, a.s_slug, b.s_source, c.link_name, c.link , e.fk_i_category_id , e.fk_i_item_id , f.categories_name, f.pk_i_id from t_news_item as a, t_media as b, t_link as c, t_categories as e, s_categories as f where a.pk_i_id = b.fk_i_item_id and c.fk_i_news_item_id = a.pk_i_id and a.pk_i_id = e.fk_i_item_id and e.fk_i_category_id = 4 group by a.pk_i_id order by a.pk_i_id desc LIMIT 10");
    $stmt11->execute();

    //print_r($a_news_ids);
    //echo $totalNewsIds;
    $tt_createTimes = array();
    $tt_headlines   = array();
    $tt_slugs       = array();
    $tt_sources     = array();
    $tt_contents = array();
    $tt_card_date = array();
    while ($tech_tex = $stmt11->fetch(PDO::FETCH_ASSOC))
            {
                    $tt_createTimes[] = $tech_tex['s_create_time'];
                    $tt_headlines[]   = $tech_tex['s_headline'];
                    $tt_slugs[]       = $tech_tex['s_slug'];
                    $tt_sources[]     = $tech_tex['s_source'];
                    $tt_contents[]     = $tech_tex['s_content'];
                    $tt_card_date[] = date('j M', strtotime($tech_tex['s_create_time']));
            }
    $tech_tex = count($tt_headlines);

    // ---------- FOR EVENTS NEWS--------------------------------

    $stmt12 = $conn->prepare("SELECT a.pk_i_id , a.s_headline,a.s_content, a.s_create_time, a.s_slug, b.s_source, c.link_name, c.link , e.fk_i_category_id , e.fk_i_item_id , f.categories_name, f.pk_i_id from t_news_item as a, t_media as b, t_link as c, t_categories as e, s_categories as f where a.pk_i_id = b.fk_i_item_id and c.fk_i_news_item_id = a.pk_i_id and a.pk_i_id = e.fk_i_item_id and e.fk_i_category_id = 8 group by a.pk_i_id order by a.pk_i_id desc LIMIT 10");
    $stmt12->execute();

    //print_r($a_news_ids);
    //echo $totalNewsIds;
    $eve_createTimes = array();
    $eve_headlines   = array();
    $eve_slugs       = array();
    $eve_sources     = array();
    $eve_contents = array();
    $eve_card_date = array();
    while ($eve = $stmt12->fetch(PDO::FETCH_ASSOC))
            {
                    $eve_createTimes[] = $eve['s_create_time'];
                    $eve_headlines[]   = $eve['s_headline'];
                    $eve_slugs[]       = $eve['s_slug'];
                    $eve_sources[]     = $eve['s_source'];
                    $eve_contents[]     = $eve['s_content'];
                    $eve_card_date[] = date('j M', strtotime($eve['s_create_time']));
            }
    $eve = count($eve_headlines);


    // ---------- FOR VIDEO GALLARY--------------------------------
    
    $stmt11= $conn->prepare("SELECT * FROM t_videos order by pk_i_id  desc LIMIT 1");
    $stmt11->execute();
    $Video_name = array();
    $link = array();
    while ($videos = $stmt11->fetch(PDO::FETCH_ASSOC))
            {
                    $Video_name[]   = $videos['video_name'];
                    $link[]   = $videos['link'];
            }
    // ---------- FOR BANNERS--------------------------------

    $stmt13 = $conn->prepare("SELECT a.pk_i_id, a.Campaign_name ,a.link , b.s_source, b.fk_ads_id FROM t_ads as a , t_media_ads as b WHERE a.pk_i_id = b.fk_ads_id order by a.pk_i_id  desc LIMIT 3");
    $stmt13->execute();
    $images_ad = array();
    $links_ad = array();
    $Campaign_name = array();
    while ($videos = $stmt13->fetch(PDO::FETCH_ASSOC))
            {
                    $images_ad[]   = $videos['s_source'];
                    $links_ad[]   = $videos['link'];
                    $Campaign_name[] = $videos['Campaign_name'];
            } 



?>

<!DOCTYPE html>

<!--[if IE 7]>
<html class="ie ie7" lang="en-US">
<![endif]-->

<!--[if IE 8]>
<html class="ie ie8" lang="en-US">
<![endif]-->

<!--[if IE 9]>
<html class="ie ie9" lang="en-US">
<![endif]-->

<!--[if !(IE 7) | !(IE 8) | !(IE 9)  ]><!-->
<html lang="en-US">
<!--<![endif]-->

<head>
<title>texTIMZ | Textile Information Network</title>
<meta charset="UTF-8" />
<link rel="shortcut icon" href="images/favicon.png" title="Favicon"/>
<meta name="viewport" content="width=device-width" />

<link rel='stylesheet' id='magz-style-css'  href='style.css' type='text/css' media='all' />
<link rel='stylesheet' id='swipemenu-css'  href='css/swipemenu.css' type='text/css' media='all' />
<link rel='stylesheet' id='flexslider-css'  href='css/flexslider.css' type='text/css' media='all' />
<link rel='stylesheet' id='bootstrap-css'  href='css/bootstrap.css' type='text/css' media='all' />
<link rel='stylesheet' id='bootstrap-responsive-css'  href='css/bootstrap-responsive.css' type='text/css' media='all' />
<link rel='stylesheet' id='simplyscroll-css'  href='css/jquery.simplyscroll.css' type='text/css' media='all' />
<link rel='stylesheet' id='jPages-css'  href='css/jPages.css' type='text/css' media='all' />
<link rel='stylesheet' id='rating-css'  href='css/jquery.rating.css' type='text/css' media='all' />
<link rel='stylesheet' id='ie-styles-css'  href='css/ie.css' type='text/css' media='all' />
<link rel='stylesheet' id='Roboto-css'  href='http://fonts.googleapis.com/css?family=Roboto' type='text/css' media='all' />

<script type='text/javascript' src="js/jquery-1.10.2.min.js"></script>
<script type='text/javascript' src='js/html5.js'></script>
<script type='text/javascript' src='js/bootstrap.min.js'></script>
<script type='text/javascript' src='js/jquery.flexslider.js'></script>
<script type='text/javascript' src='js/jquery.flexslider.init.js'></script>
<script type='text/javascript' src='js/jquery.bxslider.js'></script>
<script type='text/javascript' src='js/jquery.bxslider.init.js'></script>
<script type='text/javascript' src='js/jquery.rating.js'></script>
<script type='text/javascript' src='js/jquery.idTabs.min.js'></script>
<script type='text/javascript' src='js/jquery.simplyscroll.js'></script>
<script type='text/javascript' src='js/fluidvids.min.js'></script>
<script type='text/javascript' src='js/jPages.js'></script>
<script type='text/javascript' src='js/jquery.sidr.min.js'></script>
<script type='text/javascript' src='js/jquery.touchSwipe.min.js'></script>
<script type='text/javascript' src='js/custom.js'></script>
<style type="text/css">
    .headline
    {
        width: auto;
        height: 50px;       
    }
    .heads:hover
{
  background-color: #B75252;
  cursor: pointer;
}

</style>

        <!-- END -->

</head>

<body>

<div id="page">

<header id="header" class="container">
        <div id="mast-head" style="margin-left: 40%">
            <div id="logo">
            <a target="_blank" href="index.php" title="Magazine" rel="home"><img src="images/logo.png" alt="Magazine" /></a>
            </div>
        </div>
 </header>

<header id="header" class="container">

                
        <nav class="navbar navbar-inverse clearfix nobot">    

            <!-- Responsive Navbar Part 2: Place all navbar contents you want collapsed withing .navbar-collapse.collapse. -->
            <div class="nav-collapse" id="swipe-menu-responsive">

            <ul class="nav" style="float: left;margin-left: 34%">
                                
                <li style="bottom: 0px;"><a href="index.php"><img src="images/home.png" alt="Magazine"></a></li>
                <li><a href="all_news.php?p=10">Highlights</a></li>
                <li><a href="all_events.php?p=4">Events</a></li>
                <!--
                TODO: jobs section
                <li><a href="contact.html">Jobs</a></li>
                -->
                </li>
                <li class="dropdown"><a href="##">Categories</a>
                    <ul class="sub-menu">
                    <?php for ($i=0; $i < $totalCats; $i++) { ?>
                        <li><a href="category.php?cat=<?php echo $categories[$i]; ?>"><?php echo $categories[$i]; ?></a></li>
                    <?php } ?>
                    </ul>
                </li>
               <!-- TODO: add pages  <li><a href="terms.html">Terms of Use</a></li>
                TODO: add pages  <li><a href="contact.html">Career</a></li>
              <li><a href="contact.html">Team</a></li> -->
                <li><a href="contact.html">Contact</a></li>
            </ul>
            </div><!--/.nav-collapse -->
            
        </nav><!-- /.navbar -->
            
    </header><!-- #masthead -->

    <div id="headline" class="container">
    <div class="row-fluid">
        <?php for ($i=0; $i < 2 ; $i++) { ?>
        <div class="span6" style="padding-bottom: 2em;">
                <a target="_blank" href="<?php echo $links_ad[$i]; ?>"> 
                    <img src="<?php echo $images_ad[$i]; ?>"> 
                </a>
        </div>
        <?php } ?>
        
    </div>
    </div>
    <div id="intr" class="container">
        <div class="row-fluid">
            <div class="brnews span9">
                <h3>Upcoming Events</h3>
                <ul id="scroller">
                <?php 
                for ($i = 0; $i < 3; $i++) { ?>
                    <li><p><a target="_blank" href="events.php?event=<?php echo $ev_tag[$i]; ?>" title="<?php echo $ev_event[$i];?>" rel="bookmark"><span class="title"><?php echo $ev_event[$i];?> </span> <?php echo $ev_card_date_start[$i]." to ".$ev_card_date_end[$i]." ".$ev_country[$i]; ?></a></p></li>
                    <?php }  ?>
                </ul>
            </div>
        
            <div class="search span3"><div class="offset1">
                <form method="post" id="searchform" action="#"><!--TODO: put search feature-->
                    <p><input type="text" value="Search here..." onfocus="if ( this.value == 'Search here...' ) { this.value = ''; }" onblur="if ( this.value == '' ) { this.value = 'Search here...'; }" name="s" id="s" />
                    <input type="submit" id="searchsubmit" value="Search" name="name" /></p>
                </form>
            </div>
        </div>
        </div>
    </div>

    <div id="content" class="container">

        <div id="main" class="row-fluid">
            <div id="main-left" class="span8">
                <div id="slider" class="clearfix">
                    <div id="slide-left" class="flexslider span8">
                        <ul class="slides">
                        <?php for ($i=0; $i < 4 ; $i++) {  ?>
                            <li data-thumb="<?php echo $featured_sources[$i]; ?>">
                                <a href="./news.php?id=<?php echo $featured_slugs[$i]; ?>" title="<?php echo $featured_headlines[$i]; ?>" rel="bookmark">
                                <img width="546" height="291" src="<?php echo $featured_sources[$i]; ?>" alt="<?php echo $featured_headlines[$i]; ?>" />
                                </a>
                            </li>
                             <?php } ?>
                        </ul>
                    </div>
                     <div class="span3" style="    background-color: red; height: 437px; width: 30%; display: inline-block; padding: 5px 5px 5px 5px;"></div>

                </div>
             <div style="background-color: white; padding: 5px 5px 0px 5px"> 
                <div id="home-top">
                    <h3 class="title" style="width: 90%; background-color: #376980" ><span class="heads">Events</span></h3>
                    <ul class="bxslider">
                    <?php for ($i=0; $i < $totalevents; $i++) {  ?>
                        <li><a class="image_thumb_zoom" href="events.php?event=<?php echo $ev_tags[$i]; ?>" title="<?php echo $ev_events[$i]; ?>" rel="bookmark">
                            <img width="225" height="136" src="<?php echo $ev_sources[$i]; ?>" alt="<?php echo $ev_events[$i]; ?>" />
                            </a>
                            <div style="height: 55px;">
                            <h4 class="post-title clearfix">
                                <img class="post-icon" alt="<?php echo $ev_events[$i]; ?>" src="images/image.png">
                                <a href="events.php?event=<?php echo $ev_tags[$i]; ?>" title="<?php echo $ev_events[$i]; ?>"><?php echo $ev_events[$i]; ?></a>
                            </h4>
                            </div>
                            <div class="meta clearfix">
                                <span class="date"><?php echo $ev_card_date_starts[$i]." to ".$ev_card_date_ends[$i]; ?></span> 
                                <hr>
                            </div>
                        </li>
                        <?php } ?>
                    </ul>
                </div>
                </div>
</div>
            <!-- #main-left -->


            <div id="sidebar" class="span4">

            <div id="tabwidget" class="widget tab-container"> 
                <ul id="tabnav" class="clearfix" style="background-color: #b75252; width: 100%"> 
                    <li><h3><a class="selected"><img src="images/view-white-bg.png" alt="Popular">Popular</a></h3></li>
                </ul> 

            <div id="tab-content">
            
            <div id="tab1" style="display: block;   background-color: white;">
                <ul id="itemContainer" class="recent-tab" style="height: 340px;">
                <?php for ($i=5; $i < 17 ; $i++) {  ?>
                    <li>
                        <a href="news.php?id=<?php echo $slugs[$i]; ?>"><img width="225" height="136" src="<?php echo $sources[$i]; ?>" class="thumb" alt="" /></a>
                        <h4 class="post-title"><a href="news.php?id=<?php echo $slugs[$i]; ?>" ><?php $small = $headlines[$i]; echo $small; ?></a></h4>
                        <p><?php $small = substr($contents[$i], 0, 60); echo $small; ?> ...</p>
                        <div class="clearfix"></div>                
                    </li>
                    <?php } ?>
                                
                    <script type="text/javascript">
                        jQuery(document).ready(function($){

                            /* initiate the plugin */
                            $("div.holder").jPages({
                            containerID  : "itemContainer",
                            perPage      : 3,
                            startPage    : 1,
                            startRange   : 1,
                            links          : "blank"
                            });
                        });     
                    </script>

                </ul>
                
                <div class="holder clearfix"></div>
                <div class="clear"></div>

            </div><!-- /#tab1 -->
 
            <div id="tab2" style="display: none;">  
                <ul id="itemContainer2" class="recent-tab">
                <?php for ($i=3; $i < 6 ; $i++) {  ?>
                    <li>
                        <a href="news.php?id=<?php echo $slugs[$i]; ?>"><img width="225" height="136" src="<?php echo $sources[$i]; ?>" class="thumb" alt="" /></a>
                        <h4 class="post-title"><a href="#"><?php $small = $headlines[$i]; echo $small; ?></a><</h4>
                        <p><?php $small = substr($contents[$i], 0, 60); echo $small; ?> ...</p>
                        <div class="clearfix"></div>    
                    </li>
                     <?php } ?>

                </ul>    
            </div><!-- /#tab2 --> 

            <div id="tab3" style="display: none; ">
            </div><!-- /#tab2 --> 
    
            </div><!-- /#tab-content -->

            </div><!-- /#tab-widget --> 

            <div style="background-color: white;padding: 5px 5px 0px 5px"> 
            <div class="video-box widget row-fluid">
                <h3 class="title" style="width: 99%;background-color: #376980;"><span style="background-color: #;color: #;">Videos Gallery</span></h3>        
                <iframe width="369" height="188" src="<?php echo $link[0]; ?>" frameborder="0" allowfullscreen></iframe>
                
            </div>
            </div>
            </div>
           
                        
        </div><!-- sidebar -->

        <div class="clearfix"  >
                    <div class="left span3 " style="background-color: white; padding: 10px 0px 0px 10px;">
                        <h3 class="title" style="width: 95%;background-color: #376980;"><a href="category.php?cat=Apparel" title="Apparel" ><span >Apparel</span></a></h3>
                        <div class="row-fluid"> 
                        <article class="post" style="height:550px">
                                <a href="news.php?id=<?php echo $a_slugs[0]; ?>" title="<?php echo $a_headlines[0]; ?>" rel="bookmark">
                                <img width="371" height="177" src="<?php echo $a_sources[0]; ?>" alt="" />
                                </a>
                                <div style="height: 50px; width: 100%; display: inline-block; position: relative;">
                                <h4 class="post-title">
                                <a href="news.php?id=<?php echo $a_slugs[0]; ?>" title="<?php echo $a_headlines[0]; ?>" rel="bookmark"><?php echo $a_headlines[0]; ?></a>
                                </div>
                                </h4>
                                <p style="text-align: justify;"><?php echo $a_contents[0]; ?></p>
                                <span class="date" style="float: right;"><b><?php echo $a_card_date[0]; ?></b></span>
                            </article>
                            <hr>
                            <article class="post" style="height: 350px">
                                <div class="entry clearfix">
                                    <a href="news.php?id=<?php echo $a_slugs[1]; ?>" title="<?php echo $a_headlines[1]; ?>" rel="bookmark">
                                    <img width="371" height="177" src="<?php echo $a_sources[1]; ?>" alt="" />
                                    <div style="height: 50px; width: 100%; display: inline-block; position: relative;">
                                    <h4 class="post-title"><?php echo $a_headlines[1]; ?></h4>
                                    </div>
                                    </a>
                                    <p style="text-align: justify;"><?php echo $a_contents[1]; ?></p>
                                    <div class="meta">
                                         <span class="date" style="float: right;"><b><?php echo $a_card_date[1]; ?></b></span>
                                </div>
                            </article>
                            <hr>

                            <div class="clearfix"></div>
                        </div>
                    </div>

                    <div class="right span3" style="background-color: white; padding: 10px 10px 10px 10px;">
                       <h3 class="title" style="width: 95%;background-color: #376980;"><a href="category.php?cat=Textile" title="Textile"><span>Textile</span></a></h3>
                            <div class="row-fluid">
                                <article class="post" style="height: 550px">
                                <a href="news.php?id=<?php echo $t_slugs[0]; ?>" title="<?php echo $t_headlines[0]; ?>" rel="bookmark">
                                <img width="371" height="177" src="<?php echo $t_sources[0]; ?>" alt="" />
                                </a>
                                <div style="height: 50px; width: 100%; display: inline-block; position: relative;">
                                <h4 class="post-title">
                                <a href="news.php?id=<?php echo $t_slugs[0]; ?>" title="<?php echo $t_headlines[0]; ?>" rel="bookmark"><?php echo $t_headlines[0]; ?></a>
                                </h4>
                                </div>
                               
                                <p style="text-align: justify;"><?php echo $t_contents[0]; ?></p>
                                 <span class="date" style="float: right;"><b><?php echo $t_card_date[0]; ?></b></span>
                            </article>
                            <hr>
                        <article class="post" style="height: 350px">
                                <div class="entry clearfix">
                                    <a href="news.php?id=<?php echo $t_slugs[1]; ?>" title="<?php echo $t_headlines[1]; ?>" rel="bookmark">
                                    <img width="371" height="177" src="<?php echo $t_sources[1]; ?>" alt="" />
                                    <div style="height: 50px; width: 100%; display: inline-block; position: relative;">
                                    <h4 class="post-title"><?php echo $t_headlines[1]; ?></h4>
                                    </div>
                                    </a>
                                    <p style="text-align: justify;"><?php echo $t_contents[1]; ?></p>
                                    <div class="meta">
                                        <span class="date" style="float: right;"><b><?php echo $t_card_date[1]; ?></b></span>
                                    </div>
                                </div>
                            </article>
                            <hr>

                                <div class="clearfix"></div>

                            </div>
                    </div>

                    <div class="right span3" style="background-color: white; padding: 10px 10px 10px 10px;">
                        <h3 class="title" style="width: 95%;background-color: #376980;"><a href="category.php?cat=Fashion" title="Fashion"><span>Fashion</span></a></h3>
                            <div class="row-fluid">
                                <article class="post" style="height: 550px">
                                <a href="news.php?id=<?php echo $f_slugs[0]; ?>" title="<?php echo $f_headlines[0]; ?>" rel="bookmark">
                                <img width="371" height="177" src="<?php echo $f_sources[0]; ?>" alt="" />
                                </a>
                                <div style="height: 50px; width: 100%; display: inline-block; position: relative;">
                                <h4 class="post-title">
                                <a href="news.php?id=<?php echo $f_slugs[0]; ?>" title="<?php echo $f_headlines[0]; ?>" rel="bookmark"><?php echo $f_headlines[0]; ?></a>
                                </h4>
                                </div>
                               
                                <p style="text-align: justify;"><?php echo $f_contents[0]; ?></p>
                                 <span class="date" style="float: right;"><b><?php echo $f_card_date[0]; ?></b></span>
                            </article>
                            <hr>
                        <article class="post" style="height: 350px">
                                <div class="entry clearfix">
                                    <a href="news.php?id=<?php echo $f_slugs[1]; ?>" title="<?php echo $f_headlines[1]; ?>" rel="bookmark">
                                    <img width="371" height="177" src="<?php echo $f_sources[1]; ?>" alt="" />
                                    <div style="height: 50px; width: 100%; display: inline-block; position: relative;">
                                    <h4 class="post-title"><?php echo $f_headlines[1]; ?></h4>
                                    </div>
                                    </a>
                                    <p style="text-align: justify;"><?php echo $f_contents[1]; ?></p>
                                    <div class="meta">
                                        <span class="date" style="float: right;"><b><?php echo $f_card_date[1]; ?></b></span>
                                    </div>
                                </div>
                            </article>
                            <hr>

                                <div class="clearfix"></div>

                            </div>
                    </div>

                    <div class="right span3" style="background-color: white; padding: 10px 10px 10px 10px;">
                        <h3 class="title" style="width: 95%;background-color: #376980;"><a href="category.php?cat=Corporate" title="Corporate"><span>Corporate</span></a></h3>
                            <div class="row-fluid">
                                <article class="post" style="height: 550px">
                                <a href="news.php?id=<?php echo $c_slugs[0]; ?>" title="<?php echo $c_headlines[0]; ?>" rel="bookmark">
                                <img width="371" height="177" src="<?php echo $c_sources[0]; ?>" alt="" />
                                </a>
                                <div style="height: 50px; width: 100%; display: inline-block; position: relative;">
                                <h4 class="post-title">
                                <a href="news.php?id=<?php echo $c_slugs[0]; ?>" title="<?php echo $c_headlines[0]; ?>" rel="bookmark"><?php echo $c_headlines[0]; ?></a>
                                </h4>
                                </div>
                               
                                <p style="text-align: justify;"><?php echo $c_contents[0]; ?></p>
                                 <span class="date" style="float: right;"><b><?php echo $c_card_date[0]; ?></b></span>
                            </article>
                            <hr>
                        <article class="post" style="height: 350px">
                                <div class="entry clearfix">
                                    <a href="news.php?id=<?php echo $c_slugs[1]; ?>" title="<?php echo $c_headlines[1]; ?>" rel="bookmark">
                                    <img width="371" height="177" src="<?php echo $c_sources[1]; ?>" alt="" />
                                    <div style="height: 50px; width: 100%; display: inline-block; position: relative;">
                                    <h4 class="post-title"><?php echo $c_headlines[1]; ?></h4>
                                    </div>
                                    </a>
                                    <p style="text-align: justify;"><?php echo $c_contents[1]; ?></p>
                                    <div class="meta">
                                        <span class="date" style="float: right;"><b><?php echo $c_card_date[1]; ?></b></span>
                                    </div>
                                </div>
                            </article>
                            <hr>

                                <div class="clearfix"></div>
                            </div>
                    </div>
                    </div>

                     <div style="margin-top: 1.9em; margin-bottom: 1.9em;">

                    <div class="clearfix"  >
                    <div class="left span3 " style="background-color: white; padding: 10px 0px 0px 10px;">
                        <h3 class="title" style="width: 95%;background-color: #376980;"><a href="category.php?cat=Technology And Innovation" title="Apparel" ><span >Technology And Innovation</span></a></h3>
                        <div class="row-fluid"> 
                        <article class="post" style="height:550px">
                                <a href="news.php?id=<?php echo $i_slugs[0]; ?>" title="<?php echo $i_headlines[0]; ?>" rel="bookmark">
                                <img width="371" height="177" src="<?php echo $i_sources[0]; ?>" alt="" />
                                </a>
                                <div style="height: 50px; width: 100%; display: inline-block; position: relative;">
                                <h4 class="post-title">
                                <a href="news.php?id=<?php echo $a_slugs[0]; ?>" title="<?php echo $i_headlines[0]; ?>" rel="bookmark"><?php echo $i_headlines[0]; ?></a>
                                </div>
                                </h4>
                                <p style="text-align: justify;"><?php echo $a_contents[0]; ?></p>
                                <span class="date" style="float: right;"><b><?php echo $i_card_date[0]; ?></b></span>
                            </article>
                            <hr>
                            <article class="post" style="height: 350px">
                                <div class="entry clearfix">
                                    <a href="news.php?id=<?php echo $a_slugs[1]; ?>" title="<?php echo $i_headlines[1]; ?>" rel="bookmark">
                                    <img width="371" height="177" src="<?php echo $i_sources[1]; ?>" alt="" />
                                    <div style="height: 50px; width: 100%; display: inline-block; position: relative;">
                                    <h4 class="post-title"><?php echo $i_headlines[1]; ?></h4>
                                    </div>
                                    </a>
                                    <p style="text-align: justify;"><?php echo $i_contents[1]; ?></p>
                                    <div class="meta">
                                         <span class="date" style="float: right;"><b><?php echo $i_card_date[1]; ?></b></span>
                                </div>
                            </article>
                            <hr>

                            <div class="clearfix"></div>
                        </div>
                    </div>

                    <div class="right span3" style="background-color: white; padding: 10px 10px 10px 10px;">
                       <h3 class="title" style="width: 95%;background-color: #376980;"><a href="category.php?cat=Events" title="Textile"><span>Events</span></a></h3>
                            <div class="row-fluid">
                                <article class="post" style="height: 550px">
                                <a href="news.php?id=<?php echo $t_slugs[0]; ?>" title="<?php echo $eve_headlines[0]; ?>" rel="bookmark">
                                <img width="371" height="177" src="<?php echo $eve_sources[0]; ?>" alt="" />
                                </a>
                                <div style="height: 50px; width: 100%; display: inline-block; position: relative;">
                                <h4 class="post-title">
                                <a href="news.php?id=<?php echo $eve_slugs[0]; ?>" title="<?php echo $eve_headlines[0]; ?>" rel="bookmark"><?php echo $eve_headlines[0]; ?></a>
                                </h4>
                                </div>
                               
                                <p style="text-align: justify;"><?php echo $eve_contents[0]; ?></p>
                                 <span class="date" style="float: right;"><b><?php echo $eve_card_date[0]; ?></b></span>
                            </article>
                            <hr>
                        <article class="post" style="height: 350px">
                                <div class="entry clearfix">
                                    <a href="news.php?id=<?php echo $eve_slugs[1]; ?>" title="<?php echo $eve_headlines[1]; ?>" rel="bookmark">
                                    <img width="371" height="177" src="<?php echo $eve_sources[1]; ?>" alt="" />
                                    <div style="height: 50px; width: 100%; display: inline-block; position: relative;">
                                    <h4 class="post-title"><?php echo $eve_headlines[1]; ?></h4>
                                    </div>
                                    </a>
                                    <p style="text-align: justify;"><?php echo $eve_contents[1]; ?></p>
                                    <div class="meta">
                                        <span class="date" style="float: right;"><b><?php echo $eve_card_date[1]; ?></b></span>
                                    </div>
                                </div>
                            </article>
                            <hr>

                                <div class="clearfix"></div>

                            </div>
                    </div>

                    <div class="right span3" style="background-color: white; padding: 10px 10px 10px 10px;">
                        <h3 class="title" style="width: 95%;background-color: #376980;"><a href="category.php?cat=Technical textile"><span>Technical textile</span></a></h3>
                            <div class="row-fluid">
                                <article class="post" style="height: 550px">
                                <a href="news.php?id=<?php echo $tt_slugs[0]; ?>" title="<?php echo $tt_headlines[0]; ?>" rel="bookmark">
                                <img width="371" height="177" src="<?php echo $tt_sources[0]; ?>" alt="" />
                                </a>
                                <div style="height: 50px; width: 100%; display: inline-block; position: relative;">
                                <h4 class="post-title">
                                <a href="news.php?id=<?php echo $tt_slugs[0]; ?>" title="<?php echo $tt_headlines[0]; ?>" rel="bookmark"><?php echo $tt_headlines[0]; ?></a>
                                </h4>
                                </div>
                               
                                <p style="text-align: justify;"><?php echo $tt_contents[0]; ?></p>
                                 <span class="date" style="float: right;"><b><?php echo $tt_card_date[0]; ?></b></span>
                            </article>
                            <hr>
                        <article class="post" style="height: 350px">
                                <div class="entry clearfix">
                                    <a href="news.php?id=<?php echo $tt_slugs[1]; ?>" title="<?php echo $tt_headlines[1]; ?>" rel="bookmark">
                                    <img width="371" height="177" src="<?php echo $tt_sources[1]; ?>" alt="" />
                                    <div style="height: 50px; width: 100%; display: inline-block; position: relative;">
                                    <h4 class="post-title"><?php echo $tt_headlines[1]; ?></h4>
                                    </div>
                                    </a>
                                    <p style="text-align: justify;"><?php echo $tt_contents[1]; ?></p>
                                    <div class="meta">
                                        <span class="date" style="float: right;"><b><?php echo $tt_card_date[1]; ?></b></span>
                                    </div>
                                </div>
                            </article>
                            <hr>

                                <div class="clearfix"></div>

                            </div>
                    </div>

                    <div class="right span3" style="background-color: white; padding: 10px 10px 10px 10px;">
                        <h3 class="title" style="width: 95%;background-color: #376980;"><a href="category.php?cat=Retail" title="Corporate"><span>Retail</span></a></h3>
                            <div class="row-fluid">
                                <article class="post" style="height: 550px">
                                <a href="news.php?id=<?php echo $r_slugs[0]; ?>" title="<?php echo $r_headlines[0]; ?>" rel="bookmark">
                                <img width="371" height="177" src="<?php echo $r_sources[0]; ?>" alt="" />
                                </a>
                                <div style="height: 50px; width: 100%; display: inline-block; position: relative;">
                                <h4 class="post-title">
                                <a href="news.php?id=<?php echo $r_slugs[0]; ?>" title="<?php echo $r_headlines[0]; ?>" rel="bookmark"><?php echo $r_headlines[0]; ?></a>
                                </h4>
                                </div>
                               
                                <p style="text-align: justify;"><?php echo $r_contents[0]; ?></p>
                                 <span class="date" style="float: right;"><b><?php echo $r_card_date[0]; ?></b></span>
                            </article>
                            <hr>
                        <article class="post" style="height: 350px">
                                <div class="entry clearfix">
                                    <a href="news.php?id=<?php echo $r_slugs[1]; ?>" title="<?php echo $r_headlines[1]; ?>" rel="bookmark">
                                    <img width="371" height="177" src="<?php echo $r_sources[1]; ?>" alt="" />
                                    <div style="height: 50px; width: 100%; display: inline-block; position: relative;">
                                    <h4 class="post-title"><?php echo $r_headlines[1]; ?></h4>
                                    </div>
                                    </a>
                                    <p style="text-align: justify;"><?php echo $r_contents[1]; ?></p>
                                    <div class="meta">
                                        <span class="date" style="float: right;"><b><?php echo $r_card_date[1]; ?></b></span>
                                    </div>
                                </div>
                            </article>
                            <hr>

                                <div class="clearfix"></div>
                            </div>
                            </div>

            </div>
        </div>
        <div class="clearfix"></div>

        <div id="gallery" style="background-color: white; padding: 5px 5px 5px 5px;">
            <h3 class="title"><a href="all_news.php?p=0"><span>All News Gallery</span></a></h3>
                <ul class="gallery">
                <?php for ($i=0; $i < 30 ; $i++) { ?>
                    <li>
                    <a class="image_thumb_zoom" href="news.php?id=<?php echo $slugs[$i]; ?>" title="<?php echo $headlines[$i]; ?>" rel="bookmark">
                    <img width="225" height="136" src="<?php echo $sources[$i]; ?>" alt="" />
                    </a>
                    <a href="#" title="<?php echo $headlines[$i]; ?>" rel="bookmark">
                    <div class="headline">
                    <h4 class="post-title clearfix"><?php  $small = $headlines[$i]; echo $small; ?></h4></a>
                    </div>
                    <div class="meta clearfix">
                        <span class="date"><?php echo $card_date[$i]; ?></span>
                    </div>
                    </li>
                    <?php } ?>
                </ul>
        

        </div><!-- #main -->

        </div><!-- #content -->

    <footer id="footer" class="row-fluid">
        <div id="footer-widgets" class="container">

            <div class="footer-widget span3 block3">
                <div class="widget">
                    <h3 class="title"><span>Tag Cloud</span></h3>
                    <div class="tagcloud">
                        <a href='#'>Yarn</a>
                        <a href='#'>Cotton</a>
                        <a href='#'>Home Textile</a>
                        <a href='category.php?cat=Institutional'>Institutional</a>
                        <a href='category.php?cat=Fashion'>Fashion</a>
                        <a href='#'>Machinery</a>
                        <a href='category.php?cat=Technical textile'>Technical Textile</a>
                        <a href='category.php?cat=Apparel'>Apparel</a>
                        <a href='category.php?cat=Textile'>Textile</a>
                    </div>
                </div>
            </div>
            
            <div class="footer-widget span3 block4">
                <div class="widget">
                    <h3 class="title"><span>Social Media</span></h3>
                        <div class="socmed clearfix">       
                            <ul>
                                <li>
                                    <a href="http://textimz.com/rss"><img src="images/rss-icon.png" alt=""></a>
                                </li>
                                <li>
                                    <a href="https://twitter.com/textimz"><img src="images/twitter-icon.png" alt=""></a>
                                </li>
                                <li>
                                    <a href="https://www.facebook.com/textimz"><img src="images/fb-icon.png" alt=""></a>
                                </li>
                            </ul>
                        </div>
                </div>
            </div>
            
            <div class="footer-widget span6 block5">
                <img class="footer-logo" src="images/logo.png" alt="texTIMZ">
                    <div class="footer-text">
                        <h4>About texTIMZ</h4>
                        <p>texTIMZ is a knowledge portal for textile industry, we provide news on the go.</p>
                    </div><div class="clearfix"></div>
            </div>

        </div><!-- footer-widgets -->

    
        <div id="site-info" class="container">
        
            <div id="footer-nav" class="fr">
                <ul class="menu">
                    <li><a href="index.php">Home</a></li>
                 <!-- TODO: add pages    <li><a href="terms.html">Blog</a></li> -->
                    <li><a href="contact.html">Contact</a></li>
                </ul>
            </div>

            <div id="credit" class="fl">
                <p>All Right Reserved by texTIMZ, 2017</p>
            </div>

        </div><!-- .site-info -->
        
    </footer>

</div><!-- #wrapper -->

</body>
</html>
