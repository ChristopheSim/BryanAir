<?php
echo <<<EOS
<!DOCTYPE html>
<html>
EOS;
include "templates/head.html";

echo "<body>";

include "templates/header.html";
include "templates/home.html";
include "templates/footer.html";

echo <<<EOS
    </body>
</html>
EOS;
