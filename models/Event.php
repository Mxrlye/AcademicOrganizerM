<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

class Event extends ActiveRecord
{
    /**
     * Define el nombre de la tabla en la base de datos
     */
    public static function tableName()
    {
        return 'eventos'; // Nombre de la tabla en la base de datos
    }

    /**
     * Define la clave primaria de la tabla
     */
    public static function primaryKey()
    {
        return ['eventoID']; // Define 'eventoID' como clave primaria
    }

    /**
     * Define las reglas de validación para el modelo
     */
    public function rules()
    {
        return [
            [['usuarioID', 'titulo', 'fecha', 'hora_inicio', 'hora_fin'], 'required'], // Campos obligatorios
            ['fecha', 'date', 'format' => 'php:Y-m-d'], // Validación de formato de fecha
            [['hora_inicio', 'hora_fin'], 'match', 'pattern' => '/^(?:2[0-3]|[01][0-9]):[0-5][0-9]$/'], // Validación de hora
            [['usuarioID'], 'integer'], // usuarioID debe ser un entero
            [['titulo'], 'string', 'max' => 255], // Longitud máxima para el título
            [['descripcion'], 'string'], // Descripción es un texto libre
        ];
    }

    /**
     * Define los comportamientos del modelo, como las fechas de creación y actualización automáticas
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'creado_en', // Columna para la fecha de creación
                'updatedAtAttribute' => 'actualizado_en', // Columna para la fecha de actualización
                'value' => function () {
                    return date('Y-m-d H:i:s'); // Guarda la fecha y hora actual
                },
            ],
        ];
    }

    /**
     * Define una relación con el modelo Usuario
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuario::class, ['usuarioID' => 'usuarioID']);
    }
}
