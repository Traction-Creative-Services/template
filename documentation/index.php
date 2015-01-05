<!DOCTYPE html>
    <html>
        <head>
            <title>TC Framework Documentation</title>
            <!-- Latest compiled and minified CSS -->
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
            <link href='http://fonts.googleapis.com/css?family=Oxygen+Mono' rel='stylesheet' type='text/css'>
            <link rel="stylesheet" href="assets/style.css" />
        </head>
        <body>
            <div class="sidebar">
                <ul>
                    <li><a href="#cover">Cover Page</a></li>
                    <li><a href="#third-party">Third Party Resources</a></li>
                    <li><a href="#search">Search Driver</a></li>
                    <li><a href="#keen">Keen Data Tracker</a></li>
                </ul>
                <div id="license">
                    <a rel="license" href="http://creativecommons.org/licenses/by-sa/4.0/"><img alt="Creative Commons License" style="border-width:0" src="https://i.creativecommons.org/l/by-sa/4.0/88x31.png" /></a><br /><span xmlns:dct="http://purl.org/dc/terms/" property="dct:title">Traction Website Framework</span> by <a xmlns:cc="http://creativecommons.org/ns#" href="http://traction.media" property="cc:attributionName" rel="cc:attributionURL">Traction Creative Services</a> is licensed under a <a rel="license" href="http://creativecommons.org/licenses/by-sa/4.0/">Creative Commons Attribution-ShareAlike 4.0 International License</a>.
                </div>
            </div>
            <div class="docs">
                <?php
                //this is where we bring it all together
                include('pages/cover_page.html');
                include('pages/third_party.html');
                include('pages/search_driver.html');
                include('pages/keen.html');
                ?>
            </div>
            <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
            <!-- Latest compiled and minified JavaScript -->
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
        </body>
    </html>