<?php

class Slider extends CActiveRecord
{

    public $mime_type;
    public $size;
    public $name;

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'sliders';
    }

    public function rules()
    {
        return array(
            array('file', 'file'),
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels()
    {
        return array(
            'file' => 'Upload files',
        );
    }

    public function getReadableFileSize($retstring = null)
    {
        // adapted from code at http://aidanlister.com/repos/v/function.size_readable.php
        $sizes = array('bytes', 'kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');

        if($retstring === null)
        {
            $retstring = '%01.2f %s';
        }

        $lastsizestring = end($sizes);

        foreach($sizes as $sizestring)
        {
            if($this->size < 1024)
            {
                break;
            }
            if($sizestring != $lastsizestring)
            {
                $this->size /= 1024;
            }
        }
        if($sizestring == $sizes[0])
        {
            $retstring = '%01d %s';
        } // Bytes aren't normally fractional
        return sprintf($retstring, $this->size, $sizestring);
    }

    public function getUrl()
    {
        return '/uploads/slider/' . $this->file;
    }

    public function getThumbnail_url()
    {
        return '/uploads/slider/thumbs/' . $this->file;
    }

}
