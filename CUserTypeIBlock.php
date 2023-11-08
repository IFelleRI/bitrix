<?php

use Bitrix\Main;
$eventManager = Main\EventManager::getInstance();
$eventManager->addEventHandler('iblock', 'OnIBlockPropertyBuildList', ['lib\usertype\CUserTypePrice', 'GetUserTypeDescription']);
class CUserTypePrice {
    public static function GetUserTypeDescription()
    {
        return array(
            'USER_TYPE_ID' => 'user_price',
            'USER_TYPE' => 'PRICE',
            'CLASS_NAME' => __CLASS__,
            'DESCRIPTION' => 'Таблица цен',
            'PROPERTY_TYPE' => 'S',
            'ConvertToDB' => [__CLASS__, 'ConvertToDB'],
            'ConvertFromDB' => [__CLASS__, 'ConvertFromDB'],
            'GetPropertyFieldHtml' => [__CLASS__, 'GetPropertyFieldHtml'],
        );
    }

    public static function ConvertToDB($arProperty, $value)
    {
        if(!empty($value['VALUE'])){
            if(!empty($value['VALUE']['price-name']) &&  !empty($value['VALUE']['price-val'])){
                try {
                    $value['VALUE'] = base64_encode(serialize($value['VALUE']));
                } catch(Bitrix\Main\ObjectException $exception) {
                    echo $exception->getMessage();
                }
            }else{
                $value['VALUE'] = '';
            }
        }
        return $value;
    }

    public static function ConvertFromDB($arProperty, $value, $format = '')
    {
        if (!empty($value['VALUE'])){
            try {
                $value['VALUE'] = base64_decode($value['VALUE']);
            } catch(Bitrix\Main\ObjectException $exception) {
                echo $exception->getMessage();
            }
        }
        return $value;
    }

    public static function GetPropertyFieldHtml($arProperty, $value, $arHtmlControl)
    {

        $name = $arHtmlControl['VALUE'];
        $arValue = unserialize(htmlspecialcharsback($value['VALUE']), [stdClass::class]);
        $html = '
        <div class="row-price">
            <div class="row-price_input" style="display: flex;margin-bottom: 10px;">
                  <div class="price_name" style="margin-right: 20px;display: flex;flex-direction: column;">
                    <span>Название</span>
                    <input type="text" name="'.$name.'[price-name]" value="'.$arValue['price-name'].'" style="width: 310px;">
                  </div>
                    <div class="price_val" style="display: flex;flex-direction: column;">
                    <span>Цена</span>
                    <input type="text" name="'.$name.'[price-val]" value="'.$arValue['price-val'].'">
                  </div>
            </div>
        </div>';
        return $html;
    }
}