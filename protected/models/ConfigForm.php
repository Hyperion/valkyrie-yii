<?php

/**
 * ContactForm class.
 * ContactForm is the data structure for keeping
 * contact form data. It is used by the 'contact' action of 'SiteController'.
 */
class ConfigForm extends CFormModel
{

    public $name;
    public $email;
    public $info_email;
    public $phone1;
    public $phone2;
    public $description;
    public $keywords;
    public $contact_info;
    public $title;
    public $adress;
    public $main_page;

    /**
     * Declares the validation rules.
     */
    public function rules()
    {
        return array(
            // name, email, subject and body are required
            array('name,adress, email,info_email,phone1,phone2,description,keywords,contact_info,title, main_page', 'required'),
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
            'name'         => 'Название сайта',
            'email'        => 'Адрес электронной почты администратора',
            'description'  => 'Мeta-теги',
            'keywords'     => 'Ключевые слова',
            'contact_info' => 'Информация в контактах',
            'title'        => 'Заголовок главных блоков',
            'info_email'   => 'Емейл на сайте',
            'phone1'       => 'Телефон 1',
            'phone2'       => 'Телефон 2',
            'adress'       => 'Адрес',
            'main_page'    => 'Текст на главной странице',
        );
    }

}
