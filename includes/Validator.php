<?php

class Validator {
    /**
     * اعتبارسنجی شماره موبایل
     * شماره موبایل باید با 09 شروع شود و دقیقاً 11 رقم باشد
     */
    public static function validateMobile($mobile) {
        if (empty($mobile)) return false;
        return preg_match('/^09[0-9]{9}$/', $mobile);
    }

    /**
     * اعتبارسنجی کد ملی
     * کد ملی باید 10 رقم باشد و الگوریتم خاص خودش را داشته باشد
     */
    public static function validateNationalCode($code) {
        if (!preg_match('/^[0-9]{10}$/', $code)) {
            return false;
        }
        
        $sum = 0;
        for ($i = 0; $i < 9; $i++) {
            $sum += intval($code[$i]) * (10 - $i);
        }
        
        $divideRemaining = $sum % 11;
        $lastDigit = intval($code[9]);
        
        if ($divideRemaining < 2) {
            return ($lastDigit == $divideRemaining);
        }
        
        return ($lastDigit == (11 - $divideRemaining));
    }

    /**
     * اعتبارسنجی شماره پرسنلی
     * شماره پرسنلی باید بین 5 تا 10 رقم باشد
     */
    public static function validatePersonnelNumber($number) {
        if (empty($number)) return false;
        return preg_match('/^[0-9]{5,10}$/', $number);
    }
}