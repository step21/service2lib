<?php
date_default_timezone_set('UTC');

function is_email ($email)
{
    return filter_var($email, FILTER_VALIDATE_EMAIL) && 
        preg_match('/@.+\./', $email);
}

function is_url ($url )
{
    return filter_var($url, FILTER_VALIDATE_URL);
}


$configs = [
    "_from"         =>  '',
    "_replyto"      =>  '',
    "_next"         =>  '',
    "_footer"       =>  '',
    "_id"           =>  '',
    "_time"         =>  '', 
    "_subject"      =>  'Generic Form',
    /* "_cc"           =>  '', */
    "_success"      =>  'Thanks for submitting your form.',
    "_body"         =>  'Please fill out the following form.',
    "_submit"       =>  'Submit',
    "_link"         =>  '',
    "_linkname"     =>  '',
    /* "_action"       =>  'http://service.localhost/query2email/' */
    "_action"       =>  '#'
];

$requests     = $_REQUEST;
$input_errors = $configs;
foreach ($input_errors as $key => $val)
    $input_errors[$key] = '';

$required_configs = [
    /* "_from", */
    "_replyto"
];

$inputs = array();

function get_generic_error ($key, $value, $msg)
{
    return "<p>ERROR: The $key is set to $value. $msg<p>";
}

foreach($requests as $key => $val)
{
    // unclear if needed
    // $val = urldecode($val);
    switch($key)
    {
        case '_replyto':
            if ( is_email($val) )
                $configs[$key] = $val;
            else
                $input_errors[$key] = 
                    get_generic_error($key,$val,"Its not a valid e-mail address.");
            unset($requests[$key]);
            break;
        case '_next':
            if ( is_url($val) )
                $configs[$key] = $val;
            else
                $input_errors[$key] =
                    get_generic_error($key, $val, "Its not a valid url address.");
            unset($requests[$key]);
            break;
        case '_footer':
        case '_id':
        case '_time':
        case '_subject':
        case '_success':
        case '_body':
        case '_submit':
        case '_link':
        case '_linkname':
        case '_action':
            $configs[$key] = $val;
            unset($requests[$key]);
            break;
        default:
            // default it to take anything else and use as a field
            if ( $key ) 
            {
                /*
                if ( empty($val) )
                    $inputs[$key] = ucfirst($key);
                else
                    */
                $inputs[$key] = $val;
            }
    }
}

if ( empty($_REQUEST) || count($inputs) == 0 )
{
    echo "<h2>Nothing to see...@TODO add docs here\n</h2>";
    exit;
}

$requirements_met = true;
foreach ($required_configs as $config)
{
    if ( empty($configs[$config]))
    {
        $input_errors[$config] = 
            get_generic_error($config,'\'\'',"The parameter is empty.");
        $requirements_met = false;
    }
}




?>
