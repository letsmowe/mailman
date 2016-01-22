<?php

header('Content-Type: application/json');

require '../PHPMailer/PHPMailerAutoload.php';
require '../Response.php';

class WtalResponse extends Response {

    public $name;
    public $city;
    public $phone;
    public $product;
    public $reference;
	public $mail;

	/**
	 * Response constructor.
	 * @param $get {array}
	 * @param $mailer {PHPMailer}
	 * @internal param bool $sent
	 */
	public function __construct($get, $mailer)
	{
		$this->mail = $get['mail'];
        $this->name = $get['name'];
        $this->phone = $get['phone'];
        $this->city = $_GET['city'];
        $this->product = $_GET['product'];
        $this->reference = $_GET['reference'];

        $this->mailer = $mailer;
	}

}

// create new instance
$mailer = new PHPMailer;

// set charset
$mailer->CharSet = 'UTF-8';

$mailer->SMTPDebug = 3;

// set header
$mailer->isSMTP();
$mailer->Host = 'box729.bluehost.com';
$mailer->SMTPAuth = true;
$mailer->Username = 'mailman@letsmowe.com';
$mailer->Password = '64op3gZxONGO';
$mailer->SMTPSecure = 'ssl';
$mailer->Port = 465;

// set from, to and carbon copy (hidden)
$mailer->setFrom('mailman@letsmowe.com', 'Webtal Telecom - MailMan');
$mailer->addAddress('joseeduardobarros@gmail.com', 'Eduardo');    // Send to Developer (test)
$mailer->addAddress('rafael@kabanas.info', 'Webtal');
//$mailer->addAddress($_GET['mail'], $_GET['name']);
$mailer->addBCC('joseeduardobarros@gmail.com', 'Eduardo Barros');

// set type, subject and body
$mailer->isHTML(true);
$mailer->Subject = 'Requisição de contato - Webtal Telecom';
$mailer->Body = 'Foi realizado um pedido de contato pelo site!.<br/>';
$mailer->AltBody = 'Foi realizado um pedido de contato pelo site!.<br/>';

// create new instance of response
$response = new WtalResponse($_GET, $mailer);

// send
if(!$mailer->send()) {
	$response->setSent(false);
} else {
	$response->setSent(true);
}

// print response JSON
print_r($response->toJSON());
