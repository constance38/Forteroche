<?php

namespace blog\form;

use blog\form\StringField;
use blog\form\FormBuilder;
use blog\validator\NotNullValidator;

/**
 * Description of ConnectForm
 *
 * @author constancelaloux
 */
class ConnectAuthorForm extends FormBuilder
{
    public function form(): void
    {
        $this->form
        ->add(new StringField([
        'type' => 'text',
        'label' => 'Identifiant',
        'name' => 'getUsername',
        'maxLength' => 20,
        'minLength' => 5,
        'validators' => [
            new NotNullValidator('Veuillez insérer votre identifiant'),
        ],
        ]))
        ->add(new StringField([
        'type' => 'password',
        'label' => 'Mot de passe',
        'name' => 'getPassword',
        'maxLength' => 20,
        'minLength' => 6,
        'validators' => [
            new NotNullValidator('Merci de spécifier un mot de passe'),
        ],
        ]))
        ;
    }
}
