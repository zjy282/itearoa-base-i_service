<?php


class Mail_Email
{

    const ADDRESS_BCC = 'iservice@liheinfo.com';
    const ADDRESS_CC = 'iservice@liheinfo.com';

    /**
     * @var Mail_Email
     */
    private static $_instance;

    /**
     * @var Mail_PHPMailer
     */
    private $_mail;

    private function __construct($type)
    {
        $mailConfig = Yaf_Registry::get('sysConfig')['mail'];
        $params['driver'] = $mailConfig['driver'];
        $params['host'] = $mailConfig['host'];
        $params['port'] = intval($mailConfig['port']);
        $params['username'] = $mailConfig['username'];
        $params['password'] = $mailConfig['password'];
        $params['timeout'] = intval($mailConfig['timeout']);
        $params['encryption'] = $mailConfig['encryption'];
        $params['auth'] = true;

        $mail = new Mail_PHPMailer(true);
        switch ($type) {
            case 'smtp':
                $mail->isSMTP();
                break;
            default:
                $mail->isSMTP();
        }
        // Set mailer to use SMTP
        $mail->Host = $params['host'];  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = $params['username'];                 // SMTP username
        $mail->Password = $params['password'];                           // SMTP password
        $mail->SMTPSecure = $mailConfig['encryption'];                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = $params['port'];                                    // TCP port to connect to
        $mail->CharSet = 'utf-8';
        $mail->isHTML(true);                                  // Set email format to HTML

        //Recipients
        $mail->setFrom($params['username'], 'iService');
        $this->_mail = $mail;
    }

    public static function getInstance($type = 'smtp')
    {
        if (!self::$_instance instanceof self) {
            self::$_instance = new self($type);
        }
        return self::$_instance;
    }


    /**
     * Send email
     *
     * @param array $toArray
     * @param string $subject
     * @param string $htmlMessage
     * @param string $plainMsg
     * @throws Exception
     */
    public function send($toArray = array('name@example.com' => 'Frank'),
                         $subject = 'Subject of the mail',
                         $htmlMessage = 'Message of the body, can be HTML', $plainMsg = '')
    {
        try {
            $mail = $this->_mail;
            foreach ($toArray as $mailAddress => $name) {
                $mail->addAddress($mailAddress, $name);
            }
            //$mail->addReplyTo('info@example.com', 'Information');
            //Content
            $mail->Subject = $subject;
            $mail->Body = $htmlMessage;
            $mail->AltBody = $plainMsg;
            $mail->send();
        } catch (Exception $e) {
            throw new Exception($mail->ErrorInfo);
        }

    }

    /**
     * Add Bcc
     *
     * @param $address
     * @param $name
     */
    public function addBcc($address, $name = '')
    {
        $this->_mail->addBCC($address, $name);
    }

    /**
     * Add Cc
     *
     * @param $address
     * @param string $name
     */
    public function addCc($address, $name = '')
    {
        $this->_mail->addCC($address, $name);
    }

    /**
     * Add attachment
     *
     * @param $path
     * @param string $newName
     */
    public function addAttachment($path, $newName = '')
    {
        $this->_mail->addAttachment($path, $newName);
    }

}
