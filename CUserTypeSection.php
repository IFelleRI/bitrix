<?php
AddEventHandler('main', 'OnUserTypeBuildList', array('CUserTypePopup', 'GetUserTypeDescription'), 5000);
class CUserTypePopup extends BaseType{

    public static function GetUserTypeDescription(): array
    {
        return [
            'USER_TYPE_ID' => 'POPUP',
            "CLASS_NAME"   => __CLASS__,
            'DESCRIPTION' => 'Настройки pop-up',
            'BASE_TYPE' => CUserTypeManager::BASE_TYPE_STRING,
        ];
    }
    public static function getDbColumnType(): string
    {
        return 'text';
    }
    public static function GetEditFormHTML($arUserField, $arHtmlControl): string
    {
        $html = '
        <div class="items">
            <div class="row-item_input" style="display: flex;margin-bottom: 10px;">
                  <div class="item_name" style="margin-right: 20px;display: flex;flex-direction: column;">
                    <span>Заголовок слева</span>
                    <input type="text" name="'.$arHtmlControl["NAME"].'[TEXT-L]" value="'.$arHtmlControl['VALUE']['TEXT-L'].'" style="width: 310px;" >
                  </div>
                  <div class="item_name" style="margin-right: 20px;display: flex;flex-direction: column;">
                    <span>Шрфит(px)</span>
                    <input type="text" name="'.$arHtmlControl["NAME"].'[SIZE-L]" value="'.$arHtmlControl['VALUE']['SIZE-L'].'" style="width: 310px;" >
                  </div>
                  <div class="item_name" style="margin-right: 20px;display: flex;flex-direction: column;">
                    <span>Начертание(200-900)</span>
                    <input type="text" name="'.$arHtmlControl["NAME"].'[WIGHT-L]" value="'.$arHtmlControl['VALUE']['WIGHT-L'].'" style="width: 310px;" >
                  </div>
            </div>
             <div class="row-item_input" style="display: flex;margin-bottom: 10px;">
                  <div class="item_name" style="margin-right: 20px;display: flex;flex-direction: column;">
                    <span>Заголовок справа</span>
                    <input type="text" name="'.$arHtmlControl["NAME"].'[TEXT-R]" value="'.$arHtmlControl['VALUE']['TEXT-R'].'" style="width: 310px;" >
                  </div>
                  <div class="item_name" style="margin-right: 20px;display: flex;flex-direction: column;">
                    <span>Шрфит(px)</span>
                    <input type="text" name="'.$arHtmlControl["NAME"].'[SIZE-R]" value="'.$arHtmlControl['VALUE']['SIZE-R'].'" style="width: 310px;" >
                  </div>
                  <div class="item_name" style="margin-right: 20px;display: flex;flex-direction: column;">
                    <span>Начертание(200-900)</span>
                    <input type="text" name="'.$arHtmlControl["NAME"].'[WIGHT-R]" value="'.$arHtmlControl['VALUE']['WIGHT-R'].'" style="width: 310px;" >
                  </div>
            </div>
        </div>
        ';
        return $html;
    }
    static function OnBeforeSave($arUserField, $value)
    {
        return serialize($value);
    }
    static function onAfterFetch($arProperty, $arValue): array
    {
        if (!empty($arValue["VALUE"])) {
            $arValue = unserialize($arValue['VALUE']);
        }
        return $arValue;
    }

}