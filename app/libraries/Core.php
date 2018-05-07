<?php
  /*
   * App Core Class
   * Creates URL & loads core controller
   * URL FORMAT - /controller/method/params
   */
  class Core 
  {
      protected $currentController = 'Pages';
      protected $currentMethod = 'index';
      protected $parame = [];

      public function __construct()
      {
          //print_r($this->getUrl()); //列出url的／字串

          $url = $this->getUrl();

          // Look in controllers for first value 查看控制器的第一個值
          if(file_exists('../app/controllers/' . ucwords($url[0]). '.php'))
          {
              // If exists, set as controller
              $this->currentController = ucwords($url[0]);
              // Unset 0 Index
              unset($url[0]);
          }

          // Require the controller 自動引入控制器/會自動去controllers找class
          require_once '../app/controllers/'. $this->currentController . '.php';

          // Instantiate controllerclass 實體化控制器類
          $this->currentController = new $this->currentController;

          // Check for second part of url
          if(isset($url[1]))
          {
              // Check to see if method exists in controller
              if(method_exists($this->currentController, $url[1]))
              {
                  $this->currentMethod = $url[1];
                  // Unset 0 Index 記得要註銷
                  unset($url[1]);
              }
          }
          // echo $this->currentMethod; 測試

          // Get Params獲取參數
          $this->params = $url ? array_values($url) : [];

          // Call a callback with array of params使用params數組調用回調
          call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
          
      }

      public function getUrl() 
      {
          if(isset($_GET['url']))
          {
              $url = rtrim($_GET['url'], '/');
              $url = filter_var($url, FILTER_SANITIZE_URL);
              $url = explode('/', $url);
              return $url;

          }
          //echo $_GET['url']; //取得url的參數
      }
  }