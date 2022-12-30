<?php

namespace blog\form;

use blog\form\StringField;
use blog\form\FormBuilder;
use blog\validator\MaxLengthValidator;
use blog\validator\NotNullValidator;
use blog\validator\MajValidator;
use blog\validator\ImageValidator;

/**
 * Description of TestForm
 *
 * @author constancelaloux
 */
class CreateAuthorForm extends FormBuilder
{
    /**
     * Function to create the form
     */
    public function form(): void
    {
        $this->form->add(new StringField([
        'type' => 'text',
        'label' => 'Prenom',
        'name' => 'getFirstname',
        'maxLength' => 10,
        'validators' => [
            new MaxLengthValidator('Identifiant trop long', 10),
            new NotNullValidator('Veuillez insérer votre prénom'),
        ],
        ]))
        ->add(new StringField([
        'type' => 'text',
        'label' => 'Nom',
        'name' => 'getSurname',
        'maxLength' => 10,
        'validators' => [
            new MaxLengthValidator('Identifiant trop long)', 10),
            new NotNullValidator('Veuillez insérer votre nom'),
        ],
        ]))
        ->add(new StringField([
        'type' => 'text',
        'label' => 'Identifiant',
        'name' => 'getUsername',
        'maxLength' => 15,
        'validators' => [
            new MaxLengthValidator('Identifiant trop long)', 15),
            new NotNullValidator('Veuillez insérer votre identifiant'),
        ],
        ]))
        ->add(new StringField([
        'type' => 'password',
        'label' => 'Mot de passe',
        'name' => 'getPassword',
        'maxLength' => 12,
        'validators' => [
            new MaxLengthValidator('Mot de passe pas conforme! Votre mot de passe doit '
                                        . "comporter au moins un caractére spécial, un chiffre,"
                                        . "une majuscule et minuscule, et doit etre entre 6 caractéres minimum et 8 maximum", 8),
            new NotNullValidator('Merci de spécifier un mot de passe'),
            new MajValidator("Votre mot de passe doit comporter au moins une majuscule"),
        ],
        ])) 
        ->add(new StringField([
        'type' => 'hidden',
        'label' => 'nom de l\'image',
        'name' => 'getImage',
        'validators' => [
            new ImageValidator('Veuillez insérer votre image'),
        ],
        ])) 
        ->add(new StringField([
        'type' => 'file',
        'label' => 'Ajouter une image',
        'name' => 'getSlugImag',
        ]));
    }  
}
