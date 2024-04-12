<?php

namespace Controller;

use Slim\Psr7\Request as Request;
use Slim\Psr7\Response as Respone;
use PHPMailer\PHPMailer\PHPMailer;

use Service\MailSenderService;
use Firebase\JWT\JWT;
use Exception;
use Storage\AccountStorage;

class MailSenderController
{
	private MailSenderService $service;

	public function __construct(MailSenderService $service)
	{
		$this->service = $service;
	}

	public function sendOTP(Request $req, Respone $res)
	{
		$body = $req->getBody()->getContents();
		$data = json_decode($body);
		$mail = new PHPMailer(true);
		$otp = rand(1000, 9999);
		try {
			$mail->isSMTP();
			// Cấu hình SMTP server
			$mail->Host       = 'smtp.gmail.com';
			$mail->SMTPAuth   = true;
			$mail->Username   = 'proma.verify@gmail.com';
			$mail->Password   = 'dzvi xxre mbnf jaaq';
			$mail->SMTPSecure = 'ssl';
			$mail->Port       = 465;

			$mail->setFrom('proma.verify@gmail.com', 'Proma');
			$mail->addAddress($data->email);

			$mail->isHTML(true);
			$mail->Subject = 'Sign up proma';
			$mail->Body    = 'Your OTP is: ' . $otp;

			$this->service->CreateOTP($otp, $data->email);
			$mail->send();

			$res = $res->withStatus(200);
			$res->getBody()->write("Sent successfully");
			return $res;

		} catch (Exception $e) {
			if ($e->getCode() == 400) {
				$res = $res->withStatus(400);
				$res->getBody()->write($e->getMessage());
			}else if($e->getCode() == 409){
				$res = $res->withStatus(409);
				$res->getBody()->write($e->getMessage());
			}else {
				$res = $res->withStatus(500);
				$res->getBody()->write($e->getMessage());
			}
			return $res;
		}
	}

	public function verifyOtp(Request $req, Respone $res)
	{
		$body = $req->getBody()->getContents();
		$data = json_decode($body);
		$email = $data->email;
		$otp = $data->otp;
		try {
			$this->service->verifyOtp($email, $otp);
			$payload = array(
				"email" => $email,
				"exp" => time() + 3600
			);

			$jwt = JWT::encode($payload, "L939sdj9-jejjdej-j3j3", 'HS256');
			$res = $res->withStatus(200);
			$res->getBody()->write(json_encode(array(
				"token" => $jwt
			)));
			return $res;
		} catch(Exception $e) {
			if ($e->getCode() == 404) {
				$res = $res->withStatus(404);
			}
			elseif ($e->getCode() == 401) {
				$res = $res->withStatus(401);
			} else {
				$res = $res->withStatus(500);
			}
			$res->getBody()->write($e->getMessage());
			return $res;
		}
	}
}
