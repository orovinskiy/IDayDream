<?php

$thisPage = basename($_SERVER['PHP_SELF']); // nav.php
$navIndex = "";

if ($thisPage == "dreamers.php" || $thisPage == "volunteers.php") {
    $navIndex = "<li class='nav-item'>
                        <a class='nav-link nav' href=''>|</a>
                    </li>
                    <li class='nav-item'>
                        <a class='nav-link nav text-primary' href='index.php'>Links</a>
                    </li>";
};

// Display the nav bar
echo "<nav class='navbar navbar-light navbar-expand-md shadow-none'>
            <button class='navbar-toggler' type='button' data-toggle='collapse' data-target='#navbarSupportedContent' aria-controls='navbarSupportedContent' aria-expanded='false' aria-label='Toggle navigation'>
                <span class='navbar-toggler-icon'></span>
            </button>
            <div class='collapse navbar-collapse' id='navbarSupportedContent'>
                <ul class='nav navbar-nav mr-auto'>
                    <li class='nav-item'>
                        <a class='nav-link nav navbar-right text-primary' href='logout.php'>Log out</a>
                    </li>
                    $navIndex
                </ul>
            </div>
        </nav>";