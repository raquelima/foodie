<?php

/**
 * Configuration file for CSRF Protector
 * Necessary configurations are (library would throw exception otherwise)
 * ---- failedAuthAction
 * ---- jsUrl
 * ---- tokenLength
 */
return array(
    "CSRFP_TOKEN" => "",
    "failedAuthAction" => array(
        "GET" => 2,
        "POST" => 2
    ),
    "errorRedirectionPage" => "http://localhost/foodie/fehlerseite.php?err=403&msg=Access denied",
    "customErrorMessage" => "",
    "jsUrl" => "http://localhost/foodie/vendor/owasp/csrf-protector-php/js/csrfprotector.js",
    "tokenLength" => 10,
    "cookieConfig" => array(
        "path" => '',
        "domain" => '',
        "secure" => false,
        "expire" => '900',
    ),
    "disabledJavascriptMessage" => "This site attempts to protect users against <a href=\"https://www.owasp.org/index.php/Cross-Site_Request_Forgery_%28CSRF%29\">
        Cross-Site Request Forgeries </a> attacks. In order to do so, you must have JavaScript enabled in your web browser otherwise this site will fail to work correctly for you.
         See details of your web browser for how to enable JavaScript.",
    "verifyGetFor" => array()
);
