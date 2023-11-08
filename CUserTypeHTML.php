<?php
namespace libs\usertype;
use \Bitrix\Main\UserField\Types\BaseType;
class CUserTypeHTML extends BaseType{

    public static function GetUserTypeDescription(): array
    {
        return [
            'USER_TYPE_ID' => 'sections_html_field',
            "CLASS_NAME"   => __CLASS__,
            'DESCRIPTION' => 'HTML/text',
            'BASE_TYPE' => \CUserTypeManager::BASE_TYPE_STRING,
        ];
    }
    public static function getDbColumnType(): string
    {
        return 'text';
    }
    public static function GetEditFormHTML($arUserField, $arHtmlControl): string
    {
        if ($arUserField["ENTITY_VALUE_ID"] < 1 && strlen($arUserField["SETTINGS"]["DEFAULT_VALUE"]) > 0)
            $arHtmlControl["VALUE"] = htmlspecialchars($arUserField["SETTINGS"]["DEFAULT_VALUE"]);
        ob_start();
        echo '<div class="html_realweb">';
        \CFileMan::AddHTMLEditorFrame($arHtmlControl["NAME"], $arHtmlControl["VALUE"], "html", "html", 200, "N", 0, "", "", "s1");
        echo '</div>';
        $b = ob_get_clean();
        return $b;
    }
    public static function OnBeforeSave($arUserField, $value)
    {
        return $value;
    }
}

use Bitrix\Main\Loader;
use Bitrix\Main;
$eventManager = Main\EventManager::getInstance();
Loader::registerAutoLoadClasses(null, [
    'libs\usertype\CUserTypeHTML' => '/bitrix/php_interface/libs/usertype/CUserTypeHTML.php',
]);
$eventManager->addEventHandler('main', 'OnUserTypeBuildList', ['libs\usertype\CUserTypeHTML', 'GetUserTypeDescription']);
