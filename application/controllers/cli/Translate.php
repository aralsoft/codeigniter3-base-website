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
    public function index($translateLanguageCode = FALSE, $translateFile = FALSE): void
    {
        $this->load->helper(array('directory', 'string'));

        $translate = new TranslateClient([
            'keyFilePath' => APPPATH.$this->config->item('google_oauth_key_file')
        ]);

        $languages = $this->config->item('languages');

        if ($translateLanguageCode && isset($languages[$translateLanguageCode])) {
            $languages = array($translateLanguageCode => $languages[$translateLanguageCode]);
        }

        $languageFiles = getDirContents(APPPATH.'language/'.$this->config->item('language'));

        foreach($languages AS $languageCode => $languageName)
        {
            if ($languageName == $this->config->item('language')) {
                continue;
            }

            $this->cronLog("Starting language: ".$languageName);

            foreach ($languageFiles AS $file)
            {
                if (is_dir($file)) {
                    continue;
                }

                if ($translateFile && $translateFile != basename($file)) {
                    continue;
                }

                $this->cronLog("Translating file: ".$file);

                $fileContent = explode("';", file_get_contents($file));

                $fileContentTranslated = array(0 => "<?php", 1 => "defined('BASEPATH') OR exit('No direct script access allowed');");

                foreach ($fileContent AS $line)
                {
                    if (!$key = extractKeyFromLanguageLine($line)) {
                        continue;
                    }

                    $result['text'] = '';

                    if ($sentence = trim(extractSentenceFromLanguageLine($line))) {
                        try
                        {
                            $result = $translate->translate($sentence, [
                                'target' => $languageCode
                            ]);

                            if (!$result['text']) {
                                $result['text'] = $sentence;
                                $this->processError("Translate returned false: " . $sentence . " : " . $languageName);
                            }
                        }
                        catch (Exception $e) {
                            $result['text'] = $sentence;
                            $this->processError("Translate failed: " . $sentence . " : " . $languageName . " --- " . $e->getMessage());
                        }
                    }

                    $text = $result['text'];

                    $fileContentTranslated[] = '$lang[' . "'" . $key . "'" . '] = ' . "'" . $text . "'" . ';';

                }

                $destinationFile = str_replace($this->config->item('language'), $languageName, $file);

                if (file_put_contents($destinationFile, implode("\n", $fileContentTranslated))) {
                    $this->cronLog("Success updated file: ".$destinationFile);
                } else {
                    $this->processError("Failed updating file: ".$destinationFile);
                }
            }

            $this->cronLog("Finished language: ".$languageName);
        }

    }

}
