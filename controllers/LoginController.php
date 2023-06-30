<?php 

namespace Controllers;

use Classes\Email;
use Model\Usuario;
use MVC\Router;

class LoginController {
    public static function login(Router $router) {
        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth = new Usuario($_POST);

            $alertas = $auth->validarLogin();
            if(empty($alertas)) {
                //Comprobar que exista el usuario 
                $usuario = Usuario::where('email', $auth->email);

                if($usuario) {
                    //Verificar usuario
                   if( $usuario->comprobarPasswordAndVerificado($auth->password) ) {
                        // Autenticar el usuario
                        if(!isset($_SESSION)) {
                            session_start();
                        };

                        $_SESSION['id'] = $usuario->id;
                        $_SESSION['nombre'] = $usuario->nombre . " " . $usuario->apellido;
                        $_SESSION['email'] = $usuario->email;
                        $_SESSION['login'] = true;

                        //Redireccionamiento
                        if($usuario->admin === "1") {
                            $_SESSION['admin'] = $usuario->admin ?? null;
                            header('Location: /admin');
                        }else {
                            header('Location: /cita');
                        }
                   }
                }else {
                    Usuario::setAlerta('error', 'Usuario no registrado');
                }
            }
        }
        $alertas = Usuario::getAlertas();

            $router->render('auth/login', [
                'alertas' => $alertas
            ]);
    }

    public static function logout() {
        if(!isset($_SESSION)) {
            session_start();
        };
   
        $_SESSION = [];
        header('Location: /');
    }

    public static function olvide(Router $router) {

        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth = new Usuario($_POST);
            $alertas = $auth->validarEmail();

            if(empty($alertas)) {
                $usuario = Usuario::where('email', $auth->email);
                if($usuario && $usuario->confirmado === "1") {

                    //Generar un nuevo toker para (olvido de contrasena)
                    $usuario->crearToken();
                    $usuario->guardar();
                    //Enviar el email con el token nuevo
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email->enviarInstrucciones();

                    //Alerta de exito
                    Usuario::setAlerta('exito', 'Se ha enviado un correo a tu email para recuperacion de contraseña');
                }else {
                    Usuario::setAlerta('error', 'El usuario no existe o no esta confrimado');
                }
            }
        }
        $alertas = Usuario::getAlertas();

        $router->render('auth/olvide-password', [
            'alertas'=> $alertas
        ]);
        
    }
    //Recuperar contrase;a
    public static function recuperar(Router $router) {
        $alertas = [];
        $error = false;

        $token = s($_GET['token']);
        //Buscar usuario por su token en bd
        $usuario = Usuario::where('token', $token);
        
        if(empty($usuario)) {
            Usuario::setAlerta('error', 'Token no valido');
            $error = true;
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            //Leer el nuevo password y guardarlo
            $password = new Usuario($_POST);
            $alertas = $password->validarPassword();

            if(empty($alertas)) {
                $usuario->password = null; //elimina el password anterior
                $usuario->password = $password->password; // crea la nueva contrasena
                $usuario->hashPassword(); // hashea de nuevo la contrasena
                $usuario->token = ''; // eliminar el token 

                $resultado = $usuario->guardar(); // guarda la nueva contrase;a
                if($resultado) {
                    header('Location: /'); // redirecciona para que incie sesion
                }
            }
            
        }
        $alertas = Usuario::getAlertas();
       $router->render('auth/recuperar-password', [
            'alertas' => $alertas,
            'error' => $error
       ]);
    }

    //crear la cuenta y sus validaciones 
    public static function crear( Router $router) {
        $usuario = new Usuario;

        //Alertas vacias
        $alertas = [];
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
           $usuario->sincronizar($_POST);
           $alertas = $usuario->validarNuevaCuenta(); 

           //Revisar que alerta este vacio 
           if(empty($alertas)) {
            //Verificar que el usuario no este registrado
            $resultado = $usuario->existeUsuario();

            if($resultado->num_rows) {
                $alertas = Usuario::getAlertas();
            }else {
                //Hashear el password // SE CREA en usuario la funcion
                $usuario->hashPassword();

                //Generar token unico
                $usuario->crearToken();

                //Enviar el email
                $email = new Email ($usuario->nombre, $usuario->email, 
                $usuario->token);
                $email->enviarConfirmacion();

                //Crear el usuario 
                $resultado = $usuario->guardar();
                if($resultado) {
                    header('Location: /mensaje');
                }
                
                // debuguear($usuario);
            }
            
           }
        }
    // Muestra en vista 
       $router->render('auth/crear-cuenta', [
            'usuario' => $usuario,
            'alertas' => $alertas
       ]) ;
    }

    public static function mensaje(Router $router) {
        
        $router->render('auth/mensaje');
    }
    
    public static function confirmar(Router $router) {
        $alertas = [];

        $token = s($_GET['token']);

        $usuario = Usuario::where('token', $token); 
        
        if(empty($usuario)) {
            // Mostrar mensaje de error
            Usuario::setAlerta('error', "Token no válido");
        }else {
            //Modificar a usuario confirmado
            $usuario->confirmado = "1";
            $usuario->token = '';
            $usuario->guardar();
            Usuario::setAlerta('exito', 'Cuenta verificada');
        }
        // Obtener alertas
        $alertas = Usuario::getAlertas();

        //Rebderizar la vista 
        $router->render('auth/confirmar-cuenta', [
            'alertas' => $alertas 
        ]);
    }
}