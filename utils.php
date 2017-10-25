<?php
function buildHTML($page_body)
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
    return $body;
}
?>
