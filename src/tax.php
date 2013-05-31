<?php
class Tax {
    public static function validateTIN($tin) {
        $tin = trim($tin);
        //TIN = Taxpayer identification number
        //ИНН = Идентификационный номер налогоплательщика
        //http://ru.wikipedia.org/wiki/%D0%98%D0%9D%D0%9D#.D0.92.D1.8B.D1.87.D0.B8.D1.81.D0.BB.D0.B5.D0.BD.D0.B8.D0.B5_.D0.BA.D0.BE.D0.BD.D1.82.D1.80.D0.BE.D0.BB.D1.8C.D0.BD.D1.8B.D1.85_.D1.86.D0.B8.D1.84.D1.80.5B.D0.B8.D1.81.D1.82.D0.BE.D1.87.D0.BD.D0.B8.D0.BA.C2.A0.D0.BD.D0.B5.C2.A0.D1.83.D0.BA.D0.B0.D0.B7.D0.B0.D0.BD.C2.A0140.C2.A0.D0.B4.D0.BD.D0.B5.D0.B9.5D
        if (strlen($tin) == 12 || strlen($tin) == 10) {
            if (strlen($tin) == 12) {
                //TIN is 12 digit number
                //and it is personal
                if ( ( $tin[10] == ((7*$tin[0] + 2*$tin[1] + 4*$tin[2] + 10*$tin[3] + 3*$tin[4] + 5*$tin[5] + 9*$tin[6] + 4*$tin[7] + 6*$tin[8] + 8*$tin[9]) %11) %10 ) &&
                    ( $tin[11] == ((3*$tin[0] + 7*$tin[1] + 2*$tin[2] + 4*$tin[3] + 10*$tin[4] + 3*$tin[5] + 5*$tin[6] + 9*$tin[7] + 4*$tin[8] + 6*$tin[9] + 8*$tin[10]) %11) %10 ) ) {
                    return true;
                }
            } else {
                //TIN is 10 digit number
                //and it is for companies
                if ($tin[9] == (( 2*$tin[0] + 4*$tin[1] + 10*$tin[2] + 3*$tin[3] + 5*$tin[4] + 9*$tin[5] + 4*$tin[6] + 6*$tin[7] + 8*$tin[8] ) %11) %10) {
                    return true;
                }
            }
        }
        return false;
    }

    public static function validatePSRN($psrn) {
        $psrn = trim($psrn);
        //PSRN - Primary state registration number
        //ОГРН/ИП/ЮЛ - Основной государственный регистрационный номер
        //http://zapolnenie.info/algoritm-proverki-ogrn/

        $digits = strlen($psrn);
        if ($digits == 15 || $digits == 13) {
            if ($digits == 15) {
                //using fmod() cause of bigint!
                if (fmod(fmod(substr($psrn, 0, -1), 13), 10) == $psrn[14]) {
                    return true;
                }
            } else {
                if (fmod(fmod(substr($psrn, 0, -1), 11), 10) == $psrn[12]) {
                    return true;
                }
            }
        }
        return false;
    }

    private static function validateBAN($ban) {
        //BAN - Bank account number/Номер банковского счета
        $ban = trim($ban);
        $sum = 0;
        $coeffs = array(7,1,3,7,1,3,7,1,3,7,1,3,7,1,3,7,1,3,7,1,3,7,1);

        for ($i = 0; $i <= 22; $i++) {
            $sum += fmod( $ban[$i]*$coeffs[$i] , 10);
        }

        if (fmod($sum, 10) == 0) {
            return true;
        }

        return false;
    }

    public static function validateCA($ca, $bic) {
        //CA - correspondent account/Корреспондентский счёт
        //BIC - Bank Identification Code/Банковский идентификационный код

        $ca = trim($ca);
        if (strlen($ca) < 20) return false;
        $bic = trim($bic);
        if (strlen($bic) < 9) return false;
        return self::validateBAN('0'.substr($bic, 4, 2).$ca);
    }

    public static function validateCurA($cura, $bic) {
        //CurA - current account/Расчётный счёт
        //BIC - Bank Identification Code/Банковский идентификационный код

        $cura = trim($cura);
        if (strlen($cura) < 20) return false;
        $bic = trim($bic);
        if (strlen($bic) < 9) return false;
        return self::validateBAN(substr($bic, 6,3).$cura);
    }

    //TODO: add http://ru.wikipedia.org/wiki/Код_причины_постановки_на_учёт
}