<?php

define('CSVFILE', 'db/updates.csv');


function get_file_csv ( $file = _CSVFILE_ )
{
    if ( $digfile == FALSE )
        return FALSE;
    $file_array = array();
    $row = 1;
    if (($handle = fopen($file, "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $file_array[] = $data;
        }
        fclose($handle);

        // print_r($file_array);
        return $file_array;
    } else {
        log("Can't open the file handle.");
        return FALSE;
    }
}

function save_file_csv ($digs, $file = CSVFILE, 
                        $rw_flag = 'w')
{
/*
$list = array (
    array('aaa', 'bbb', 'ccc', 'dddd'),
        array('123', '456', '789'),
            array('"aaa"', '"bbb"')
            );
*/

    $fp = fopen($file_path, $rw_flag);

    foreach ($updates as $fields) {
        fputcsv($fp, $fields);
    }

    fclose($fp);
}


?>
