<?php
echo <<<END
<!doctype html>
<html lang="en">
<head>
END;
echo '    <title>' . $configs['_subject'] . '</title>';
echo <<<END
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css">
</head>

<body style="margin: 30px;">

END;
echo '    <h2>' . $configs['_subject'] . '</h2>' . "\n";
?>
