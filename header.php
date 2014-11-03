<?php
echo <<<END
<!doctype html>
<html lang="en">
<head>

END;
echo '    <title>' . $configs['_subject'] . '</title>' . "\n";
/**
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css">
 */
echo <<<END
    <link href="/lib/bootstrap-3.2.0/css/bootstrap.min.css" rel="stylesheet" />
    <link href="/lib/css/prettify.css" rel="stylesheet" />
    <link href="/lib/css/style.css" rel="stylesheet" />
END;
if ( $configs['_style'] )
    echo '<style>' . $configs['_style'] . "</style>\n";
?>
</head>
<body>
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
