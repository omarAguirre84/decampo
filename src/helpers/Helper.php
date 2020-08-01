<?php
class Helper {
    public static function ajax_response($data = null) {
        header("Content-Type: application/json; charset=utf-8");
        echo json_encode(!empty($data) ? $data : []);
    }
}