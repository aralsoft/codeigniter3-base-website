<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include_once BASEDIRECTORY.'/vendor/autoload.php';
use GeoIp2\WebService\Client;

// Base class for all controllers
class MY_Controller extends CI_Controller
{
    // Initialise class variables
    public $subDir = '';
    public $controller = '';
    public $method = '';
    public $previousSubDir = '';
    public $previousController = '';
    public $previousMethod = '';
    public $previousUrlParameters = '';
    public $cron = FALSE;
    public $lockFile = FALSE;
    public $cronLogFP;
    public $viewData = array();
    public $goBackLink = "/";
    public $countryCode = '';
    public $state = '';
    public $city = '';
    public $postCode = '';
    public $latitude = 0;
    public $longitude = 0;
    public $accuracy_radius = 0;
    public $isLive = FALSE;
    public $isDefaultController = FALSE;
    public $subDirectories = array('admin');
    public $defaultController = 'welcome';
    public $inputParameters = array();
    public $ignoredIPAddresses = array('0.0.0.0', '::1', '127.0.0.1');
    public $publicMethods = array(
        'welcome' => array(),
        'account' => array('index', 'register', 'forgot_password', 'forgot_password_final', 'email_verification_final'),
        'support' => array()
    );

    public $dataControllers = array('ajax', 'api');

    public $autoLoginMethods = array('account' => array('unsubscribe'));

    public $languageNamesByCountry = array(
        'ES' => 'spanish',
        'MX' => 'spanish',
        'CO' => 'spanish',
        'AR' => 'spanish',
        'PE' => 'spanish',
        'CL' => 'spanish',
        'EC' => 'spanish',
        'FR' => 'french',
        'PT' => 'portuguese',
        'BR' => 'portuguese',
        'DE' => 'german',
        'IT' => 'italian',
        'PL' => 'polish',
        'RU' => 'russian',
        'CN' => 'chinese',
        'JP' => 'japanese',
        'KR' => 'korean',
        'TH' => 'thai',
        'IN' => 'hindi',
        'TR' => 'turkish',
        'GR' => 'greek',
        'DK' => 'danish',
        'NL' => 'dutch',
        'NO' => 'norwegian',
        'SE' => 'swedish',
    );

    // Initial class function
    public function __construct($cron = false, $lockFile = false)
    {
        parent::__construct();

        $this->load->driver('cache', array('adapter' => 'file'));
        $this->load->library('user');

        $this->cron = $cron;
        $this->lockFile = $lockFile;
        $this->isLive = $this->isLive();

        if ($this->cron)
        {
            if ($this->isLocked() || !$this->lock())
            {
                $this->processError('Cron script locked or unable to lock.');
                exit;
            }
        }
        else
        {
            $this->setNavigation();
            $this->setUserLog();
            $this->setLanguage();
            $this->setParameters();

            if (!in_array($this->controller, $this->dataControllers))
            {
                $this->load->library('messages');

                $this->checkRoute();
                $this->setView();
            }
        }

    }

    public function setNavigation()
    {
        // Get current URL data
        $this->controller = $this->uri->segment(1);
        $this->method = $this->uri->segment(2);

        if (in_array($this->controller, $this->subDirectories)) {
            $this->subDir = $this->uri->segment(1);
            $this->controller = $this->uri->segment(2);
            $this->method = $this->uri->segment(3);
        }

        if (!$this->controller) {
            $this->controller = $this->defaultController;
        }

        if (!$this->method) {
            $this->method = 'index';
        }

        // Get previous URL data
        $this->previousSubDir = $this->session->userdata('subDir');
        $this->previousController = $this->session->userdata('controller');
        $this->previousMethod = $this->session->userdata('method');
        $this->previousUrlParameters = $this->session->userdata('urlParameters');

        // Configure go back link
        $this->goBackLink = $this->getGoBackLink();

        if ($this->isSameURL() || strpos($this->goBackLink, 'download')) {
            $this->goBackLink = $this->session->userdata('goBackLink');
        }

        // Store navigation data
        $this->session->set_userdata(array(
            'subDir' => $this->subDir,
            'controller' => $this->controller,
            'method' => $this->method,
            'urlParameters' => getUrlParameters(),
            'goBackLink' => $this->goBackLink
        ));

    }

    public function setUserLog(): bool
    {
        $ip = $this->input->ip_address();

        if ($this->config->item('keep_user_logs') && !in_array($ip, $this->ignoredIPAddresses))
        {
            $this->config->load('maxmind');

            $accountId = $this->config->item('maxmind_accountId');
            $licenceKey = $this->config->item('maxmind_licenceKey');

            if ($accountId && $licenceKey)
            {
                $saveToCache = 0;

                try
                {
                    if (!$record = $this->cache->get($ip))
                    {
                        $client = new Client($accountId, $licenceKey);
                        $record = $client->city($ip);
                        $saveToCache = 1;
                    }

                    if ($record)
                    {
                        $this->countryCode = $record->country->isoCode;
                        $this->state = $record->mostSpecificSubdivision->name;
                        $this->city = ($record->city->name) ?: 'Unknown';
                        $this->postCode = $record->postal->code;
                        $this->latitude = $record->location->latitude;
                        $this->longitude = $record->location->longitude;
                        $this->accuracy_radius = $record->location->accuracyRadius;

                        if ($saveToCache) {
                            $this->cache->save($ip, $record, 86400);
                        }
                    }

                }
                catch (Exception $e) {
                    $this->notifyError('Maxmind API : ' . $e->getMessage());
                }
            }

            if (!in_array($this->controller, $this->dataControllers))
            {
                $data = array(
                    'user_id' => $this->user->getId(),
                    'ip' => $ip,
                    'country_code' => $this->countryCode,
                    'state' => $this->state,
                    'city' => $this->city,
                    'post_code' => $this->postCode,
                    'latitude' => $this->latitude,
                    'longitude' => $this->longitude,
                    'accuracy_radius' => $this->accuracy_radius,
                    'controller' => $this->controller,
                    'method' => $this->method,
                    'url_parameters' => getUrlParameters()
                );

                if ($this->User_logs->insert($data)) {
                    return TRUE;
                }

                $this->notifyError('Unable to add User Log.');
            }

        }

        return FALSE;
    }

    public function setLanguage()
    {
        if (!$this->session->userdata('language'))
        {
            $languageName = $this->config->item('language');

            if (isset($this->languageNamesByCountry[$this->countryCode])) {
                $languageName = $this->languageNamesByCountry[$this->countryCode];
            }

            $this->session->set_userdata('language', $languageName);
        }

        $this->config->set_item('language', $this->session->userdata('language'));

        $controllerLanguageFile = $this->controller;
        if ($this->subDir) {
            $controllerLanguageFile = $this->subDir. '/' . $controllerLanguageFile;
        }

        $this->loadLanguageFile('common');
        $this->loadLanguageFile($controllerLanguageFile);
    }

    public function setParameters()
    {
        if ($this->controller == $this->defaultController) {
            $this->isDefaultController = TRUE;
        }

        $this->inputParameters = $this->uri->uri_to_assoc();
        if ($this->subDir) {
            $this->inputParameters = $this->uri->uri_to_assoc(4);
        }

    }

    public function checkRoute()
    {
        $this->checkAutoLogin();

        if ($this->user->isLoggedIn())
        {
            if ($full_url = $this->session->userdata('full_url')) {
                $this->session->unset_userdata('full_url');
                redirect($full_url);
            }

            if ($this->controller == 'account' && ($this->method == 'index' || $this->method == 'register')) {
                redirect('/dashboard');
            }

            if ($this->controller == 'admin' && !$this->user->isAdmin()) {
                redirect('/');
            }
        }
        else
        {
            if (!$this->isAllowedMethod($this->publicMethods)) {
                $this->session->set_userdata('full_url', current_url());
                redirect('/account');
            }
        }

    }

    public function setView()
    {
        if ($this->user->isLoggedIn() && !$this->user->isVerified() && $this->method != 'email_verification_final') {
            $this->messages->addMessage('verification_required', 'warning');
        }

        $this->viewData['viewPage'] = $this->controller.'/'.$this->method.'.php';
        if ($this->subDir) {
            $this->viewData['viewPage'] = $this->subDir . '/' . $this->viewData['viewPage'];
        }

        $this->viewData['environment'] = substr(strtoupper(ENVIRONMENT), 0, 3);

        if (ENVIRONMENT == 'staging') {
            if (!isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER['PHP_AUTH_PW'])) {
                $this->authenticate();
            } else {
                if ($_SERVER['PHP_AUTH_USER'] != 'admin' || $_SERVER['PHP_AUTH_PW'] != 'staging') {
                    $this->authenticate();
                }
            }
        }

    }

    public function isLive(): bool
    {
        if (ENVIRONMENT == 'production' || ENVIRONMENT == 'staging') {
            return TRUE;
        }

        return FALSE;
    }

    public function checkAutoLogin()
    {
        if ($this->isSameURL()) {
            return;
        }

        $code = $this->uri->segment(3);
        if (!$code || strlen($code) != 32) {
            return;
        }

        if ($this->isAllowedMethod($this->autoLoginMethods))
        {
            $this->load->model('User_login_verifications');

            if (!$verification = $this->User_login_verifications->getByCode($code)) {
                return;
            }

            $redirectParameter = '';

            if($parameters = json_decode($verification['parameters'], TRUE))
            {
                $this->user->logIn($parameters['user'], $parameters['email']);
                $this->User_login_verifications->deactivate($code);

                if ($parameters['redirectParameter']) {
                    $redirectParameter = $parameters['redirectParameter'];
                }
            }

            redirect('/' . $this->controller . '/' . $this->method . '/' . $redirectParameter);
        }

    }

    public function getGoBackLink(): string
    {
        $goBackLink = '/' . $this->previousController . '/' . $this->previousMethod . '/' . $this->previousUrlParameters;

        if (!$this->previousUrlParameters && $this->previousController == 'welcome' && $this->previousMethod == 'index') {
            $goBackLink = '/';
        }

        if ($this->previousSubDir) {
            $goBackLink = '/' . $this->previousSubDir . $goBackLink;
        }

        return $goBackLink;
    }

    public function loadLanguageFile($file)
    {
        $language = $this->config->item('language');

        if ($language != 'english' && file_exists(APPPATH.'language/'.$language.'/'.$file.'_lang.php')) {
            $this->lang->load($file, $language);
        } else if (file_exists(APPPATH.'language/english/'.$file.'_lang.php')) {
            $this->lang->load($file, 'english');
        }
    }

    public function getLanguageText($key)
    {
        return getLanguageLine($key);
    }

    public function isAllowedMethod(array $allowed): bool
    {
        if (isset($allowed[$this->controller]) && (!count($allowed[$this->controller]) || in_array($this->method, $allowed[$this->controller]))) {
            return TRUE;
        }

        return FALSE;
    }

    public function isSameURL(): bool
    {
        if ($this->controller == $this->previousController && $this->method == $this->previousMethod) {
            return TRUE;
        }

        return FALSE;
    }
    
    public function processError($errorMessage, $status = 500)
    {
        $this->notifyError($errorMessage);

        if ($this->cron) {
            return;
        }

        show_error($errorMessage, $status);
    }

    public function notifyError($errorMessage)
    {
        $emailParams = array(
            'to' => $this->config->item('support_email'),
            'type' => 'error',
            'error_msg' => date('Y-m-d H:i:s')." : ".$errorMessage
        );

        $this->ses->sendMyEmail($emailParams);
    }

    function isLocked(): bool
    {
        if ($this->lockFile && file_exists(APPPATH.'tmp/'.$this->lockFile)) {
            return TRUE;
        }

        return FALSE;
    }

    function lock(): bool
    {
        if ($this->lockFile) {
            if ($fp = fopen(APPPATH.'tmp/'.$this->lockFile, 'w+')) {
                if (fwrite($fp, time())) {
                    if (fclose($fp)) {
                        $date = date('Y-m-d');
                        $this->cronLogFP = fopen(APPPATH.'logs/cronlog_'.$date.'.txt', 'a+');
                        $this->cronLog("Lock file created...");
                        return TRUE;
                    }
                }
            }
        }

        $this->cronLog("Lock file create FAILED...");
        return FALSE;
    }

    function unLock(): bool
    {
        if ($this->lockFile) {
            if (unlink(APPPATH.'tmp/'.$this->lockFile)) {
                $this->cronLog("Lock file deleted...");
                return TRUE;
            }
        }

        $this->cronLog("Lock file delete FAILED: ".$this->lockFile);
        return FALSE;
    }

    public function cronLog($logMessage = 'No log message received.'): bool
    {
        if ($this->cronLogFP) {
            if (fwrite($this->cronLogFP, date('Y-m-d H:i:s').' : '.$logMessage."\n")) {
                return TRUE;
            }
        }

        return FALSE;
    }

    function authenticate()
    {
        header('WWW-Authenticate: Basic realm="Staging Environment"');
        header('HTTP/1.0 401 Unauthorized');
        echo "You must enter a valid login ID and password to access this resource\n";
        exit;
    }

    public function __destruct()
    {
        if ($this->cron) {
            $this->unLock();
        }

    }

}
