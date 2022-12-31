<?php

namespace App\Dao\Traits;

use Plugins\Filter;

trait OptionTrait
{
    public static $option_data;
    public static $option_model;
    public static $option_query;
    public static $option_label;
    public static $option_name;
    public static $option_id;

    public static function setId($value = false)
    {
        self::$option_id = self::optionId();
        if ($value) {
            self::$option_id = $value;
        }
        return;
    }

    public static function setName($value = false)
    {
        self::$option_name = self::optionName();
        if ($value) {
            self::$option_name = $value;
        }
        return;
    }

    public static function setLabel($value = false)
    {
        self::$option_label = __('- Select Option -');
        if ($value) {
            self::$option_label = $value;
        }
        return;
    }

    public static function getOptions($raw = false)
    {
        self::$option_model = self::getModel();

        if ($raw) {
            return self::$option_model->get();
        }
        else{

            self::$option_data = self::$option_model
            ->select(self::$option_model->fieldSearching(), self::$option_model->getKeyName())
            ->get()
            ->pluck( self::$option_model->fieldSearching(),  self::$option_model->getKeyName())
            ;
        }


        return self::$option_data;
    }
}
