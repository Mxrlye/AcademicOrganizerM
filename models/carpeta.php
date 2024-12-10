<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

class Carpeta extends ActiveRecord
{
    /**
     * Especifica el nombre de la tabla asociada.
     */
    public static function tableName()
    {
        return 'carpetas'; // Nombre de la tabla 'carpetas'
    }

    /**
     * Define las reglas de validación de los atributos.
     */
    public function rules()
    {
        return [
            [['nombreC', 'usuarioID', 'fechaC'], 'required'], // Validaciones de campos obligatorios
            [['usuarioID'], 'integer'], // Validar que usuarioID sea un entero
            [['fechaC'], 'safe'], // Aceptar fechas válidas
            [['nombreC'], 'string', 'max' => 255], // Validar longitud máxima del nombre
        ];
    }

    public function attributeLabels()
    {
        return [
            'carpetaID' => 'ID Carpeta',
            'nombreC' => 'Nombre de la Carpeta',
            'usuarioID' => 'ID del Usuario',
            'fechaC' => 'Fecha de Creación',
        ];
    }
    /**
     * Relación con el modelo Usuario.
     * Una carpeta pertenece a un solo usuario.
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuario::class, ['usuarioID' => 'usuarioID']);
    }

    /**
     * Comportamientos adicionales para la fecha de creación.
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'fechaC', // Establece automáticamente la fecha de creación
                'updatedAtAttribute' => false, // No actualiza automáticamente la fecha de modificación
                'value' => new Expression('NOW()'), // Usa la fecha y hora actual de la base de datos
            ],
        ];
    }
}
