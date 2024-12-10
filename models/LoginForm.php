<?php

namespace app\models;

use Yii;
use yii\base\Model;

class LoginForm extends Model
{
    public $username; // Campo para el nombre de usuario
    public $password; // Campo para la contraseña
    public $rememberMe = true; // Recordar sesión (opcional)

    private $_user = false; // Propiedad privada para almacenar el usuario

    /**
     * Reglas de validación para el formulario
     */
    public function rules()
    {
        return [
            [['username', 'password'], 'required'], // Ambos campos son obligatorios
            ['rememberMe', 'boolean'], // El checkbox es un valor booleano
            ['password', 'validatePassword'], // Validación personalizada para la contraseña
        ];
    }

    /**
     * Valida la contraseña ingresada.
     * Este método se utiliza como una regla de validación personalizada.
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) { // Solo si no hay otros errores
            $user = $this->getUser(); // Obtiene el usuario desde la base de datos

            // Valida la contraseña utilizando el método del modelo User
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Usuario o contraseña incorrectos.'); // Error en caso de falla
            }
        }
    }

    /**
     * Inicia sesión en la aplicación utilizando los datos del formulario.
     * @return bool Si el inicio de sesión fue exitoso
     */
    public function login()
    {
        if ($this->validate()) { // Valida los datos del formulario
            // Inicia sesión en Yii2
            return Yii::$app->user->login(
                $this->getUser(),
                $this->rememberMe ? 3600 * 24 * 30 : 0 // Duración de la sesión
            );
        }
        return false;
    }

    /**
     * Encuentra un usuario por su nombre de usuario.
     * @return User|null El modelo de usuario o null si no se encuentra
     */
    protected function getUser()
    {
        if ($this->_user === false) {
            // Busca al usuario en la base de datos
            $this->_user = User::findByUsername($this->username);
        }
        return $this->_user;
    }
}
