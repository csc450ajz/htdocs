<?php 
    /*
    This page checks that a user is logged in and
    either allows them to continue the session or 
    kicks them back to the login page.

    Developer: Please require_once() this on any page 
    requiring a user to be logged in. Then, call the 
    particular function that is needed for the page.
    */

    /* 
    ---------------
    checkLogin()
    ---------------
    - Checks if user is logged in. 
    - Returns true if logged in, false if not logged in.
    NOTE: This only checks that a user is logged in,
    not what type of user they are
    */
    function checkLogin() {
        if (isset($_SESSION['type'])) {
            return true;
        } else {
            return false;
        }
    }

    /* 
    ---------------
    checkAdmin()
    ---------------
    - Checks if user is logged in. 
    - Checks if user is admin type.
    - Returns true if logged in and user type is admin, false if not both.
    */
    function checkAdmin() {
        if (checkLogin() && $_SESSION['type'] = "admin") {
            return true;
        } else {
            return false;
        }
    }

    /* 
    ---------------
    checkClient()
    ---------------
    - Checks if user is logged in. 
    - Checks if user is client type.
    - Returns true if logged in and user type is type, false if not both.
    */
    function checkClient() {
        if (checkLogin() && $_SESSION['type'] = "client") {
            return true;
        } else {
            return false;
        }
    }

?>