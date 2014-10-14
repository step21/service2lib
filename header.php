<?php
echo <<<END
<!doctype html>
<html lang="en">
<head>
END;
echo '    <title>' . $configs['_subject'] . '</title>';
echo <<<END
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css">
END;
if ( $configs['_style'] )
    echo '<style>' . $configs['_style'] . "</style>\n";
?>
</head>
<body style="margin: 30px;">
<?php
if ( $configs['_header'] )
    echo $configs['_header'] . "\n";
if ( $configs['_banner'] )
    echo '<img src="' . $configs['_banner'] . '" ' . 
    'id="' . $configs['_banner'] . '" ' .
    'title="Banner" alt="Banner" />' . "\n";
if ( $configs['_subject'] )
    echo '    <h2>' . $configs['_subject'] . '</h2>' . "\n";

?>
