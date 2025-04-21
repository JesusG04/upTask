<?php

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email
{
    protected $email;
    protected $nombre;
    protected $token;

    public function __construct($email, $nombre, $token) {
        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;
    }


    public function enviarConfirmacion (){
        //Creamos el objeto de email
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'sandbox.smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = 'd284ffd566a035';
        $mail->Password = 'cdb392fd492316';

        $mail->setFrom('cuantas@uptask.com','Uptask.com');
        $mail->addAddress('cuantas@uptask.com','Uptask');
        $mail->Subject = 'Confirma tu cuenta';

        //set HTML
        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';

        
        $contenido = "<html>";
        $contenido .= "<p><strong>Hola ".$this->nombre ."</strong> Has creado tu cuenta en UpTask, solo debes confirmala presionando el siguiente enlace</p>";
        $contenido .="<p>Presiona aqui: <a href='http://localhost:3000/confirm?token=". $this->token."'> Confirmar Cuenta</a> </p>";
        $contenido .="<p>Si tu no creaste esta cuenta, puedes ignorar el mensaje</p>";
        $contenido .= "</html>";


        $mail->Body = $contenido;
        $mail->send();
    }
    public function enviarInstrucciones (){
        //Creamos el objeto de email
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'sandbox.smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = 'd284ffd566a035';
        $mail->Password = 'cdb392fd492316';

        $mail->setFrom('cuantas@uptask.com','Uptask.com');
        $mail->addAddress('cuantas@uptask.com','Uptask');
        $mail->Subject = 'Restablece tu Contraseña';

        //set HTML
        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';

        
        $contenido = "<html>";
        $contenido .= "<p><strong>Hola ".$this->nombre ."</strong> Has solicitado reestablecer tu contraseña, sigue el siguiente enlace para hacerlo.</p>";
        $contenido .="<p>Presiona aqui: <a href='http://localhost:3000/recover?token=". $this->token."'>Reestablecer Contraseña</a> </p>";
        $contenido .="<p>Si tu no solicitaste este cambio, puedes ignorar el mensaje</p>";
        $contenido .= "</html>";


        $mail->Body = $contenido;
        $mail->send();
    }
}
