<?php

namespace blog\validator;

use blog\validator\Validator;

/**
 * Description of MajValidator
 *
 * @author constancelaloux
 */
class MajValidator extends Validator
{

    public function isValid(string $value): string
    {
        /**
         * https://openclassrooms.com/fr/courses/2091901-protegez-vous-efficacement-contre-les-failles-web/2917331-controlez-les-mots-de-passe
         * I check if my password is not too short and if its a correct password
         */
        if (preg_match('#^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).{6,8}$#', $value))
        {
            return $value;
        }
    }
}
