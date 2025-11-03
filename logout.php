<?php
session_cache_expire(30);
session_start();

// Clear and destroy session
session_unset();
session_destroy();
session_write_close();
?>
<html>
    <head>
        <meta HTTP-EQUIV="REFRESH" content="2; url=index.php">
        <?php require('universal.inc') ?>
        <title>Logging Out</title>
    </head>
    <body>
        <nav>
            <span id="nav-top">
                <span class="logo">
                    <img src="images/whiskeyLogo.png">
                        <span id="vms-logo"> Whiskey Valor Foundation </span>
                        </span>
                    <img id="menu-toggle" src="images/menu.png">
                </span>
            </span>
        </nav>
        <main>
            <p class="happy-toast centered">You have been logged out.</p>
        </main>
    </body>
</html>
