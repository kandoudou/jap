<?php

namespace App\Facebook;

use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookRequest;
use Facebook\FacebookSession;

class FacebookConnect {

    private $appId;
    private $appSecret;

    /**
     * @param $appId Facebook Application ID
     * @param $appSecret Facebook Application secret
     */
    function __construct($appId, $appSecret){
        $this->appId = $appId;
        $this->appSecret = $appSecret;
    }

    /**
     * @param $redirect_url
     * @return string|Facebook\GraphUser Login URL or GraphUser
     */
    function connect($redirect_url){
        FacebookSession::setDefaultApplication($this->appId, $this->appSecret);
        $helper = new FacebookRedirectLoginHelper($redirect_url);
        if(isset($_SESSION) && isset($_SESSION['fb_token'])){
            $session = new FacebookSession($_SESSION['fb_token']);
        }else{
            $session = $helper->getSessionFromRedirect();
        }
        if($session){
            try{
                $_SESSION['fb_token'] = $session->getToken();
                $request = new FacebookRequest($session, 'GET', '/me');
                $profile = $request->execute()->getGraphObject('Facebook\GraphUser');
                if($profile->getEmail() === null){
                    throw new \Exception('L\'email n\'est pas disponible');
                }
                return $profile;
            }catch (\Exception $e){
                unset($_SESSION['fb_token']);
                return $helper->getReRequestUrl(['email']);
            }
        }else{
            return $helper->getLoginUrl(['email']);
        }
    }

}