<?php

class Mime {
    private static mimes = array(
        'applicatiion' => array(
            'atom+xml',
            'EDI-X12',
            'EDIFACT',
            'json',
            'javascript',
            'octet-stream',
            'ogg',
            'pdf',
            'postscript',
            'soap+xml',
            'xhtml+xml',
            'xml-dtd',
            'xop+xml',
            'zip',
            'x-gzip'
        ),
        'audio' => array(
            'basic',
            'mp4',
            'mpeg',
            'ogg',
            'vorbis',
            'x-ms-wma',
            'x-ms-wax',
            'vnd.rn-realaudio',
            'vnd.wave'
        ),
        'image' => array(
            'gif',
            'jpeg',
            'pjpeg',
            'png',
            'svg+xml',
            'tiff',
            'vnd.microsoft.icon'
        ),
        'message' => array(
            'http'
        ),
        'multipart' => array(
            'mixed',
            'alternative',
            'related',
            'form-data',
            'signed',
            'encrypted' 
        ),
        'text' = array(
            'cmd',
            'css',
            'csv',
            'html',
            'javascript',
            'palin',
            'xml'
        ),
        'video' => array(
            'mpeg',
            'mp4',
            'ogg',
            'quicktime',
            'webm',
            'x-ms-wmv'
        )
    );            'css',
            'csv',
            'html',
            'javascript',
            'palin',
            'xml'
        ),
        'video' => array(
            'mpeg',
            'mp4',
            'ogg',
            'quicktime',
            'webm',
            'x-ms-wmv'
        )
    );


    function __construct() {

    }

    /**
     * Lookup mime type by subtype. 
     * 
     * @param mixed $value 
     * @static
     * @return string
     */
    public static function lookupSubtype($value) {
        foreach (self::$mimes as $type) {
            foreach ($type as $subtype) {
                if ($subtype === $value) {
                    return "{$type}/{$subtype}";
                }
            }
        }

        return NULL;
    }
}
