<?php

function strip_html_tags($text) {
    // PHP's strip_tags() function will remove tags, but it
    // doesn't remove scripts, styles, and other unwanted
    // invisible text between tags.  Also, as a prelude to
    // tokenizing the text, we need to insure that when
    // block-level tags (such as <p> or <div>) are removed,
    // neighboring words aren't joined.
    $text = preg_replace(
            array(
        // Remove invisible content
        '@<head[^>]*?>.*?</head>@siu',
        '@<style[^>]*?>.*?</style>@siu',
        '@<script[^>]*?.*?</script>@siu',
        '@<object[^>]*?.*?</object>@siu',
        '@<embed[^>]*?.*?</embed>@siu',
        '@<applet[^>]*?.*?</applet>@siu',
        '@<noframes[^>]*?.*?</noframes>@siu',
        '@<noscript[^>]*?.*?</noscript>@siu',
        '@<noembed[^>]*?.*?</noembed>@siu',
        /* '@<input[^>]*?>@siu', */
        '@<form[^>]*?.*?</form>@siu',
        // Add line breaks before & after blocks
        '@<((br)|(hr))>@iu',
        '@</?((address)|(blockquote)|(center)|(del))@iu',
        '@</?((div)|(h[1-9])|(ins)|(isindex)|(p)|(pre))@iu',
        '@</?((dir)|(dl)|(dt)|(dd)|(li)|(menu)|(ol)|(ul))@iu',
        '@</?((table)|(th)|(td)|(caption))@iu',
        '@</?((form)|(button)|(fieldset)|(legend)|(input))@iu',
        '@</?((label)|(select)|(optgroup)|(option)|(textarea))@iu',
        '@</?((frameset)|(frame)|(iframe))@iu',
            ), array(
        " ", " ", " ", " ", " ", " ", " ", " ", " ", " ",
        " ", "\n\$0", "\n\$0", "\n\$0", "\n\$0", "\n\$0",
        "\n\$0", "\n\$0",
            ), $text);

    // remove empty lines
    $text = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $text);
    // remove leading spaces
    $text = preg_replace("/\n( )*/", "\n", $text);

    // Remove all remaining tags and comments and return.
    return strip_tags($text);
}

class mailer {

    public $server;
    public $port;
    public $username;
    public $password;
    public $secure;    /* can be tls, ssl, or none */
    public $charset = "\"iso-8859-1\""; /* included double quotes on purpose */
    public $contentType = "multipart/mixed";  /* can be set to: text/plain, text/html, multipart/mixed */
    public $transferEncodeing = "quoted-printable"; /* or 8-bit  */
    public $altBody = "";
    public $isLogin = false;
    public $recipients = array();
    public $cc = array();
    public $bcc = array();
    public $attachments = array();
    private $conn;
    private $newline = "\r\n";
    private $localhost = 'localhost';
    private $timeout = '60';
    private $debug = false;

    public function __construct($server, $port, $username = null, $password = null, $secure = null) {
        $this->server = $server;
        $this->port = $port;
        $this->username = $username;
        $this->password = $password;
        $this->secure = $secure;

        if (!$this->connect())
            return;
        if (!$this->auth())
            return;
        $this->isLogin = true;
        return;
    }

    /* Connect to the server */

    private function connect() {
        if (strtolower(trim($this->secure)) == 'ssl') {
            $this->server = 'ssl://' . $this->server;
        }
        $this->conn = fsockopen($this->server, $this->port, $errno, $errstr, $this->timeout);
        if (substr($this->getServerResponse(), 0, 3) != '220') {
            return false;
        }
        return true;
    }

    /* sign in / authenicate */

    private function auth() {
        fputs($this->conn, 'HELO ' . $this->localhost . $this->newline);
        $this->getServerResponse();
        if (strtolower(trim($this->secure)) == 'tls') {
            fputs($this->conn, 'STARTTLS' . $this->newline);
            if (substr($this->getServerResponse(), 0, 3) != '220') {
                return false;
            }
            stream_socket_enable_crypto($this->conn, true, STREAM_CRYPTO_METHOD_TLS_CLIENT);
            fputs($this->conn, 'HELO ' . $this->localhost . $this->newline);
            if (substr($this->getServerResponse(), 0, 3) != '250') {
                return false;
            }
        }
        if ($this->server != 'localhost') {
            fputs($this->conn, 'AUTH LOGIN' . $this->newline);
            if (substr($this->getServerResponse(), 0, 3) != '334') {
                return false;
            }
            fputs($this->conn, base64_encode($this->username) . $this->newline);
            if (substr($this->getServerResponse(), 0, 3) != '334') {
                return false;
            }
            fputs($this->conn, base64_encode($this->password) . $this->newline);
            if (substr($this->getServerResponse(), 0, 3) != '235') {
                return false;
            }
        }
        return true;
    }

    /* send the email message */

    public function send($from, $to, $subject, $message, $headers = null) {
        /* set up the headers and message body with attachments if necessary */
        $email = "Date: " . date("D, j M Y G:i:s") . " -0500" . $this->newline;
        $email .= "From: $from" . $this->newline;
        $email .= "Reply-To: $from" . $this->newline;
        $email .= $this->setRecipients($to);

        if ($headers != null) {
            $email .= $headers . $this->newline;
        }

        $email .= "Subject: $subject" . $this->newline;
        $email .= "MIME-Version: 1.0" . $this->newline;
        if ($this->contentType == "multipart/mixed") {
            $boundary = $this->generateBoundary();
            $message = $this->multipartMessage($message, $boundary);
            $email .= "Content-Type: $this->contentType;" . $this->newline;
            $email .= "    boundary=\"$boundary\"";
        } else {
            $email .= "Content-Type: $this->contentType; charset=$this->charset";
        }
        $email .= $this->newline . $this->newline . $message . $this->newline;
        $email .= "." . $this->newline;

        /* set up the server commands and send */
        fputs($this->conn, 'MAIL FROM: <' . $this->getMailAddr($from) . '>' . $this->newline);
        $this->getServerResponse();

        if (!$to == '') {
            fputs($this->conn, 'RCPT TO: <' . $this->getMailAddr($to) . '>' . $this->newline);
            $this->getServerResponse();
        }
        $this->sendRecipients($this->recipients);
        $this->sendRecipients($this->cc);
        $this->sendRecipients($this->bcc);

        fputs($this->conn, 'DATA' . $this->newline);
        $this->getServerResponse();
        fputs($this->conn, $email);  /* transmit the entire email here */
        if (substr($this->getServerResponse(), 0, 3) != '250') {
            return false;
        }
        return true;
    }

    private function setRecipients($to) { /* assumes there is at least one recipient */
        $r = 'To: ';
        if (!($to == '')) {
            $r .= $to . ',';
        }
        if (count($this->recipients) > 0) {
            for ($i = 0; $i < count($this->recipients); $i++) {
                $r .= $this->recipients[$i] . ',';
            }
        }
        $r = substr($r, 0, -1) . $this->newline;  /* strip last comma */;
        if (count($this->cc) > 0) { /* now add in any CCs */
            $r .= 'CC: ';
            for ($i = 0; $i < count($this->cc); $i++) {
                $r .= $this->cc[$i] . ',';
            }
            $r = substr($r, 0, -1) . $this->newline;  /* strip last comma */
        }
        return $r;
    }

    private function sendRecipients($r) {
        if (empty($r)) {
            return;
        }
        for ($i = 0; $i < count($r); $i++) {
            fputs($this->conn, 'RCPT TO: <' . $this->getMailAddr($r[$i]) . '>' . $this->newline);
            $this->getServerResponse();
        }
    }

    public function addRecipient($recipient) {
        $this->recipients[] = $recipient;
    }

    public function clearRecipients() {
        unset($this->recipients);
        $this->recipients = array();
    }

    public function addCC($c) {
        $this->cc[] = $c;
    }

    public function clearCC() {
        unset($this->cc);
        $this->cc = array();
    }

    public function addBCC($bc) {
        $this->bcc[] = $bc;
    }

    public function clearBCC() {
        unset($this->bcc);
        $this->bcc = array();
    }

    public function addAttachment($filePath) {
        $this->attachments[] = $filePath;
    }

    public function clearAttachments() {
        unset($this->attachments);
        $this->attachments = array();
    }

    /* Quit and disconnect */

    function __destruct() {
        fputs($this->conn, 'QUIT' . $this->newline);
        $this->getServerResponse();
        fclose($this->conn);
    }

    /* private functions used internally */

    private function getServerResponse() {
        $data = "";
        while ($str = fgets($this->conn, 4096)) {
            $data .= $str;
            if (substr($str, 3, 1) == " ") {
                break;
            }
        }
        if ($this->debug)
            echo $data . "<br>";
        return $data;
    }

    private function getMailAddr($emailaddr) {
        $addr = $emailaddr;
        $strSpace = strrpos($emailaddr, ' ');
        if ($strSpace > 0) {
            $addr = substr($emailaddr, $strSpace + 1);
            $addr = str_replace("<", "", $addr);
            $addr = str_replace(">", "", $addr);
        }
        return $addr;
    }

    private function randID($len) {
        $index = "abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $out = "";
        for ($t = 0; $t < $len; $t++) {
            $r = rand(0, 61);
            $out = $out . substr($index, $r, 1);
        }
        return $out;
    }

    private function generateBoundary() {
        $boundary = "--=_NextPart_000_";
        $boundary .= $this->randID(4) . "_";
        $boundary .= $this->randID(8) . ".";
        $boundary .= $this->randID(8);
        return $boundary;
    }

    private function multipartMessage($htmlpart, $boundary) {
        if ($this->altBody == "") {
            $this->altBody = strip_html_tags($htmlpart);
        }
        $altBoundary = $this->generateBoundary();
        ob_start(); //Turn on output buffering
        $parts = "This is a multi-part message in MIME format." . $this->newline . $this->newline;
        $parts .= "--" . $boundary . $this->newline;

        $parts .= "Content-Type: multipart/alternative;" . $this->newline;
        $parts .= "    boundary=\"$altBoundary\"" . $this->newline . $this->newline;

        $parts .= "--" . $altBoundary . $this->newline;
        $parts .= "Content-Type: text/plain; charset=$this->charset" . $this->newline;
        $parts .= "Content-Transfer-Encoding: $this->transferEncodeing" . $this->newline . $this->newline;
        $parts .= $this->altBody . $this->newline . $this->newline;

        $parts .= "--" . $altBoundary . $this->newline;
        $parts .= "Content-Type: text/html; charset=$this->charset" . $this->newline;
        $parts .= "Content-Transfer-Encoding: $this->transferEncodeing" . $this->newline . $this->newline;
        $parts .= $htmlpart . $this->newline . $this->newline;

        $parts .= "--" . $altBoundary . "--" . $this->newline . $this->newline;

        if (count($this->attachments) > 0) {
            for ($i = 0; $i < count($this->attachments); $i++) {
                $attachment = chunk_split(base64_encode(file_get_contents($this->attachments[$i])));
                $filename = basename($this->attachments[$i]);
                $ext = pathinfo($filename, PATHINFO_EXTENSION);
                $parts .= "--" . $boundary . $this->newline;
                $parts .= "Content-Type: application/$ext; name=\"$filename\"" . $this->newline;
                $parts .= "Content-Transfer-Encoding: base64" . $this->newline;
                $parts .= "Content-Disposition: attachment; filename=\"$filename\"" . $this->newline . $this->newline;
                $parts .= $attachment . $this->newline;
            }
        }

        $parts .= "--" . $boundary . "--";

        $message = ob_get_clean(); //Turn off output buffering
        return $parts;
    }

}

function my_mailer($server, $port, $username = null, $password = null, $secure = null) {
    return new mailer($server, $port, $username, $password, $secure);
}

?>