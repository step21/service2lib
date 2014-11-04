<?php
date_default_timezone_set('UTC');

include_once 'utils.php';

$configs = array(
    "_from"         =>  '',
    "_replyto"      =>  '',
    "_next"         =>  '',
    "_header"       =>  '',
    "_footer"       =>  '',
    "_id"           =>  'default',
    "_style"        =>  '',
    "_banner"       =>  '',
    "_time"         =>  '', 
    "_subject"      =>  '',
    /* "_subject"      =>  'Generic Form', */
    /* "_cc"           =>  '', */
    "_success"      =>  'Thanks for submitting your form.',
    "_body"         =>  'Please fill out the following form.',
    "_submit"       =>  'Submit',
    "_link"         =>  '',
    "_linkname"     =>  '',
    /* "_action"       =>  'http://service.localhost/query2email/' */
    "_action"       =>  '#',
    "_u2s"          => 'http://service.fabricatorz.com/u2s'
);

$requests     = $_REQUEST;
$input_errors = $configs;
foreach ($input_errors as $key => $val)
    $input_errors[$key] = '';


// $num_allowed_actions = 1;
define('_NUM_ALLOWED_ACTIONS_', 1);
// FOR NOW ONLY ALLOWING ONE ACTION TO BE PRINTED ON PAGE
$actions_printed = 0;

$required_configs = array(
    /* "_from", */
    "_replyto"
);

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
        case '_from':
        case '_next':
            /*
            if ( is_url($val) )
                $configs[$key] = $val;
            else
                $input_errors[$key] =
                    get_generic_error($key, $val, "Its not a valid url address.");
            unset($requests[$key]);
            break;
            */
        case '_style':
        case '_banner':
        case '_header':
        case '_footer':
        case '_ip':
        case '_id':
        case '_time':
        case '_subject':
        case '_success':
        case '_body':
        case '_submit':
        case '_link':
        case '_linkname':
        case '_u2s':
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

// tricky,because if we want to view our list, we need to pass something
if ( empty($_REQUEST) || count($inputs) == 0 && !isset($_REQUEST['_id']) )
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

// @TODO clean up these temporary variables, and just use global array
$date_style = 'Y-m-d h:i:s A';
$configs['_ip'] = $_SERVER["REMOTE_ADDR"];;
$now = '';
if ( empty($configs['_time']) )
    $now = time();
else
    $now = $configs['_time'];


?>
