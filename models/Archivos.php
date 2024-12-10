<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\UploadedFile; // Asegúrate de importar esta clase

class Archivos extends ActiveRecord
{
    // Define una propiedad temporal para manejar el archivo cargado
    public $archivo; // Esta es la propiedad que usaremos para cargar el archivo

    /**
     * Define el nombre de la tabla asociada.
     */
    public static function tableName()
    {
        return 'archivos'; // Nombre exacto de tu tabla en la base de datos
    }

    /**
     * Reglas de validación.
     */
    public function rules()
    {
        return [
            [['nombreA', 'tipoA', 'ruta', 'usuarioID', 'fechaSubi'], 'required'], // Ajusta según las columnas obligatorias
            [['nombreA', 'tipoA', 'ruta'], 'string', 'max' => 255], // Longitudes de las columnas
            [['usuarioID'], 'integer'],
            [['fechaSubi'], 'datetime', 'format' => 'php:Y-m-d H:i:s'], // Si es un campo de fecha y hora
            [['archivo'], 'file', 'extensions' => 'png, jpg, jpeg, pdf', 'maxSize' => 1024 * 1024 * 10], // Validación del archivo (ej. tamaño y extensiones)
        ];
    }

    /**
     * Etiquetas de los atributos.
     */
    public function attributeLabels()
    {
        return [
            'archivoID' => 'ID del Archivo',
            'nombreA' => 'Nombre del Archivo',
            'tipoA' => 'Tipo de Archivo',
            'ruta' => 'Ruta del Archivo',
            'usuarioID' => 'ID del Usuario',
            'fechaSubi' => 'Fecha de Subida',
        ];
    }
}



