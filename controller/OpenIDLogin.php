<?php

namespace oat\taoOpenIDAuth\controller;
use oat\taoOpenIDAuth\model\LightOpenID;
use oat\taoOpenIDAuth\model\OpenIDUser;


/**
 * This controller is used to manage permission administration
 *
 * @package taoOpenIDAuth
 * @subpackage actions
 * @license GPL-2.0
 *
 */
class OpenIDLogin extends \tao_actions_CommonModule
{


    /**
     * constructor: initialize the service and the default data
     * @return  Items
     */
    public function __construct(){

        parent::__construct();

        //the service is initialized by default

    }
    /**
     * action to perform authwith open_ID
     */
    public function login()
    {
        try {
            # Change 'localhost' to your domain name.
            $openid = new LightOpenID('http://e-learning-22/');
            $openid_identfier="http://192.168.0.201:8080/Sayegh-OpenID-Provider/auth";
            if(!$openid->mode) {
                if(isset($openid_identfier)) {
                    $openid->identity = $openid_identfier;
                    # The following two lines request email, full name, and a nickname
                    # from the provider. Remove them if you don't need that data.
                    $openid->required = array('contact/email','namePerson');
                    $openid->optional = array("role");
                    header('Location: ' . $openid->authUrl());
                    die;
                }
                ?>
                WTF you should never reached here! XO
                <?php
            } elseif($openid->mode == 'cancel') {
                echo 'User has canceled authentication!';
            } else {
                $res=$openid->getAttributes();
                // [contact/email] => sara@syrianep.com [namePerson] => sara lakah
                $user=new OpenIDUser(new \core_kernel_classes_Resource("http://sep.com/".$res['contact/email']));
                $session = new \common_session_DefaultSession($user);
                \common_session_SessionManager::startSession($session);

                $this->redirect(_url('entry', 'Main',"tao"));
             //   echo 'User ' . ($openid->validate() ? $openid->identity . ' has ' : 'has not ') . 'logged in.';
              //  print_r($openid->getAttributes());
            }
        } catch(ErrorException $e) {
            echo $e->getMessage();
        }

    }

}
