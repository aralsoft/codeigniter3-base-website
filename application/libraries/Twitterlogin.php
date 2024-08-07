<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once __DIR__ . "/twitteroauth/twitteroauth.php";

/**
 * Codeigniter TwitterOAuth library wrapper
 */
class Twitterlogin 
{
    public $CI;
    private $twitterOauth;
    private $config = array();

    function __construct() 
    {
        $this->CI = & get_instance();
        
        $this->config = array(
            'API_KEY' => 'NqHHoVbLgzKQdr8wbb9cR0DSg',
            'API_SECRET' => 'Ta5SvAMWJvt68wUHN7c0i9KchQn8phkSkQyZxsy8W2W0U3QJH4',
            'OAUTH_KEY' => '1043458412930129921-HhHWfKvEfrXNrSodYzGaT86Z5mzIsw',
            'OAUTH_SECRET' => '92QwnvIxUjgy8wGijniDs769eaS9O8PHjliB1ReZk4snm',
            'OAUTH_REDIRECT'=>'http://block.bet/account/twitter/cb'
        );

        //Initialise twitter oauth library
        $this->twitterOauth = new TwitterOAuth($this->config['API_KEY'],$this->config['API_SECRET']);
        
    }
    /**
     * Gets request token and saves it to session and redirects to authorise url
     * @param string $callbackUrl 
     */
    function getRequestToken($callbackUrl = '')
    {
        //If callback url not given as parameter use the value that defined in config
        if(!$callbackUrl)
        {
            $callbackUrl = $this->config['OAUTH_REDIRECT'];
        }

        //Get request token
        $requestToken = $this->twitterOauth->getRequestToken($callbackUrl);

        //Save request token in session to be able to use after callback redirect
        $this->CI->session->set_userdata(array('twitter_auth'=>$requestToken));
        
        switch ($this->twitterOauth->http_code) 
        {
            case 200:
                $url = $this->twitterOauth->getAuthorizeURL($requestToken['oauth_token']);
                redirect($url);
                break;
            
            default:
                show_error('Could not connect to Twitter, please try again later.', 500);
        }
    }
    /**
     * Gets access token data from twitter by using request tokens which are saved in 
     * session
     * @return Array 
     */
    function getAccessToken()
    {
        //After callback redirect
        $twitter_auth = $this->CI->session->userdata('twitter_auth');

        //If auth token is old redirect to twitter login to get new one
        if (isset($_REQUEST['oauth_token']) && $twitter_auth['oauth_token'] !== $_REQUEST['oauth_token']) 
        {
            redirect('/login/twitter/');
        }
        //Reinitialize twitter oauth with request token
        $this->twitterOauth = new TwitterOAuth($this->config['API_KEY'],$this->config['API_SECRET'], $twitter_auth['oauth_token'], $twitter_auth['oauth_token_secret']);
        //Get and return access token data
        $access_token = $this->twitterOauth->getAccessToken($_REQUEST['oauth_verifier']);

        return $access_token;
    }
}

?>
