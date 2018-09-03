<?php
    // Load Config
    require_once 'config/config.php';

    // Load Helpers
    require_once 'helpers/url_helper.php';
    require_once 'helpers/session_helper.php';

    // Autoload Core Libraries
    // 類別名和文件名是一樣的所以會以類名去Libraries找應對應的.php檔
    spl_autoload_register(function($className)
    {
        require_once 'libraries/' .$className . '.php';

    });