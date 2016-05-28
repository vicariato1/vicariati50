<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Session;
use DB;
use DateTime;
use View;
use Input;
use Validator;
use Illuminate\Support\MessageBag;
use Redirect;
use App\Models\Attachment;
use App\Models\Bollettini;
use GrahamCampbell\Flysystem\Facades\Flysystem;
use Response;
use Illuminate\Support\Facades\File;

class UtilityController extends Controller {

    public function dropbox() {
        $file = "1/farfalla.jpg";
        $fs = Flysystem::connection('dropbox');
        $stream = $fs->readStream($file);
        $contents = stream_get_contents($stream);

        $flysystem2 = Flysystem::connection('localFiles');
        $flysystem2->put('10/farf.jpg', $contents);

        $filename = storage_path('files') . "/" . '10/farf.jpg';

        return Response::download($filename, 'coao.jpg', $this->getMimeType());
    }

    public function getDownload($id) {
        $attachment = Attachment::find($id);
        $nomeDir = storage_path('news') . "/" . $attachment->id_task . '/' . $attachment->nome;
        return Response::download($nomeDir, $attachment->nome, $this->getMimeType());
    }

    public function getDownloadBol($id) {
        $bollettino = Bollettini::find($id);

        DB::table('bollettini')
                ->where('id', $id)
                ->update(array('count' => $bollettino->count + 1)); //15/02/2016


        $nomeDir = storage_path('bollettini') . "/" . $bollettino->id_parrocchia . '/' . $bollettino->nome_file;
        return Response::download($nomeDir, $bollettino->nome_file, $this->getMimeType());
    }

    public function getDownloadDoc() {
        $nomeDir = storage_path('doc') . "/sito.pdf";
        return Response::download($nomeDir, "sito.pdf", $this->getMimeType());
    }

    public function getImmagine($nomeFile) {
        $path = storage_path('chiese') . "/" . $nomeFile;
        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    }

    public function daFare() {
        return View::make('extra.daFare');
    }

    public function getMimetype() {
        return array("323" => "text/h323",
            "acx" => "application/internet-property-stream",
            "ai" => "application/postscript",
            "aif" => "audio/x-aiff",
            "aifc" => "audio/x-aiff",
            "aiff" => "audio/x-aiff",
            "asf" => "video/x-ms-asf",
            "asr" => "video/x-ms-asf",
            "asx" => "video/x-ms-asf",
            "au" => "audio/basic",
            "avi" => "video/x-msvideo",
            "axs" => "application/olescript",
            "bas" => "text/plain",
            "bcpio" => "application/x-bcpio",
            "bin" => "application/octet-stream",
            "bmp" => "image/bmp",
            "c" => "text/plain",
            "cat" => "application/vnd.ms-pkiseccat",
            "cdf" => "application/x-cdf",
            "cer" => "application/x-x509-ca-cert",
            "class" => "application/octet-stream",
            "clp" => "application/x-msclip",
            "cmx" => "image/x-cmx",
            "cod" => "image/cis-cod",
            "cpio" => "application/x-cpio",
            "crd" => "application/x-mscardfile",
            "crl" => "application/pkix-crl",
            "crt" => "application/x-x509-ca-cert",
            "csh" => "application/x-csh",
            "css" => "text/css",
            "dcr" => "application/x-director",
            "der" => "application/x-x509-ca-cert",
            "dir" => "application/x-director",
            "dll" => "application/x-msdownload",
            "dms" => "application/octet-stream",
            "doc" => "application/msword",
            "dot" => "application/msword",
            "dvi" => "application/x-dvi",
            "dxr" => "application/x-director",
            "eps" => "application/postscript",
            "etx" => "text/x-setext",
            "evy" => "application/envoy",
            "exe" => "application/octet-stream",
            "fif" => "application/fractals",
            "flr" => "x-world/x-vrml",
            "gif" => "image/gif",
            "gtar" => "application/x-gtar",
            "gz" => "application/x-gzip",
            "h" => "text/plain",
            "hdf" => "application/x-hdf",
            "hlp" => "application/winhlp",
            "hqx" => "application/mac-binhex40",
            "hta" => "application/hta",
            "htc" => "text/x-component",
            "htm" => "text/html",
            "html" => "text/html",
            "htt" => "text/webviewhtml",
            "ico" => "image/x-icon",
            "ief" => "image/ief",
            "iii" => "application/x-iphone",
            "ins" => "application/x-internet-signup",
            "isp" => "application/x-internet-signup",
            "jfif" => "image/pipeg",
            "jpe" => "image/jpeg",
            "jpeg" => "image/jpeg",
            "jpg" => "image/jpeg",
            "js" => "application/x-javascript",
            "latex" => "application/x-latex",
            "lha" => "application/octet-stream",
            "lsf" => "video/x-la-asf",
            "lsx" => "video/x-la-asf",
            "lzh" => "application/octet-stream",
            "m13" => "application/x-msmediaview",
            "m14" => "application/x-msmediaview",
            "m3u" => "audio/x-mpegurl",
            "man" => "application/x-troff-man",
            "mdb" => "application/x-msaccess",
            "me" => "application/x-troff-me",
            "mht" => "message/rfc822",
            "mhtml" => "message/rfc822",
            "mid" => "audio/mid",
            "mny" => "application/x-msmoney",
            "mov" => "video/quicktime",
            "movie" => "video/x-sgi-movie",
            "mp2" => "video/mpeg",
            "mp3" => "audio/mpeg",
            "mpa" => "video/mpeg",
            "mpe" => "video/mpeg",
            "mpeg" => "video/mpeg",
            "mpg" => "video/mpeg",
            "mpp" => "application/vnd.ms-project",
            "mpv2" => "video/mpeg",
            "ms" => "application/x-troff-ms",
            "mvb" => "application/x-msmediaview",
            "nws" => "message/rfc822",
            "oda" => "application/oda",
            "p10" => "application/pkcs10",
            "p12" => "application/x-pkcs12",
            "p7b" => "application/x-pkcs7-certificates",
            "p7c" => "application/x-pkcs7-mime",
            "p7m" => "application/x-pkcs7-mime",
            "p7r" => "application/x-pkcs7-certreqresp",
            "p7s" => "application/x-pkcs7-signature",
            "pbm" => "image/x-portable-bitmap",
            "pdf" => "application/pdf",
            "pfx" => "application/x-pkcs12",
            "pgm" => "image/x-portable-graymap",
            "pko" => "application/ynd.ms-pkipko",
            "pma" => "application/x-perfmon",
            "pmc" => "application/x-perfmon",
            "pml" => "application/x-perfmon",
            "pmr" => "application/x-perfmon",
            "pmw" => "application/x-perfmon",
            "pnm" => "image/x-portable-anymap",
            "pot" => "application/vnd.ms-powerpoint",
            "ppm" => "image/x-portable-pixmap",
            "pps" => "application/vnd.ms-powerpoint",
            "ppt" => "application/vnd.ms-powerpoint",
            "prf" => "application/pics-rules",
            "ps" => "application/postscript",
            "pub" => "application/x-mspublisher",
            "qt" => "video/quicktime",
            "ra" => "audio/x-pn-realaudio",
            "ram" => "audio/x-pn-realaudio",
            "ras" => "image/x-cmu-raster",
            "rgb" => "image/x-rgb",
            "rmi" => "audio/mid",
            "roff" => "application/x-troff",
            "rtf" => "application/rtf",
            "rtx" => "text/richtext",
            "scd" => "application/x-msschedule",
            "sct" => "text/scriptlet",
            "setpay" => "application/set-payment-initiation",
            "setreg" => "application/set-registration-initiation",
            "sh" => "application/x-sh",
            "shar" => "application/x-shar",
            "sit" => "application/x-stuffit",
            "snd" => "audio/basic",
            "spc" => "application/x-pkcs7-certificates",
            "spl" => "application/futuresplash",
            "src" => "application/x-wais-source",
            "sst" => "application/vnd.ms-pkicertstore",
            "stl" => "application/vnd.ms-pkistl",
            "stm" => "text/html",
            "svg" => "image/svg+xml",
            "sv4cpio" => "application/x-sv4cpio",
            "sv4crc" => "application/x-sv4crc",
            "t" => "application/x-troff",
            "tar" => "application/x-tar",
            "tcl" => "application/x-tcl",
            "tex" => "application/x-tex",
            "texi" => "application/x-texinfo",
            "texinfo" => "application/x-texinfo",
            "tgz" => "application/x-compressed",
            "tif" => "image/tiff",
            "tiff" => "image/tiff",
            "tr" => "application/x-troff",
            "trm" => "application/x-msterminal",
            "tsv" => "text/tab-separated-values",
            "txt" => "text/plain",
            "uls" => "text/iuls",
            "ustar" => "application/x-ustar",
            "vcf" => "text/x-vcard",
            "vrml" => "x-world/x-vrml",
            "wav" => "audio/x-wav",
            "wcm" => "application/vnd.ms-works",
            "wdb" => "application/vnd.ms-works",
            "wks" => "application/vnd.ms-works",
            "wmf" => "application/x-msmetafile",
            "wps" => "application/vnd.ms-works",
            "wri" => "application/x-mswrite",
            "wrl" => "x-world/x-vrml",
            "wrz" => "x-world/x-vrml",
            "xaf" => "x-world/x-vrml",
            "xbm" => "image/x-xbitmap",
            "xla" => "application/vnd.ms-excel",
            "xlc" => "application/vnd.ms-excel",
            "xlm" => "application/vnd.ms-excel",
            "xls" => "application/vnd.ms-excel",
            "xlt" => "application/vnd.ms-excel",
            "xlw" => "application/vnd.ms-excel",
            "xof" => "x-world/x-vrml",
            "xpm" => "image/x-xpixmap",
            "xwd" => "image/x-xwindowdump",
            "z" => "application/x-compress",
            "zip" => "application/zip");
    }

//    public function leggiEmail() {
//        /**
//         * 	Gmail attachment extractor.
//         *
//         * 	Downloads attachments from Gmail and saves it to a file.
//         * 	Uses PHP IMAP extension, so make sure it is enabled in your php.ini,
//         * 	extension=php_imap.dll
//         *
//         */
//        //set_time_limit(3000);
//
//        /* connect to gmail with your credentials */
//        $hostname = '{imap.gmail.com:993/imap/ssl}INBOX';
//        $username = 'vicariatoarcella@gmail.com';
//        $password = 'partirete';
//
//        /* try to connect */
//        $inbox = imap_open($hostname, $username, $password) or die('Cannot connect to Gmail: ' . imap_last_error());
//
//        /* get all new emails. If set to 'ALL' instead 
//         * of 'NEW' retrieves all the emails, but can be 
//         * resource intensive, so the following variable, 
//         * $max_emails, puts the limit on the number of emails downloaded.
//         * 
//         */
//        $emails = imap_search($inbox, 'ALL');
//
//        /* useful only if the above search is set to 'ALL' */
//        $max_emails = 16;
//
//        $output = '';
//
//        /* if any emails found, iterate through each email */
//        if ($emails) {
//
//            $count = 1;
//
//            /* put the newest emails on top */
//            rsort($emails);
//
//            /* for every email... */
//            foreach ($emails as $email_number) {
//                /* get information specific to this email */
//                $overview = imap_fetch_overview($inbox, $email_number, 0);
//
//                /* get mail message */
//                $message = imap_fetchbody($inbox, $email_number, 1);
//
//                $header = imap_header($inbox, $count);
//                $fromInfo = $header->from[0];
//                $indemail = $fromInfo->mailbox . '@' . $fromInfo->host;
//
//                /* output the email header information */
//                $output.= '<div class="toggler ' . ($overview[0]->seen ? 'read' : 'unread') . '">';
//                $output.= '<span class="subject">' . $overview[0]->subject . '</span> ';
//                $output.= '<span class="from">' . $indemail . '</span>';
//                $output.= '<span class="date">on ' . $overview[0]->date . '</span>';
//                $output.= '</div>';
//
//                /* output the email body */
//                $output.= '<div class="body">' . $message . '</div>';
//                echo $output;
//
//
//                /* get mail structure */
//                $structure = imap_fetchstructure($inbox, $email_number);
//
//                $attachments = array();
//
//                /* if any attachments found... */
//                if (isset($structure->parts) && count($structure->parts)) {
//                    for ($i = 0; $i < count($structure->parts); $i++) {
//                        $attachments[$i] = array(
//                            'is_attachment' => false,
//                            'filename' => '',
//                            'name' => '',
//                            'attachment' => ''
//                        );
//
//                        if ($structure->parts[$i]->ifdparameters) {
//                            foreach ($structure->parts[$i]->dparameters as $object) {
//                                if (strtolower($object->attribute) == 'filename') {
//                                    $attachments[$i]['is_attachment'] = true;
//                                    $attachments[$i]['filename'] = $object->value;
//                                }
//                            }
//                        }
//
//                        if ($structure->parts[$i]->ifparameters) {
//                            foreach ($structure->parts[$i]->parameters as $object) {
//                                if (strtolower($object->attribute) == 'name') {
//                                    $attachments[$i]['is_attachment'] = true;
//                                    $attachments[$i]['name'] = $object->value;
//                                }
//                            }
//                        }
//
//                        if ($attachments[$i]['is_attachment']) {
//                            $attachments[$i]['attachment'] = imap_fetchbody($inbox, $email_number, $i + 1);
//
//                            /* 4 = QUOTED-PRINTABLE encoding */
//                            if ($structure->parts[$i]->encoding == 3) {
//                                $attachments[$i]['attachment'] = base64_decode($attachments[$i]['attachment']);
//                            }
//                            /* 3 = BASE64 encoding */ elseif ($structure->parts[$i]->encoding == 4) {
//                                $attachments[$i]['attachment'] = quoted_printable_decode($attachments[$i]['attachment']);
//                            }
//                        }
//                    }
//                }
//
//                /* iterate through each attachment and save it */
//                foreach ($attachments as $attachment) {
//                    if ($attachment['is_attachment'] == 1) {
//                        $filename = $attachment['name'];
//                        if (empty($filename))
//                            $filename = $attachment['filename'];
//
//                        if (empty($filename))
//                            $filename = time() . ".dat";
//
//                        /* prefix the email number to the filename in case two emails
//                         * have the attachment with the same file name.
//                         */
//                        $fp = fopen($email_number . "-" . $filename, "w+");
//                        fwrite($fp, $attachment['attachment']);
//                        fclose($fp);
//                    }
//                }
//
//                if ($count++ >= $max_emails)
//                    break;
//            }
//        }
//
//        /* close the connection */
//        imap_close($inbox);
//
//        return 'finito';
//    }
}
