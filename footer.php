<?php
if ( _NUM_ALLOWED_ACTIONS_ > $actions_printed )
{
    $next_action = '';
    if ( is_array( $configs['_action'] ) )
        $next_action = array_shift($configs['_action']);
    else if ( !empty( $configs['_action'] &&
            $configs['_action'] != '#' &&
            $configs['_action'] != '%23' )  )
    {
        $next_action = $configs['_action'];
    }

    if ( !empty( $next_action ) )
    {
        $query_string = http_build_query(array_merge($configs,$inputs));
        echo '<a href="' . $next_action . '?' . $query_string . 
             '" class="btn btn-info">' . 
             ( $configs['_next'] ? $configs['_next'] : 'Next' ) . "</a>\n";
    }
}

if ( $configs['_footer'] )
{
    echo $configs['_footer'] . "\n";
}
?>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <script>window.jQuery || document.write('<script src="/lib/js/jquery-1.11.1.min.js">\x3C/script>')</script>

    <!-- <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script> -->
    <script src="/lib/bootstrap-3.2.0/js/bootstrap.min.js"></script> 
    <script src="/lib/js/prettify.js"></script>
    <script src="/lib/js/service.js"></script>
</body>
</html>


