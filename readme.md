# What Template Am I Using #

## Add your own panels ##

I've already provided several panels that I think provide lots of useful information.
But, if you don't see what you're looking for, its easy to add your own panels.

1. Create a class that extends `WTAIU_Panel`. Take a look at [inc/core-panels.php](inc/core-panels.php) for examples.
1. Add it to the sidebar with the `wtaiu_setup_panels` action. See [`setup_wtaiu_panels()`](what-template-am-i-using.php#L327) for example.

## Filters ##

### Handle text ###

```php
add_filter('wtaiu_handle_text', function( $text ) {
    return 'Your Custom Text Here';
} );
```

### Show/hide panels ###

```php
function wtaiu_can_show( $can_show, WTAIU_Panel $panel ) {
    if ( is_a( $panel, 'WTAIU_Theme_Panel') )
        return false;
    return $can_show;
}
add_filter('wtaiu_panel_can_show', 'wtaiu_can_show', 10, 2 );
```

### Public IP address ###

To find the public IP address of your server, a request is made to an external website that echos back the IP.

The default IP finding site is [ip.phplug.in](http://ip.phplug.in/). If you don't want to use my IP finding site, you can easily change the URL that is used.

```php
add_filter('wtaiu_find_public_ip_url', function( $url ) {
    return 'http://example.com/';
} );
```

If you'd like to host your own IP finding site, the same script that runs ip.phplug.in is included in [what-is-my-ip.php](what-is-my-ip.php).
