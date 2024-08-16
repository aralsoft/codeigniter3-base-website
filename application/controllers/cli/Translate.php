<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Google\Cloud\Translate\V2\TranslateClient;

class Translate extends MY_Controller
{
    // Initial class function
    public function __construct()
    {
        parent::__construct(TRUE, 'translate.lock');

    }

    /**
     * Index Page for this controller.
    **/
    public function index($language = FALSE)
    {
        $this->load->helper(array('directory', 'string'));

        $translate = new TranslateClient([
            'keyFilePath' => APPPATH.$this->config->item('google_oauth_key_file')
        ]);

        $languageFiles = getDirContents(APPPATH.'language/'.$this->config->item('language'));

        $languages = $this->config->item('languages');

        if ($language && isset($languages[$language])) {
            $languages = array($language => $languages[$language]);
        }

        foreach($languages AS $languageCode => $languageName)
        {
            if ($languageName == $this->config->item('language')) {
                continue;
            }

            echo "\nStarting language: ".$languageName;
            $this->cronLog("Starting language: ".$languageName);

            foreach ($languageFiles AS $file)
            {
                if (is_dir($file)) {
                    continue;
                }

                $fileContent = file($file);
                $fileContentTranslated = array(0 => "<?php", 1 => "defined('BASEPATH') OR exit('No direct script access allowed');");

                foreach ($fileContent AS $line) {
                    if ($key = extractKeyFromLanguageLine($line))
                    {
                        $result['text'] = '';

                        if ($sentence = trim(extractSentenceFromLanguageLine($line)))
                        {
                            try {
                                // Translate text from english.
                                if (!strpos($sentence, '.png'))
                                {
                                    $result = $translate->translate($sentence, [
                                        'target' => $languageCode
                                    ]);

                                    if (!trim($result['text'])) {
                                        $result['text'] = $sentence;
                                        $this->cronLog("Translate returned false: ".$sentence." : ".$languageName);
                                    }
                                } else {
                                    $result['text'] = $sentence;
                                }
                            } catch (Exception $e) {
                                $this->cronLog("Translate failed: ".$sentence." : ".$languageName." --- ".$e->getMessage());
                                $result['text'] = $sentence;
                            }
                        }

                        if (!$text = trim($result['text'])) {
                            $this->cronLog("Result text is false: ".$result['text']." : ".$languageName);
                        }

                        if (!strpos($text, ' ') && !strpos($text, '.png')) {
                            $text = ucfirst($text);
                        }

                        $fileContentTranslated[] = '$lang[' . "'" . $key . "'" . '] = ' . "'" . $text . "'" . ';';
                    }
                }

                $destinationFile = str_replace($this->config->item('language'), $languageName, $file);

                if (!file_put_contents($destinationFile, implode("\n", $fileContentTranslated))) {
                    $this->cronLog("Failed updating file: ".$destinationFile);
                }
            }

            echo "\nFinished language: ".$languageName."\n";
            $this->cronLog("Finished language: ".$languageName);
        }

    }

}
