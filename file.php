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

// function parse_php_ini already exists and is fast in php

function write_php_ini($array, $file, $writeflag = 'w')
{
    // var_dump($array);
    // var_dump($file);
    $res = array();
    foreach($array as $key => $val)
    {
        if(is_array($val))
        {
            $res[] = "[$key]";
            foreach($val as $skey => $sval) 
                $res[] = "$skey = ".(is_numeric($sval) ? $sval : '"'.$sval.'"');
        }
        else 
            $res[] = "$key = ".(is_numeric($val) ? $val : '"'.$val.'"');
    }
    return safe_file_write($file, implode("\r\n", $res), $writeflag);
}


function safe_file_write($fileName, $dataToSave, $writeflag = 'w')
{   
    if ($fp = fopen($fileName, $writeflag))
    {
        $startTime = microtime();
        do
        {            
            $canWrite = flock($fp, LOCK_EX);
           // If lock not obtained sleep for 0 - 100 milliseconds, 
           // to avoid collision and CPU load
            if(!$canWrite) usleep(round(rand(0, 100)*1000));
        } 
        while ((!$canWrite)and((microtime()-$startTime) < 1000));

        // file was locked so now we can store information
        if ($canWrite)
        {
            fwrite($fp, $dataToSave);
            flock($fp, LOCK_UN);
        }
        fclose($fp);
    } else 
    {
        return false;
    }
    return true;
}

function get_counter ($ctfile)
{

    $fp = fopen( $ctfile,"r"); // open it for READING ("r")
    $counter = fread($fp, filesize($ctfile) ); // read in value
    fclose( $fp ); // close it whilst we work
    if (empty($counter))
        $counter = 0;
    ++$counter; // increase the counter by one
    // echo "$counter hits to this page"; // print out the new value
    // echo '<br /><br />';

    $status = safe_file_write($ctfile, $counter);
    if (FALSE == $status)
        return FALSE;
    else
        return $counter;


}




?>
