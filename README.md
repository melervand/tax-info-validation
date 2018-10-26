# Класс для проверки данных Юр.Лиц

### Установка
Пакет доступен на Github, но его можно установить через Composer.
Необходим PHP 5.4+.

```json
{
    "minimum-stability": "stable",
    "require": {
        "melervand/tax-info-validation":"dev-master"
    },
    "repositories": [
        {
            "type":"git",
            "url":"https://github.com/melervand/tax-info-validation"
        }
    ]
}
```

### Использование:
- `Tax::validateTIN($tin)` - валидация ИНН
- `Tax::validatePSRN($psrn)` - валидация ОГРН/ИП/ЮЛ
- `Tax::validateCA($ca, $bic)` - валидация Корреспондентского счёта
- `Tax::validateCurA($cura, $bic)` - валидация Расчётного счёта