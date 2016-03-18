<?php

header('Content-Type: application/json');

header("Access-Control-Allow-Origin: *");

if (isset($_SERVER['HTTP_ORIGIN'])) {
	header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
	header("Access-Control-Allow-Origin: *");
	header('Access-Control-Allow-Credentials: true');
	header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
}

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
	if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
		header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
	if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
		header("Access-Control-Allow-Headers:{$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

	exit(0);
}

require '../PHPMailer/PHPMailerAutoload.php';
require '../Response.php';

class OaiResponse extends Response {

	public $cName;
	public $cPhone;
	public $cEmail;
	public $cAddress;
	public $cCity;
	public $cMessage;

	public $mailer;

	/**
	 * Response constructor.
	 * @param $get {array}
	 * @param $mailer {PHPMailer}
	 * @internal param bool $sent
	 */
	public function __construct($get, $mailer)
	{

		$this->cName = $get['cName'];
		$this->cPhone = $get['cPhone'];
		$this->cEmail = $get['cEmail'];
		$this->cAddress = $get['cAddress'];
		$this->cCity = $get['cCity'];
		$this->cMessage = $get['cMessage'];

		$this->mailer = $mailer;

	}

}

// create new instance
$mailer = new PHPMailer;

// set charset
$mailer->CharSet = 'UTF-8';

//$mailer->SMTPDebug = 3;

// set header
$mailer->isSMTP();
$mailer->Host = 'box729.bluehost.com';
$mailer->SMTPAuth = true;
$mailer->Username = 'mailman@letsmowe.com';
$mailer->Password = '64op3gZxONGO';
$mailer->SMTPSecure = 'ssl';
$mailer->Port = 465;

// set from, to and carbon copy (hidden)
$mailer->setFrom('mailman@letsmowe.com', 'OAI Telecom - MailMan');
$mailer->addAddress('site@oai.com.br', 'OAI Telecom');
$mailer->addBCC('joseeduardobarros@gmail.com', 'Eduardo');    // Send to Developer (test)
$mailer->addBCC('rafael@kabanas.info', 'Rafael');             // Send to Developer (test)

// set type, subject and body
$mailer->isHTML(true);
$mailer->Subject = 'Requisição de contato - OAI Telecom';

$mailer->Body = "Foi realizado um pedido de contato pelo site!<br/>";
$mailer->Body .= "Nome: <b>" . $_GET['cName'] . "</b><br/>";
$mailer->Body .= "Telefone: <b>" . $_GET['cPhone'] . "</b><br/>";
$mailer->Body .= "E-mail: <b>" . $_GET['cEmail'] . "</b><br/>";
$mailer->Body .= "Endereço: <b>" . $_GET['cAddress'] . "</b><br/>";
$mailer->Body .= "Cidade: <b>" . $_GET['cCity'] . "</b><br/>";
$mailer->Body .= "Mensagem: <b>" . $_GET['cMessage'] . "</b><br/>";

$mailer->AltBody = 'Nome: ' . $_GET['cName'] . 'Telefone: ' . $_GET['cPhone'] . 'E-mail ' . $_GET['cEmail'] . 'Mensagem ' . $_GET['cMessage'];

// create new instance of response
$response = new OaiResponse($_GET, $mailer);

if ($_GET['cName']) {

	if(!$mailer->send()) {
		$response->setSent(false);
	} else {
		$response->setSent(true);
	}

}

// print response JSON
print_r($response->toJSON());