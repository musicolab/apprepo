<? session_start(); ?>
<!DOCTYPE html>
<html>
  <head>
		<?include 'headerHtml.php'?>
		<?
		$mimetypes = array(
            'xxx' => array('type' => 'document/unknown', 'icon' => 'unknown'),
            '3gp' => array('type' => 'video/quicktime', 'icon' => 'quicktime', 'groups' => array('video'), 'string' => 'video'),
            '7z' => array('type' => 'application/x-7z-compressed', 'icon' => 'archive', 'groups' => array('archive'), 'string' => 'archive'),
            'aac' => array('type' => 'audio/aac', 'icon' => 'audio', 'groups' => array('audio', 'html_audio', 'web_audio'), 'string' => 'audio'),
            'accdb' => array('type' => 'application/msaccess', 'icon' => 'base'),
            'ai' => array('type' => 'application/postscript', 'icon' => 'eps', 'groups' => array('image'), 'string' => 'image'),
            'aif' => array('type' => 'audio/x-aiff', 'icon' => 'audio', 'groups' => array('audio'), 'string' => 'audio'),
            'aiff' => array('type' => 'audio/x-aiff', 'icon' => 'audio', 'groups' => array('audio'), 'string' => 'audio'),
            'aifc' => array('type' => 'audio/x-aiff', 'icon' => 'audio', 'groups' => array('audio'), 'string' => 'audio'), 'applescript' => array('type' => 'text/plain', 'icon' => 'text'),
            'asc' => array('type' => 'text/plain', 'icon' => 'sourcecode'),
            'asm' => array('type' => 'text/plain', 'icon' => 'sourcecode'),
            'au' => array('type' => 'audio/au', 'icon' => 'audio', 'groups' => array('audio'), 'string' => 'audio'),
            'avi' => array('type' => 'video/x-ms-wm', 'icon' => 'avi', 'groups' => array('video', 'web_video'), 'string' => 'video'),
            'bmp' => array('type' => 'image/bmp', 'icon' => 'bmp', 'groups' => array('image'), 'string' => 'image'),
            'c' => array('type' => 'text/plain', 'icon' => 'sourcecode'),
            'cct' => array('type' => 'shockwave/director', 'icon' => 'flash'),
            'cpp' => array('type' => 'text/plain', 'icon' => 'sourcecode'),
            'cs' => array('type' => 'application/x-csh', 'icon' => 'sourcecode'),
            'css' => array('type' => 'text/css', 'icon' => 'text', 'groups' => array('web_file')),
            'csv' => array('type' => 'text/csv', 'icon' => 'spreadsheet', 'groups' => array('spreadsheet')),
            'dv' => array('type' => 'video/x-dv', 'icon' => 'quicktime', 'groups' => array('video'), 'string' => 'video'),
            'dmg' => array('type' => 'application/octet-stream', 'icon' => 'unknown'),
            'doc' => array('type' => 'application/msword', 'icon' => 'document', 'groups' => array('document')),
            'bdoc' => array('type' => 'application/x-digidoc', 'icon' => 'document', 'groups' => array('archive')),
            'cdoc' => array('type' => 'application/x-digidoc', 'icon' => 'document', 'groups' => array('archive')),
            'ddoc' => array('type' => 'application/x-digidoc', 'icon' => 'document', 'groups' => array('archive')),
            'docx' => array('type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'icon' => 'document', 'groups' => array('document')),
            'docm' => array('type' => 'application/vnd.ms-word.document.macroEnabled.12', 'icon' => 'document'),
            'dotx' => array('type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.template', 'icon' => 'document'),
            'dotm' => array('type' => 'application/vnd.ms-word.template.macroEnabled.12', 'icon' => 'document'), 
            'dcr' => array('type' => 'application/x-director', 'icon' => 'flash'),
            'dif' => array('type' => 'video/x-dv', 'icon' => 'quicktime', 'groups' => array('video'), 'string' => 'video'),
            'dir' => array('type' => 'application/x-director', 'icon' => 'flash'),
            'dxr' => array('type' => 'application/x-director', 'icon' => 'flash'),
            'eps' => array('type' => 'application/postscript', 'icon' => 'eps'),
            'epub' => array('type' => 'application/epub+zip', 'icon' => 'epub', 'groups' => array('document')),
            'fdf' => array('type' => 'application/vnd.fdf', 'icon' => 'pdf'),
            'flac' => array('type' => 'audio/flac', 'icon' => 'audio', 'groups' => array('audio', 'html_audio', 'web_audio'), 'string' => 'audio'),
            'flv' => array('type' => 'video/x-flv', 'icon' => 'flash', 'groups' => array('video', 'web_video'), 'string' => 'video'),
            'f4v' => array('type' => 'video/mp4', 'icon' => 'flash', 'groups' => array('video', 'web_video'), 'string' => 'video'),
            'fmp4' => array('type' => 'video/mp4', 'icon' => 'mpeg', 'groups' => array('html_video', 'video', 'web_video'), 'string' => 'video'),
            'gallery' => array('type' => 'application/x-smarttech-notebook', 'icon' => 'archive'),
            'galleryitem' => array('type' => 'application/x-smarttech-notebook', 'icon' => 'archive'),
            'gallerycollection' => array('type' => 'application/x-smarttech-notebook', 'icon' => 'archive'),
            'gdraw' => array('type' => 'application/vnd.google-apps.drawing', 'icon' => 'image', 'groups' => array('image')),
            'gdoc' => array('type' => 'application/vnd.google-apps.document', 'icon' => 'document', 'groups' => array('document')),
            'gsheet' => array('type' => 'application/vnd.google-apps.spreadsheet', 'icon' => 'spreadsheet', 'groups' => array('spreadsheet')),
            'gslides' => array('type' => 'application/vnd.google-apps.presentation', 'icon' => 'powerpoint', 'groups' => array('presentation')),
            'gif' => array('type' => 'image/gif', 'icon' => 'gif', 'groups' => array('image', 'web_image', 'optimised_image'), 'string' => 'image'),
            'gtar' => array('type' => 'application/x-gtar', 'icon' => 'archive', 'groups' => array('archive'), 'string' => 'archive'),
            'tgz' => array('type' => 'application/g-zip', 'icon' => 'archive', 'groups' => array('archive'), 'string' => 'archive'),
            'gz' => array('type' => 'application/g-zip', 'icon' => 'archive', 'groups' => array('archive'), 'string' => 'archive'),
            'gzip' => array('type' => 'application/g-zip', 'icon' => 'archive', 'groups' => array('archive'), 'string' => 'archive'),
            'h' => array('type' => 'text/plain', 'icon' => 'sourcecode'),
            'h5p' => array('type' => 'application/zip.h5p', 'icon' => 'h5p', 'string' => 'archive'),
            'hpp' => array('type' => 'text/plain', 'icon' => 'sourcecode'),
            'hqx' => array('type' => 'application/mac-binhex40', 'icon' => 'archive', 'groups' => array('archive'), 'string' => 'archive'),
            'htc' => array('type' => 'text/x-component', 'icon' => 'markup'),
            'html' => array('type' => 'text/html', 'icon' => 'html', 'groups' => array('web_file')),
            'xhtml' => array('type' => 'application/xhtml+xml', 'icon' => 'html', 'groups' => array('web_file')),
            'htm' => array('type' => 'text/html', 'icon' => 'html', 'groups' => array('web_file')),
            'ico' => array('type' => 'image/vnd.microsoft.icon', 'icon' => 'image', 'groups' => array('image'), 'string' => 'image'),
            'ics' => array('type' => 'text/calendar', 'icon' => 'text'),
            'isf' => array('type' => 'application/inspiration', 'icon' => 'isf'),
            'ist' => array('type' => 'application/inspiration.template', 'icon' => 'isf'),
            'java' => array('type' => 'text/plain', 'icon' => 'sourcecode'),
            'jar' => array('type' => 'application/java-archive', 'icon' => 'archive'),
            'jcb' => array('type' => 'text/xml', 'icon' => 'markup'),
            'jcl' => array('type' => 'text/xml', 'icon' => 'markup'),
            'jcw' => array('type' => 'text/xml', 'icon' => 'markup'),
            'jmt' => array('type' => 'text/xml', 'icon' => 'markup'),
            'jmx' => array('type' => 'text/xml', 'icon' => 'markup'),
            'jnlp' => array('type' => 'application/x-java-jnlp-file', 'icon' => 'markup'),
            'jpe' => array('type' => 'image/jpeg', 'icon' => 'jpeg', 'groups' => array('image', 'web_image', 'optimised_image'), 'string' => 'image'),
            'jpeg' => array('type' => 'image/jpeg', 'icon' => 'jpeg', 'groups' => array('image', 'web_image', 'optimised_image'), 'string' => 'image'),
            'jpg' => array('type' => 'image/jpeg', 'icon' => 'jpeg', 'groups' => array('image', 'web_image', 'optimised_image'), 'string' => 'image'),
            'jqz' => array('type' => 'text/xml', 'icon' => 'markup'),
            'js' => array('type' => 'application/x-javascript', 'icon' => 'text', 'groups' => array('web_file')),
            'json' => array('type' => 'application/json', 'icon' => 'text'),
            'latex' => array('type' => 'application/x-latex', 'icon' => 'text'),
            'm' => array('type' => 'text/plain', 'icon' => 'sourcecode'),
            'mbz' => array('type' => 'application/vnd.moodle.backup', 'icon' => 'moodle'),
            'mdb' => array('type' => 'application/x-msaccess', 'icon' => 'base'),
            'mht' => array('type' => 'message/rfc822', 'icon' => 'archive'),
            'mhtml' => array('type' => 'message/rfc822', 'icon' => 'archive'),
            'mov' => array('type' => 'video/quicktime', 'icon' => 'quicktime', 'groups' => array('video', 'web_video', 'html_video'), 'string' => 'video'),
            'movie' => array('type' => 'video/x-sgi-movie', 'icon' => 'quicktime', 'groups' => array('video'), 'string' => 'video'),
            'mw' => array('type' => 'application/maple', 'icon' => 'math'),
            'mws' => array('type' => 'application/maple', 'icon' => 'math'),
            'm3u' => array('type' => 'audio/x-mpegurl', 'icon' => 'mp3', 'groups' => array('audio'), 'string' => 'audio'),
            'm3u8' => array('type' => 'application/x-mpegURL', 'icon' => 'mpeg', 'groups' => array('media_source')),
            'mp3' => array('type' => 'audio/mp3', 'icon' => 'mp3', 'groups' => array('audio', 'html_audio', 'web_audio'),
                    'string' => 'audio'),
            'mp4' => array('type' => 'video/mp4', 'icon' => 'mpeg', 'groups' => array('html_video', 'video', 'web_video'),
                    'string' => 'video'),
            'm4v' => array('type' => 'video/mp4', 'icon' => 'mpeg', 'groups' => array('html_video', 'video', 'web_video'),
                    'string' => 'video'),
            'm4a' => array('type' => 'audio/mp4', 'icon' => 'mp3', 'groups' => array('audio', 'html_audio', 'web_audio'),
                    'string' => 'audio'),
            'mpeg' => array('type' => 'video/mpeg', 'icon' => 'mpeg', 'groups' => array('video', 'web_video'),
                    'string' => 'video'),
            'mpd' => array('type' => 'application/dash+xml', 'icon' => 'mpeg', 'groups' => array('media_source')),
            'mpe' => array('type' => 'video/mpeg', 'icon' => 'mpeg', 'groups' => array('video', 'web_video'),
                    'string' => 'video'),
            'mpg' => array('type' => 'video/mpeg', 'icon' => 'mpeg', 'groups' => array('video', 'web_video'),
                    'string' => 'video'),
            'mpr' => array('type' => 'application/vnd.moodle.profiling', 'icon' => 'moodle'),

            'nbk' => array('type' => 'application/x-smarttech-notebook', 'icon' => 'archive'),
            'notebook' => array('type' => 'application/x-smarttech-notebook', 'icon' => 'archive'),

            'odt' => array('type' => 'application/vnd.oasis.opendocument.text', 'icon' => 'writer', 'groups' => array('document')),
            'ott' => array('type' => 'application/vnd.oasis.opendocument.text-template', 'icon' => 'writer', 'groups' => array('document')),
            'oth' => array('type' => 'application/vnd.oasis.opendocument.text-web', 'icon' => 'oth', 'groups' => array('document')),
            'odm' => array('type' => 'application/vnd.oasis.opendocument.text-master', 'icon' => 'writer'),
            'odg' => array('type' => 'application/vnd.oasis.opendocument.graphics', 'icon' => 'draw'),
            'otg' => array('type' => 'application/vnd.oasis.opendocument.graphics-template', 'icon' => 'draw'),
            'odp' => array('type' => 'application/vnd.oasis.opendocument.presentation', 'icon' => 'impress', 'groups' => array('presentation')),
            'otp' => array('type' => 'application/vnd.oasis.opendocument.presentation-template', 'icon' => 'impress', 'groups' => array('presentation')),
            'ods' => array('type' => 'application/vnd.oasis.opendocument.spreadsheet', 'icon' => 'calc', 'groups' => array('spreadsheet')),
            'ots' => array('type' => 'application/vnd.oasis.opendocument.spreadsheet-template', 'icon' => 'calc', 'groups' => array('spreadsheet')),
            'odc' => array('type' => 'application/vnd.oasis.opendocument.chart', 'icon' => 'chart'),
            'odf' => array('type' => 'application/vnd.oasis.opendocument.formula', 'icon' => 'math'),
            'odb' => array('type' => 'application/vnd.oasis.opendocument.database', 'icon' => 'base'),
            'odi' => array('type' => 'application/vnd.oasis.opendocument.image', 'icon' => 'draw'),
            'oga' => array('type' => 'audio/ogg', 'icon' => 'audio', 'groups' => array('audio', 'html_audio', 'web_audio'), 'string' => 'audio'),
            'ogg' => array('type' => 'audio/ogg', 'icon' => 'audio', 'groups' => array('audio', 'html_audio', 'web_audio'), 'string' => 'audio'),
            'ogv' => array('type' => 'video/ogg', 'icon' => 'video', 'groups' => array('html_video', 'video', 'web_video'), 'string' => 'video'),

            'pct' => array('type' => 'image/pict', 'icon' => 'image', 'groups' => array('image'), 'string' => 'image'),
            'pdf' => array('type' => 'application/pdf', 'icon' => 'pdf', 'groups' => array('document')),
            'php' => array('type' => 'text/plain', 'icon' => 'sourcecode'),
            'pic' => array('type' => 'image/pict', 'icon' => 'image', 'groups' => array('image'), 'string' => 'image'),
            'pict' => array('type' => 'image/pict', 'icon' => 'image', 'groups' => array('image'), 'string' => 'image'),
            'png' => array('type' => 'image/png', 'icon' => 'png', 'groups' => array('image', 'web_image', 'optimised_image'),
                'string' => 'image'),
            'pps' => array('type' => 'application/vnd.ms-powerpoint', 'icon' => 'powerpoint', 'groups' => array('presentation')),
            'ppt' => array('type' => 'application/vnd.ms-powerpoint', 'icon' => 'powerpoint', 'groups' => array('presentation')),
            'pptx' => array('type' => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
                    'icon' => 'powerpoint', 'groups' => array('presentation')),
            'pptm' => array('type' => 'application/vnd.ms-powerpoint.presentation.macroEnabled.12', 'icon' => 'powerpoint',
                    'groups' => array('presentation')),
            'potx' => array('type' => 'application/vnd.openxmlformats-officedocument.presentationml.template',
                    'icon' => 'powerpoint', 'groups' => array('presentation')),
            'potm' => array('type' => 'application/vnd.ms-powerpoint.template.macroEnabled.12', 'icon' => 'powerpoint',
                    'groups' => array('presentation')),
            'ppam' => array('type' => 'application/vnd.ms-powerpoint.addin.macroEnabled.12', 'icon' => 'powerpoint',
                    'groups' => array('presentation')),
            'ppsx' => array('type' => 'application/vnd.openxmlformats-officedocument.presentationml.slideshow',
                    'icon' => 'powerpoint', 'groups' => array('presentation')),
            'ppsm' => array('type' => 'application/vnd.ms-powerpoint.slideshow.macroEnabled.12', 'icon' => 'powerpoint',
                    'groups' => array('presentation')),
            'ps' => array('type' => 'application/postscript', 'icon' => 'pdf'),
            'pub' => array('type' => 'application/x-mspublisher', 'icon' => 'publisher', 'groups' => array('presentation')),

            'qt' => array('type' => 'video/quicktime', 'icon' => 'quicktime',
                    'groups' => array('video', 'web_video'), 'string' => 'video'),
            'ra' => array('type' => 'audio/x-realaudio-plugin', 'icon' => 'audio',
                    'groups' => array('audio', 'web_audio'), 'string' => 'audio'),
            'ram' => array('type' => 'audio/x-pn-realaudio-plugin', 'icon' => 'audio',
                    'groups' => array('audio'), 'string' => 'audio'),
            'rar' => array('type' => 'application/x-rar-compressed', 'icon' => 'archive',
                    'groups' => array('archive'), 'string' => 'archive'),
            'rhb' => array('type' => 'text/xml', 'icon' => 'markup'),
            'rm' => array('type' => 'audio/x-pn-realaudio-plugin', 'icon' => 'audio',
                    'groups' => array('audio'), 'string' => 'audio'),
            'rmvb' => array('type' => 'application/vnd.rn-realmedia-vbr', 'icon' => 'video',
                    'groups' => array('video'), 'string' => 'video'),
            'rtf' => array('type' => 'text/rtf', 'icon' => 'text', 'groups' => array('document')),
            'rtx' => array('type' => 'text/richtext', 'icon' => 'text'),
            'rv' => array('type' => 'audio/x-pn-realaudio-plugin', 'icon' => 'audio',
                    'groups' => array('video'), 'string' => 'video'),
            'scss' => array('type' => 'text/x-scss', 'icon' => 'text', 'groups' => array('web_file')),
            'sh' => array('type' => 'application/x-sh', 'icon' => 'sourcecode'),
            'sit' => array('type' => 'application/x-stuffit', 'icon' => 'archive',
                    'groups' => array('archive'), 'string' => 'archive'),
            'smi' => array('type' => 'application/smil', 'icon' => 'text'),
            'smil' => array('type' => 'application/smil', 'icon' => 'text'),
            'sqt' => array('type' => 'text/xml', 'icon' => 'markup'),
            'svg' => array('type' => 'image/svg+xml', 'icon' => 'image',
                    'groups' => array('image', 'web_image'), 'string' => 'image'),
            'svgz' => array('type' => 'image/svg+xml', 'icon' => 'image',
                    'groups' => array('image', 'web_image'), 'string' => 'image'),
            'swa' => array('type' => 'application/x-director', 'icon' => 'flash'),
            'swf' => array('type' => 'application/x-shockwave-flash', 'icon' => 'flash'),
            'swfl' => array('type' => 'application/x-shockwave-flash', 'icon' => 'flash'),

            'sxw' => array('type' => 'application/vnd.sun.xml.writer', 'icon' => 'writer'),
            'stw' => array('type' => 'application/vnd.sun.xml.writer.template', 'icon' => 'writer'),
            'sxc' => array('type' => 'application/vnd.sun.xml.calc', 'icon' => 'calc'),
            'stc' => array('type' => 'application/vnd.sun.xml.calc.template', 'icon' => 'calc'),
            'sxd' => array('type' => 'application/vnd.sun.xml.draw', 'icon' => 'draw'),
            'std' => array('type' => 'application/vnd.sun.xml.draw.template', 'icon' => 'draw'),
            'sxi' => array('type' => 'application/vnd.sun.xml.impress', 'icon' => 'impress', 'groups' => array('presentation')),
            'sti' => array('type' => 'application/vnd.sun.xml.impress.template', 'icon' => 'impress',
                    'groups' => array('presentation')),
            'sxg' => array('type' => 'application/vnd.sun.xml.writer.global', 'icon' => 'writer'),
            'sxm' => array('type' => 'application/vnd.sun.xml.math', 'icon' => 'math'),

            'tar' => array('type' => 'application/x-tar', 'icon' => 'archive', 'groups' => array('archive'), 'string' => 'archive'),
            'tif' => array('type' => 'image/tiff', 'icon' => 'tiff', 'groups' => array('image'), 'string' => 'image'),
            'tiff' => array('type' => 'image/tiff', 'icon' => 'tiff', 'groups' => array('image'), 'string' => 'image'),
            'tex' => array('type' => 'application/x-tex', 'icon' => 'text'),
            'texi' => array('type' => 'application/x-texinfo', 'icon' => 'text'),
            'texinfo' => array('type' => 'application/x-texinfo', 'icon' => 'text'),
            'ts' => array('type' => 'video/MP2T', 'icon' => 'mpeg', 'groups' => array('video', 'web_video'),
                    'string' => 'video'),
            'tsv' => array('type' => 'text/tab-separated-values', 'icon' => 'text'),
            'txt' => array('type' => 'text/plain', 'icon' => 'text', 'defaulticon' => true),
            'vtt' => array('type' => 'text/vtt', 'icon' => 'text', 'groups' => array('html_track')),
            'wav' => array('type' => 'audio/wav', 'icon' => 'wav', 'groups' => array('audio', 'html_audio', 'web_audio'),
                    'string' => 'audio'),
            'webm' => array('type' => 'video/webm', 'icon' => 'video', 'groups' => array('html_video', 'video', 'web_video'),
                    'string' => 'video'),
            'wmv' => array('type' => 'video/x-ms-wmv', 'icon' => 'wmv', 'groups' => array('video'), 'string' => 'video'),
            'asf' => array('type' => 'video/x-ms-asf', 'icon' => 'wmv', 'groups' => array('video'), 'string' => 'video'),
            'wma' => array('type' => 'audio/x-ms-wma', 'icon' => 'audio', 'groups' => array('audio'), 'string' => 'audio'),

            'xbk' => array('type' => 'application/x-smarttech-notebook', 'icon' => 'archive'),
            'xdp' => array('type' => 'application/vnd.adobe.xdp+xml', 'icon' => 'pdf'),
            'xfd' => array('type' => 'application/vnd.xfdl', 'icon' => 'pdf'),
            'xfdf' => array('type' => 'application/vnd.adobe.xfdf', 'icon' => 'pdf'),

            'xls' => array('type' => 'application/vnd.ms-excel', 'icon' => 'spreadsheet', 'groups' => array('spreadsheet')),
            'xlsx' => array('type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'icon' => 'spreadsheet',
                'groups' => array('spreadsheet')),
            'xlsm' => array('type' => 'application/vnd.ms-excel.sheet.macroEnabled.12',
                    'icon' => 'spreadsheet', 'groups' => array('spreadsheet')),
            'xltx' => array('type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.template',
                    'icon' => 'spreadsheet'),
            'xltm' => array('type' => 'application/vnd.ms-excel.template.macroEnabled.12', 'icon' => 'spreadsheet'),
            'xlsb' => array('type' => 'application/vnd.ms-excel.sheet.binary.macroEnabled.12', 'icon' => 'spreadsheet'),
            'xlam' => array('type' => 'application/vnd.ms-excel.addin.macroEnabled.12', 'icon' => 'spreadsheet'),

            'xml' => array('type' => 'application/xml', 'icon' => 'markup'),
            'xsl' => array('type' => 'text/xml', 'icon' => 'markup'),

            'zip' => array('type' => 'application/zip', 'icon' => 'archive', 'groups' => array('archive'), 'string' => 'archive')
		);
		?>

		<script>
			function doit(){
				if(confirm("please confirm")){
					theform = document.getElementById('theform').submit();
				}
			}
		</script>
  </head>
  <body>
	<div class="container">

		<?include 'header.php'?>

		<div class="row">

			<?include 'menusLeft.php'?>

			<?
                                $con   = mysqli_connect("localhost", "", "", "");
                                $f     = $_GET['f'];
                                $sql   = "select * from metadata where filetype='private' and id=".$f;
				$res   = $con->query($sql)->fetch_assoc();
				$fpath = $res['filename'];
				$fname = substr($fpath, strrpos($fpath, '/')+1);
                        ?>

			<div class="col-sm-9">
				<div class="panel panel-default" style='border:1px solid #ddd;'>
                                        <div class="panel-body">
				<?
                                if(isset($_SESSION["USER"]['username'])){
					$con = mysqli_connect("localhost", "", "", "moodle");
                                ?>
					<h3>Private Files / Export / <?echo $fname?></h3>
					<hr style='background-color:#ddd'>
					<!--br>
					https://docs.moodle.org/dev/File_API_internals<br-->
					<br>
					<form action='exportPrivateFile.php' id='theform'>
					<!--export <font color=''><? echo $fname; ?></font> to <select name='dst' requried>
						<option value=''></option>
						<?
						$sql = "SELECT c.id FROM user u INNER JOIN role_assignments ra ON ra.userid = u.id INNER JOIN context ct ON ct.id = ra.contextid INNER JOIN course c ON c.id = ct.instanceid INNER JOIN role r ON r.id = ra.roleid INNER JOIN course_categories cc ON cc.id = c.category  where u.id=".$_SESSION["USER"]["id"];
						$res = $con->query($sql);
						if($res){
							while($row = mysqli_fetch_assoc($res)){
								print_r($row);
								$sql = "select * from course where id=".$row['id'];
								$resCourses = $con->query($sql);
								if($resCourses){
									while($rowCourse = mysqli_fetch_assoc($resCourses)){
									?>
									<option value='courses/<?echo $rowCourse['fullname']?>'><?echo $rowCourse['id']." - ".$rowCourse['fullname']?></option>
									<?
									}
								}
						
							}
						}	
					//echo $sql."<br>";
					?>
					</select><br>
					the private files of Musicolab LMS system<br-->
					<?
					$showSubmit = true;
					if(isset($_GET['action'])){
						if($_GET['action']=='export'){
							$showSubmit = false;
						}else{
						}
					}		
					if($showSubmit){
					?>
						<input type='button' value='SUBMIT' onclick='doit();'>
					<?
					}else{
						$con   = mysqli_connect("localhost", "", "", "moodle");
						$sql   = "select id from context where instanceid=".$_SESSION['USER']['id']." and contextlevel=30";
						$res   = $con->query($sql)->fetch_assoc();
						$ctxId = $res['id'];

						$root  = "/var/www/moodledata/filedir/";
						$path  = "/".$ctxId."/user/private/0/".$fname;
						$chash = hash_file('sha1', $fpath);
						$phash = hash('sha1', $root.$path);
						$user  = $_SESSION['USER']['firstname'].' '.$_SESSION['USER']['lastname'];

						$fext  = substr($fname, strrpos($fname, ".")+1);
						$mimet = "unknown";

						//echo "extension of ".$fname." is ".$fext."<br>";
						foreach($mimetypes as $extension => $info) {
        	                                	if($extension==$fext) {
								//echo "mimetype = ".$info['type'];
								$mimet = $info['type'];
                                	        	}
                                		}
	
						$lmspath = $root."".substr($chash, 0, 2)."/".substr($chash, 2,2)."/".$chash;

						//echo "moodle context id = ".$ctxId."<br>";
						echo "moodle path = ".$lmspath."<br>";
						echo "copying repo file ".$fpath."<br>";
						echo "copying to moodle: ".$path."<br>";
						if(!file_exists($lmspath)){
							mkdir($root."/".substr($chash, 0, 2)."/".substr($chash, 2,2)."/", 0777, true);
						}
						if(copy($fpath, $lmspath)){
							//echo "- the copy suceeded, we now need to populate the datbase<br>";
							$sql   = "insert into files (contenthash, pathnamehash, contextid, component, filearea, itemid, filepath, filename, userid, filesize, mimetype, status, source, author, license, timecreated, timemodified, sortorder, referencefileid) values ('".$chash."', '".$phash."', ".$ctxId.", 'user', 'private', 0, '/', '".$fname."', ".$_SESSION['USER']['id'].", ".filesize($lmspath).", '".$mimet."', 0, NULL, '".$user."', '', ".time().", ".time().", 0, NULL)";
							//echo "sql query = ".$sql."<br>";
							if($con->query($sql)){
							}else{
								//echo "mysql error<br>";
								//echo "error: ".$con->error."<br>";
							}
						}else{
							echo "<font color='red'>the copy failed</font> <br>";
						}
					?>
					<br>
					<font color='red'>the file was copied sucessfully !</font>
				<?
				}
				?>
				<input type='hidden' name='f' value='<?echo $_GET['f'];?>'/>
				<input type='hidden' name='action' value='export'/>
				</form>
				<?}?>
			</div>
			</div>
		</div>
		</div>

		<?include 'footer.php'?>
	</div>
  </body>
</html>

