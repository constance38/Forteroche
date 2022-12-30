<?php

namespace blog\form;

use blog\form\FormBuilder;
use blog\form\StringField;
use blog\form\TextField;
use blog\validator\NotNullValidator;
use blog\validator\ImageValidator;

/**
 * Description of ArticlesForm
 *
 * @author constancelaloux
 */
class ArticlesForm extends FormBuilder 
{

    public function form(): void
    {
        $this->form
        ->add(new StringField([
        'type' => 'text',
        'label' => 'Titre de l\'article',
        'name' => 'getSubject',
        'maxLength' => 50,
        'minLength' => 5,
        'validators' => [
            new NotNullValidator('Veuillez insérer votre titre'),
        ],
        ]))
        ->add(new TextField([
        'label' => 'Contenu de l\'article',
        'name' => 'getContent',
        'validators' => [
            new NotNullValidator('Veuillez insérer votre texte'),
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
        'name' => 'getSlugImage',
        ]))
        ;
    }
}
