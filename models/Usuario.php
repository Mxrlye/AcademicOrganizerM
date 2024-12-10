<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Usuario extends ActiveRecord
{
    /**
     * Especifica el nombre de la tabla asociada si no sigue la convención de nombres.
     */
    public static function tableName()
    {
        return 'usuario'; // Nombre de la tabla 'usuario'
    }

    /**
     * Define las reglas de validación de los atributos.
     */
    public function rules()
    {
        return [
            [['nombreU', 'nombres', 'apellidos', 'correo', 'contraseña', 'auth_key'], 'required'],
            [['nombreU', 'nombres', 'apellidos'], 'string', 'max' => 255],
            [['correo'], 'email'],
            [['contraseña'], 'string', 'min' => 6],
            [['auth_key'], 'string', 'max' => 32],
            [['genero'], 'string', 'max' => 1],
            [['telefono'], 'string', 'max' => 20],
        ];
    }

    /**
     * Relación con el modelo Carpeta (Un usuario tiene muchas carpetas).
     */
    public function getCarpetas()
    {
        return $this->hasMany(Carpeta::class, ['usuarioID' => 'usuarioID']);
    }
}
