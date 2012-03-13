<?php

/**
 * ContactForm class.
 * ContactForm is the data structure for keeping
 * contact form data. It is used by the 'contact' action of 'SiteController'.
 */
class ConfigForm extends CFormModel
{

    public $email;
    public $description;
    public $keywords;
    public $title;
    public $main_page;

    /**
     * Declares the validation rules.
     */
    public function rules()
    {
        return array(
            // name, email, subject and body are required
            array('email, description, keywords, title, main_page', 'required'),
                // email has to be a valid email address
        );
    }

    /**
     * Declares customized attribute labels.
     * If not declared here, an attribute would have a label that is
     * the same as its name with the first letter in upper case.
     */
    public function attributeLabels()
    {
        return array(
            'email'        => 'Адрес электронной почты администратора',
            'description'  => 'Описание (meta-description)',
            'keywords'     => 'Ключевые слова (meta-keywords)',
            'title'        => 'Заголовок главных блоков',
            'main_page'    => 'Текст на главной странице',
        );
    }

}
