<?php

/** 
 * This file needs file.php included before use.
 */

function get_updates ( $dbfile = 'db/default.csv' )
{
   return get_file_csv( $dbfile ); 
}

function get_updates_table ( $updates, $headers = '', $print_headers = true )
{
    global $date_style;
    
    // assume headers is empty
    if ( ! is_array($updates) )
        return false;

    $buffer = '';
    $updates = array_reverse($updates);

    if ( $print_headers && count($headers) > 0 ) 
    {
        $buffer .= '<tr style="font-weight: bold">' . "\n";
        foreach ($headers as $heading )
        {
            if ( $heading == '_ip' )
                continue;
            // hacky fix to strip current input type selector
            if ( '_t' == substr( $heading, -2) )
                $heading = substr( $heading, 0, -2);
            $heading = 
                ucwords(strtr($heading, array('-' => ' ', '_' => '') ));

            $buffer .= '<td>' . $heading . '</td>' . "\n";
        }
    }

    foreach ( $updates as $up )
    {
        $ct = 0;
        $buffer .= '<tr>';
        foreach ( $up as $u )
        {
            if ( isset($headers[$ct]) && $headers[$ct] == '_time' )
                $u = date($date_style, $u);
            // if (strpos($headers[$ct],'email') !== false)
            if ( is_email($u) )
                $u = '<a href="mailto:' . $u . '" title="Email ' .$u. '">' . 
                       $u . '</a>';
            // if ( $headers[$ct] == 'file' )
            if ( is_url($u) )
                $u = '<a href="' . $u . '" title="File ' . $u . '">' . 
                       $u . '</a>';
            if ( isset($headers[$ct]) && $headers[$ct] == '_ip' )
            {
                $ct++;
                continue;
            }
            $buffer .= '<td>' . $u . '</td>' . "\n";
            $ct++;
        }
        $buffer .= '</tr>';
    }
    return $buffer;
}

?>
