<?php
//DB indentifier
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "BryanAir";

function buildHTML($page_body, $tags = null)
{
    $body = <<<EOS
    <!DOCTYPE html>
    <html>
EOS;

    $body .= file_get_contents ("templates/head.html");

    $body .= "<body>";

    $body .= file_get_contents ("templates/header.html");
    $body .= file_get_contents (sprintf("templates/%s.html", $page_body));
    $body .= file_get_contents ("templates/footer.html");

    $body .= <<<EOS
        </body>
    </html>
EOS;

    if($tags == null) 
    {
        return $body;
    }
    else
    {
        return replaceTags(buildHTML($page_body),$tags);
    }
}



function replaceTags($content, $tags)
{
  
    $pattern = array_map(function($pat){
        return '/\$' . $pat . '\$/';
    },array_keys($tags));     
    $content = preg_replace($pattern, $tags, $content);
    return  $content;
}
?>
