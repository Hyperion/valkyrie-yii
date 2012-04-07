<?php

class BHtml
{

    static function formatFileSize($bytes)
    {
        $bytes = (int) $bytes;
        if(!$bytes)
        {
            return '';
        }
        if($bytes >= 1000000000)
        {
            return sprintf('%.2f', $bytes / 1000000000) . ' GB';
        }
        if($bytes >= 1000000)
        {
            return sprintf('%.2f', $bytes / 1000000) . ' MB';
        }
        return sprintf('%.2f', $bytes / 1000) . ' KB';
    }

}