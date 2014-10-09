<?php


function get_file_csv ( $file )
{
    if ( ! is_readable($file) )
    {
        log("File $file is not readable");
        return FALSE;
    }
    $file_array = array();
    $row = 1;
    if (($handle = fopen($file, "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $file_array[] = $data;
        }
        fclose($handle);

        return $file_array;
    } else {
        log("Can't open the file handle $file.");
        return FALSE;
    }
    return true;
}

function save_file_csv ($datalist, $file, 
                        $rw_flag = 'w')
{
/*
$list = 
    array (
        array('aaa', 'bbb', 'ccc', 'dddd'),
        array('123', '456', '789'),
        array('"aaa"', '"bbb"')
    );
*/
    $fp = fopen($file, $rw_flag);

    if ( false == $fp )
        return false;

    foreach ($datalist as $fields) 
    {
        fputcsv($fp, $fields);
    }

    fclose($fp);
    return true;
}


?>
