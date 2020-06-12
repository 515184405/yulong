<?php
namespace common\helpers;

use Yii;
class Weui{

    /**
     * weui成功提示
     * @param string $title  标题
     * @param string $msg  提示内容
     * @param string $opt_button_1 主操作标题
     * @param string $opt_link_1 主操作链接
     * @param string $opt_button_2 辅助操作标题
     * @param string $opt_link_2 辅助操作链接
     * @return string
     */
    public static function show_success_msg($title, $msg = '', $opt_button_1 = '', $opt_link_1 = '', $opt_button_2 = '', $opt_link_2 = '')
    {
        $static_url = Yii::$app->params['static_url'] . '/asset/servicefee';
        $html = "<!doctype html>";
        $html .= "<html>";
        $html .= "<head>";
        $html .= "<meta charset='utf-8'>";
        $html .= "<title>{$title}</title>";
        $html .= "<meta name='viewport' content='width=device-width,initial-scale=1,user-scalable=0'>";
        $html .= "<link rel='stylesheet' href='{$static_url}/weui/style/weui.css' />";
        $html .= "<link rel='stylesheet' href='{$static_url}/weui/style/weui2.css' />";
        $html .= "<link rel='stylesheet' href='{$static_url}/weui/style/weui3.css' />";
        $html .= "<script src='{$static_url}/weui/zepto.min.js?v=201810261807'></script>";
        $html .= "<body ontouchstart style='background-color: #f8f8f8;'>";
        $html .= "<div class='weui_msg'>";
        $html .= "<div class='weui_icon_area'><i class='weui_icon_success weui_icon_msg'></i></div>";
        $html .= "<div class='weui_text_area'>";
        $html .= "<h2 class='weui_msg_title'>{$title}</h2>";
        $html .= "<p class='weui_msg_desc'>{$msg}</p>";
        $html .= "</div>";
        $html .= "<div class='weui_opr_area'>";
        $html .= "<p class='weui_btn_area'>";
        if (!empty($opt_button_1))
        {
            $html .= "<a href='{$opt_link_1}' class='weui_btn weui_btn_primary'>{$opt_button_1}</a>";
        }
        if (!empty($opt_button_2))
        {
            $html .= "<a href='{$opt_link_2}' class='weui_btn weui_btn_default'>{$opt_button_2}</a>";
        }
        $html .= "</p>";
        $html .= "</div>";
        $html .= "<div class='weui_extra_area'>";
        $html .= "</div>";
        $html .= "</div>";
        $html .= "</body>";
        $html .= "</html>";
        return $html;
    }

    /**
     * weui失败提示
     * @param string $title  标题
     * @param string $msg  提示内容
     * @param string $opt_button_1 主操作标题
     * @param string $opt_link_1 主操作链接
     * @param string $opt_button_2 辅助操作标题
     * @param string $opt_link_2 辅助操作链接
     * @return string
     */
    public static function show_fail_msg($title, $msg = '', $opt_button_1 = '', $opt_link_1 = '', $opt_button_2 = '', $opt_link_2 = '')
    {
        $static_url = Yii::$app->params['static_url'] . '/asset/servicefee';
        $html = "<!doctype html>";
        $html .= "<html>";
        $html .= "<head>";
        $html .= "<meta charset='utf-8'>";
        $html .= "<title>{$title}</title>";
        $html .= "<meta name='viewport' content='width=device-width,initial-scale=1,user-scalable=0'>";
        $html .= "<link rel='stylesheet' href='{$static_url}/weui/style/weui.css' />";
        $html .= "<link rel='stylesheet' href='{$static_url}/weui/style/weui2.css' />";
        $html .= "<link rel='stylesheet' href='{$static_url}/weui/style/weui3.css' />";
        $html .= "<script src='{$static_url}/weui/zepto.min.js?v=201810261807'></script>";
        $html .= "<body ontouchstart style='background-color: #f8f8f8;'>";
        $html .= "<div class='weui_msg'>";
        $html .= "<div class='weui_icon_area'><i class='weui_icon_warn weui_icon_msg'></i></div>";
        $html .= "<div class='weui_text_area'>";
        $html .= "<h2 class='weui_msg_title'>{$title}</h2>";
        $html .= "<p class='weui_msg_desc'>{$msg}</p>";
        $html .= "</div>";
        $html .= "<div class='weui_opr_area'>";
        $html .= "<p class='weui_btn_area'>";
        if (!empty($opt_button_1))
        {
            $html .= "<a href='{$opt_link_1}' class='weui_btn weui_btn_primary'>{$opt_button_1}</a>";
        }
        if (!empty($opt_button_2))
        {
            $html .= "<a href='{$opt_link_2}' class='weui_btn weui_btn_default'>{$opt_button_2}</a>";
        }
        $html .= "</p>";
        $html .= "</div>";
        $html .= "<div class='weui_extra_area'>";
        $html .= "</div>";
        $html .= "</div>";
        $html .= "</body>";
        $html .= "</html>";
        return $html;
    }
}
