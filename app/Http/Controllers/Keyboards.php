<?php

namespace App\Http\Controllers;

class Keyboards extends Controller
{
public $action_keyboard=
    [
        "min_api_version"=>7,        
            "Type"=>"keyboard",
            "DefaultHeight"=>false,
            "BgColor"=>"#FFFFFF",            
            "keyboard"=>[
            "Buttons"=>[    
                [
                    "Columns"=>3,
                    "Rows"=>1,
                    "ActionType"=>"reply",
                    "ActionBody"=>"1",
                    "Text"=>"<font color=#000000>Подать объявление</font>",
                    "TextSize"=>"large",
                    "TextVAlign"=>"middle",
                    "TextHAlign"=>"middle",
                    "Silent"=>true,
                ],
                [
                    "Columns"=>3,
                    "Rows"=>1,
                    "ActionType"=>"reply",
                    "ActionBody"=>"2",
                    "Text"=>"<font color=#000000>Смотреть объявления</font>",
                    "TextSize"=>"large",
                    "TextVAlign"=>"middle",
                    "TextHAlign"=>"middle",
                    "Silent"=>true,
                ]
            ]
        ]];

        public $type_ad_keyboard=
        [
            "min_api_version"=>7,        
                "Type"=>"keyboard",
                "DefaultHeight"=>false,
                "BgColor"=>"#FFFFFF",
                "keyboard"=>[
                "Buttons"=>[    
                    [
                        "Columns"=>6,
                        "Rows"=>1,
                        "ActionType"=>"reply",
                        "ActionBody"=>"1",
                        "Text"=>"<font color=#000000>Аренда</font>",
                        "TextSize"=>"large",
                        "TextVAlign"=>"middle",
                        "TextHAlign"=>"middle",
                        "Silent"=>true,
                    ],
                    [
                        "Columns"=>6,
                        "Rows"=>1,
                        "ActionType"=>"reply",
                        "ActionBody"=>"2",
                        "Text"=>"<font color=#000000>Продажа</font>",
                        "TextSize"=>"large",
                        "TextVAlign"=>"middle",
                        "TextHAlign"=>"middle",
                        "Silent"=>true,
                    ]
                ]
            ]];  

    public $type_prop_keyboard=
            [
                "min_api_version"=>7,        
                    "Type"=>"keyboard",
                    "DefaultHeight"=>false,
                    "BgColor"=>"#FFFFFF",
                    "keyboard"=>[
                    "Buttons"=>[    
                        [
                            "Columns"=>6,
                            "Rows"=>1,
                            "ActionType"=>"reply",
                            "ActionBody"=>"1",
                            "Text"=>"<font color=#000000>Квартира</font>",
                            "TextSize"=>"large",
                            "TextVAlign"=>"middle",
                            "TextHAlign"=>"middle",
                            "Silent"=>true,
                        ],
                        [
                            "Columns"=>6,
                            "Rows"=>1,
                            "ActionType"=>"reply",
                            "ActionBody"=>"2",
                            "Text"=>"<font color=#000000>Гараж</font>",
                            "TextSize"=>"large",
                            "TextVAlign"=>"middle",
                            "TextHAlign"=>"middle",
                            "Silent"=>true,
                        ],
                        [
                            "Columns"=>6,
                            "Rows"=>1,
                            "ActionType"=>"reply",
                            "ActionBody"=>"3",
                            "Text"=>"<font color=#000000>Частный дом</font>",
                            "TextSize"=>"large",
                            "TextVAlign"=>"middle",
                            "TextHAlign"=>"middle",
                            "Silent"=>true,
                        ],
                        [
                            "Columns"=>6,
                            "Rows"=>1,
                            "ActionType"=>"reply",
                            "ActionBody"=>"4",
                            "Text"=>"<font color=#000000>Участок</font>",
                            "TextSize"=>"large",
                            "TextVAlign"=>"middle",
                            "TextHAlign"=>"middle",
                            "Silent"=>true,
                        ],
                        [
                            "Columns"=>6,
                            "Rows"=>1,
                            "ActionType"=>"reply",
                            "ActionBody"=>"5",
                            "Text"=>"<font color=#000000>Коммерческое</font>",
                            "TextSize"=>"large",
                            "TextVAlign"=>"middle",
                            "TextHAlign"=>"middle",
                            "Silent"=>true,
                        ]
                    ]
                ]];  


    public $location_keyboard=[
        "Type"=>"keyboard",
        "min_api_version"=>7,
        "keyboard"=>[
           "DefaultHeight"=>false,
           "Buttons"=>[
              [
                 "ActionType"=>"location-picker",
                 "ActionBody"=>"loc",
                 "Text"=>"Отправить местоположение",
                 "TextSize"=>"regular",
                 "Silent"=>true,
              ]
           ]
        ]
     ];

     public $price_keyboard=[
        "type"=>"text",
        "text"=>"укажите стоимость в тыс.р. (например 3,5)",
        "min_api_version"=>7
     ];

     public $description_keyboard=[
        "type"=>"text",
        "text"=>"добавьте описание",
        "min_api_version"=>7
     ];

     public $photo_keyboard=[
        "type"=>"text",
        "text"=>"отправьте до 5ти фотографий объекта или нажмите не добавлять если не хотите опубликовать фото",
        "min_api_version"=>7,
        "keyboard"=>[
           "DefaultHeight"=>false,
           "Buttons"=>[
              [
                 "ActionType"=>"reply",
                 "ActionBody"=>"end_photo",
                 "Text"=>"не добавлять фото",
                 "TextSize"=>"regular",
                 "Silent"=>true,
              ]
           ]
        ]
     ];     

     public $publish_keyboard=
    [
        "min_api_version"=>7,        
            "Type"=>"keyboard",
            "DefaultHeight"=>false,
            "BgColor"=>"#FFFFFF",
            "keyboard"=>[
                "InputFieldState"=>"hidden",
            "Buttons"=>[    
                [
                    "Columns"=>1,
                    "Rows"=>1,
                    "ActionType"=>"reply",
                    "ActionBody"=>"home",
                    "Text"=>"<font color=#000000>o</font>",
                    "TextSize"=>"large",
                    "TextVAlign"=>"middle",
                    "TextHAlign"=>"middle",
                    "Silent"=>true,
                ],
                [
                    "Columns"=>5,
                    "Rows"=>1,
                    "ActionType"=>"none",
                    "ActionBody"=>"home",
                    "Text"=>"<font color=#000000></font>",
                    "TextSize"=>"large",
                    "TextVAlign"=>"middle",
                    "TextHAlign"=>"middle",
                    "Silent"=>true,
                ],
                [
                    "Columns"=>3,
                    "Rows"=>1,
                    "ActionType"=>"reply",
                    "ActionBody"=>"1",
                    "Text"=>"<font color=#000000>Опубликовать</font>",
                    "TextSize"=>"large",
                    "TextVAlign"=>"middle",
                    "TextHAlign"=>"middle",
                    "Silent"=>true,
                ],
                [
                    "Columns"=>3,
                    "Rows"=>1,
                    "ActionType"=>"reply",
                    "ActionBody"=>"2",
                    "Text"=>"<font color=#000000>Отмена</font>",
                    "TextSize"=>"large",
                    "TextVAlign"=>"middle",
                    "TextHAlign"=>"middle",
                    "Silent"=>true,
                ]
            ]
        ]];

        public $final_text=[
            "type"=>"text",
            "text"=>"ваше объявление размещена",
            "min_api_version"=>7
         ];
    }