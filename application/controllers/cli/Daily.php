<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Daily extends MY_Controller
{
    // Initial class function
    public function __construct()
    {
        parent::__construct(TRUE, 'daily.lock');

    }

    /**
     * Index Page for this controller.
     **/
    public function index()
    {
        $this->deleteOldLogFiles();
    }

    public function deleteOldLogFiles()
    {
        $lastWeek = date('Y-m-d', strtotime('-7 days'));

        $files = array(
            'log-cron_'.$lastWeek.'.txt',
            'log-'.$lastWeek.'.php'
        );

        foreach ($files AS $file) {
            if (file_exists(APPPATH.'logs/'.$file)) {
                unlink(APPPATH.'logs/'.$file);
            }
        }

    }

}
