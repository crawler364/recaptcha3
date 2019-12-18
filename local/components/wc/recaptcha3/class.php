<?
use Bitrix\Main\Engine\Contract\Controllerable;
use Bitrix\Main\Engine\ActionFilter;

class ReCaptcha3 extends CBitrixComponent implements Controllerable
{
    public function configureActions()
    {
        return [];
    }


    public function testAction()
    {
        return [
            'count' => 48
        ];
    }

}