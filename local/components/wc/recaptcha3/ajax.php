<?

namespace WC\Ajax;


require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

use Bitrix\Main\Web\Json;

class ReCaptcha3
{
    private $action;
    private $request;
    private $siteKey;
    private $answer;

    public function __construct($arParams)
    {
        addmessage2log($arParams);
        $this->request = \Bitrix\Main\Context::getCurrent()->getRequest();
        $this->action = $this->request->get("action");
        $this->siteKey = '6LcRTb8UAAAAAKdeuIsBkiRKBH5wREh7YeskoT3g';
    }

    public function handler()
    {
        if (!$this->action) {
            return false;
        }
        switch ($this->action) {
            case "getSiteKey":
                $this->getSiteKey();
                break;
            default:
                break;
        }

        header('Content-Type: application/json');
        echo Json::encode($this->answer);
    }

    private function getSiteKey()
    {
        if ($this->siteKey) {
            $this->answer = $this->siteKey;
        }
    }

}

$ReCaptcha3 = new ReCaptcha3($arParams);
$ReCaptcha3->handler();