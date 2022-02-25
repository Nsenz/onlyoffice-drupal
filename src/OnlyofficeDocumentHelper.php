<?php

namespace Drupal\onlyoffice_connector;

class OnlyofficeDocumentHelper
{
    const DOC_SERV_FILLFORMS = array(".oform", ".docx");
    const DOC_SERV_VIEWD = array(".pdf", ".djvu", ".xps", ".oxps");
    const DOC_SERV_EDITED = array(".docx", ".xlsx", ".csv", ".pptx", ".txt", ".docxf");
    const DOC_SERV_CONVERT = array(".docm", ".doc", ".dotx", ".dotm", ".dot", ".odt", ".fodt", ".ott", ".xlsm", ".xls", ".xltx", ".xltm", ".xlt", ".ods", ".fods", ".ots", ".pptm", ".ppt", ".ppsx", ".ppsm", ".pps", ".potx", ".potm", ".pot", ".odp", ".fodp", ".otp", ".rtf", ".mht", ".html", ".htm", ".xml", ".epub", ".fb2");

    const EXTS_CELL = array(
        ".xls", ".xlsx", ".xlsm",
        ".xlt", ".xltx", ".xltm",
        ".ods", ".fods", ".ots", ".csv"
    );

    const EXTS_SLIDE = array(
        ".pps", ".ppsx", ".ppsm",
        ".ppt", ".pptx", ".pptm",
        ".pot", ".potx", ".potm",
        ".odp", ".fodp", ".otp"
    );

    const EXTS_WORD = array(
        ".doc", ".docx", ".docm",
        ".dot", ".dotx", ".dotm",
        ".odt", ".fodt", ".ott", ".rtf", ".txt",
        ".html", ".htm", ".mht", ".xml",
        ".pdf", ".djvu", ".fb2", ".epub", ".xps", ".oxps", ".oform"
    );

    public function getDocumentType($filename) {
        $ext = strtolower('.' . pathinfo($filename, PATHINFO_EXTENSION));
    
        if (in_array($ext, OnlyofficeDocumentHelper::EXTS_WORD)) return "word";
        if (in_array($ext, OnlyofficeDocumentHelper::EXTS_CELL)) return "cell";
        if (in_array($ext, OnlyofficeDocumentHelper::EXTS_SLIDE)) return "slide";
        return "word";
    }
    
    public function isEditable($filename) {
        $ext = strtolower('.' . pathinfo($filename, PATHINFO_EXTENSION));
        return in_array($ext, OnlyofficeDocumentHelper::DOC_SERV_EDITED);
    }
}
