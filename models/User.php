<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class User extends ActiveRecord implements IdentityInterface
{
    /**
     * Define el nombre de la tabla asociada.
     */
    public static function tableName()
    {
        return 'usuario'; // Cambia este nombre si tu tabla tiene otro nombre
    }

    /**
     * Encuentra un usuario por su ID.
     */
    public static function findIdentity($id)
    {
        return static::findOne(['usuarioID' => $id]);
    }

    /**
     * Este método no se usa porque no tienes soporte para tokens de acceso.
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return null; // O implementa lógica si usas autenticación basada en tokens
    }

    /**
     * Encuentra un usuario por nombre de usuario.
     */
    public static function findByUsername($username)
    {
        return static::findOne(['nombreU' => $username]);
    }

    /**
     * Obtiene el ID del usuario.
     */
    public function getId()
    {
        return $this->usuarioID;
    }

    /**
     * Obtiene el valor de `auth_key` (opcional).
     */
    public function getAuthKey()
    {
        return $this->auth_key ?? null;
    }

    /**
     * Valida `auth_key` (opcional).
     */
    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey;
    }

    /**
     * Valida la contraseña ingresada comparándola directamente con la almacenada.
     */
    public function validatePassword($password)
    {
        return $this->contraseña === $password; // Comparación directa sin encriptar
    }

    /**
     * Establece la contraseña sin realizar encriptación.
     */
    public function setPassword($password)
    {
        $this->contraseña = $password; // Almacena la contraseña tal cual
    }

    /**
     * Reglas de validación.
     */
    public function rules()
    {
        return [
            [['nombreU', 'contraseña', 'correo', 'nombres', 'apellidos', 'genero', 'telefono'], 'required'],
            [['nombreU'], 'string', 'max' => 10],
            [['contraseña'], 'string', 'min' => 6, 'max' => 255],
            [['correo'], 'email'],
            [['correo'], 'string', 'max' => 50],
            [['nombres', 'apellidos'], 'string', 'max' => 25],
            [['genero'], 'in', 'range' => ['Masculino', 'Femenino']],
            [['telefono'], 'string', 'max' => 10],
            [['nombreU', 'correo'], 'unique'],
        ];
    }

    /**
     * Etiquetas para los atributos.
     */
    public function attributeLabels()
    {
        return [
            'nombreU' => 'Nombre de Usuario',
            'nombres' => 'Nombres',
            'apellidos' => 'Apellidos',
            'correo' => 'Correo Electrónico',
            'contraseña' => 'Contraseña',
            'genero' => 'Género',
            'telefono' => 'Teléfono',
        ];
    }
}
