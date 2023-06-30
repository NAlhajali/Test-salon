<?php 

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class  Email {

    public $email;
    public $nombre;
    public $token;

    public function __construct($email, $nombre, $token)
    {
        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;
    }

    public function enviarConfirmacion() {
        // Crear el objeto de email

        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'sandbox.smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = 'f385995f2d3085';
        $mail->Password = '250f75415a6126';

        $mail->setFrom('cuentas@appsalon.com');
        $mail->addAddress('cuentas@appsalon.com', 'AppSalon.com');
        $mail->Subject = 'Confirma tu cuenta';

        // Set HTML
        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';
        
        $contenido = "<html>";
$contenido .= "<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@500;700&display=swap');
    h2 {
        font-size: 25px;
        font-weight: 500;
        line-height: 25px;
    }

    body {
        font-family: 'Poppins', sans-serif;
        background-color: #ffffff;
        max-width: 400px;
        margin: 0 auto;
        padding: 20px;
    }

    p {
        line-height: 18px;
    }

    a {
        position: relative;
        z-index: 0;
        display: inline-block;
        margin: 20px 0;
    }

    a button {
        padding: 0.7em 2em;
        font-size: 16px !important;
        font-weight: 500;
        background: #000000;
        color: #ffffff;
        border: none;
        text-transform: uppercase;
        cursor: pointer;
    }
    p span {
        font-size: 12px;
    }
    div p{
        border-bottom: 1px solid #000000;
        border-top: none;
        margin-top: 40px;
    }
</style>";
$contenido .= "<body>";
$contenido .= "<h1>Barba y Bigotes</h1>";
$contenido .= "<h2>¡Gracias por registrarte!</h2>";
$contenido .= "<p>Hola " . $this->nombre . " Por favor confirma tu correo electrónico para que puedas comenzar a disfrutar de todos los servicios de Barba y bigotes</p>";
$contenido .= "<a href='http://localhost:3000/confirmar-cuenta?token=" . $this->token . "'><button>Verificar</button></a>";
$contenido .= "<p>Si tú no te registraste en Barba y Bigotes, por favor ignora este correo electrónico.</p>";
$contenido .= "<div><p></p></div>";
$contenido .= "<p><span>Este correo electrónico fue enviado desde una dirección solamente de notificaciones que no puede aceptar correo electrónico entrante. Por favor no respondas a este mensaje.</span></p>";
$contenido .= "</body>";
$contenido .= "</html>";

$mail->Body = $contenido;

        //Enviar el email
        $mail->send();
    }
    public function enviarInstrucciones() {
        // create a new object

    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->Host = 'sandbox.smtp.mailtrap.io';
    $mail->SMTPAuth = true;
    $mail->Port = 2525;
    $mail->Username = 'f385995f2d3085';
    $mail->Password = '250f75415a6126';

    $mail->setFrom('cuentas@appsalon.com');
    $mail->addAddress('cuentas@appsalon.com', 'AppSalon.com');
    $mail->Subject = 'Restablece tu contraseña';

    // Set HTML
    $mail->isHTML(TRUE);
    $mail->CharSet = 'UTF-8';

    $contenido = "<html>";
    $contenido .= "<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@500;700&display=swap');
    h2 {
    font-size: 25px;
    font-weight: 500;
    line-height: 25px;
    }

    body {
    font-family: 'Poppins', sans-serif;
    background-color: #ffffff;
    max-width: 400px;
    margin: 0 auto;
    padding: 20px;
    }

    p {
    line-height: 18px;
    }

    a {
    position: relative;
    z-index: 0;
    display: inline-block;
    margin: 20px 0;
    }

    a button {
    padding: 0.7em 2em;
    font-size: 16px !important;
    font-weight: 500;
    background: #000000;
    color: #ffffff;
    border: none;
    text-transform: uppercase;
    cursor: pointer;
    }
    p span {
    font-size: 12px;
    }
    div p{
    border-bottom: 1px solid #000000;
    border-top: none;
    margin-top: 40px;
    }
    </style>";
    $contenido .= "<body>";
    $contenido .= "<h1>Barba y Bigotes</h1>";
    $contenido .= "<h2>Has solicitado restablecer tu contraseña</h2>";
    $contenido .= "<p> Hola " . $this->nombre . " Has Solicitado restablecer tu password, da click en el siguiente enlace para restablecer tu contraseña</p>";
    $contenido .= "<a href='http://localhost:3000/recuperar?token=" . $this->token . "'><button>Restablecer Contraseña</button></a>";
    $contenido .= "<p>Si tú no solicitaste este cambio, ignora el mensaje.</p>";
    $contenido .= "<div><p></p></div>";
    $contenido .= "<p><span>Este correo electrónico fue enviado desde una dirección solamente de notificaciones que no puede aceptar correo electrónico entrante. Por favor no respondas a este mensaje.</span></p>";
    $contenido .= "</body>";
    $contenido .= "</html>";

    $mail->Body = $contenido;

    //Enviar el email
    $mail->send();
    }


}