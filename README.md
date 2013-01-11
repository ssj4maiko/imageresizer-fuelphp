Image Resizer Controller for FuelPHP
====================


    Image Resizer for Fuel PHP
    by: Maiko Gabriel Kinzel Engelke
    date: 2013-11-01



    Usage:
        echo \Uri::base().'images/<argument>/<path/to.file>';
        Ex: http://localhost/site/public/images/h500/img/layout/logo.png


    Arguments:
        Height: h<numeric value>
            ex: h200. h530, h1024;
        Width: w<numeric value>
            ex: w240. w480, w720;


    Default variables:
        $base_path = 'assets/';
        $cache_path = 'img/cache/';
        Which will create images at site/public/assets/img/cache/<size>/<path/to/file.jpg>
                                        (It is fixed for jpg, but it's not hard to change it)




    Installation
        Just put the controller in the controller folder and that's it, no need to create folders or anything else.
        
        If necessary to change the base path, just keep in mind that the root is always your public folder (in case you are using an .htaccess to hide it).





    Features:
        Cache for all images identified by a folder using the argument;
        
        The resize limit is the original size. It won't scale up, since that's unnecessary (Will still cache, though).
        

                
    Problems:
        Recommended for smaller sites with a smaller need for images (bigger sites could get full too easily if abused).