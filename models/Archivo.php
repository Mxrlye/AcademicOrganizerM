<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Archivo extends ActiveRecord
{
    /**
     * Especifica el nombre de la tabla asociada.
     */
    public static function tableName()
    {
        return 'archivos'; // Nombre de la tabla en la base de datos
    }

    /**
     * Reglas de validación.
     */
    public function rules()
    {
        return [
            [['nombreA', 'tipoA', 'ruta', 'fechaSubi', 'usuarioID'], 'required'], // Campos obligatorios
            [['nombreA', 'tipoA', 'ruta'], 'string', 'max' => 255], // Campos de tipo string con longitud máxima
            [['fechaSubi'], 'safe'], // Permitir el manejo de fechas
            [['usuarioID', 'carpetaID'], 'integer'], // Campos de tipo entero
        ];
    }

    /**
     * Nombres de los atributos para etiquetas personalizadas.
     */
    public function attributeLabels()
    {
        return [
            'archivoID' => 'ID del Archivo',
            'nombreA' => 'Nombre del Archivo',
            'tipoA' => 'Tipo de Archivo',
            'ruta' => 'Ruta',
            'fechaSubi' => 'Fecha de Subida',
            'usuarioID' => 'ID del Usuario',
            'carpetaID' => 'ID de la Carpeta',
        ];
    }

    /**
     * Relación con la tabla `carpetas`.
     * Un archivo pertenece a una carpeta opcionalmente.
     */
    public function getCarpeta()
    {
        return $this->hasOne(Carpeta::class, ['carpetaID' => 'carpetaID']);
    }

    /**
     * Relación con la tabla `usuarios`.
     * Un archivo pertenece a un usuario.
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuario::class, ['usuarioID' => 'usuarioID']);
    }

    /**
     * Comportamientos adicionales, como la fecha de creación automática.
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'createdAtAttribute' => 'fechaSubi',
                'updatedAtAttribute' => false, // No actualiza la fecha
                'value' => new \yii\db\Expression('NOW()'), // Valor por defecto: fecha y hora actuales
            ],
        ];
    }

    /**
     * Método para subir un archivo y guardar en la base de datos.
     * @param \yii\web\UploadedFile $archivo El archivo subido
     * @param int|null $carpetaID ID de la carpeta (opcional)
     * @return bool
     */
    public function guardarArchivo($archivo, $carpetaID = null)
    {
        $rutaBase = $carpetaID
            ? Yii::getAlias('@webroot/uploads/carpeta_' . $carpetaID)
            : Yii::getAlias('@webroot/uploads/archivos_generales');
    
        // Crear el directorio si no existe
        if (!is_dir($rutaBase)) {
            mkdir($rutaBase, 0777, true);
        }
    
        $rutaArchivo = $rutaBase . '/' . $archivo->name;
    
        // Guardar el archivo físicamente
        if ($archivo->saveAs($rutaArchivo)) {
            // Guardar los datos del archivo en la base de datos
            $this->nombreA = $archivo->name;
            $this->tipoA = $archivo->type;
            $this->ruta = '/uploads/' . ($carpetaID ? 'carpeta_' . $carpetaID : 'archivos_generales') . '/' . $archivo->name; // Ruta relativa
            $this->fechaSubi = date('Y-m-d H:i:s');
            $this->usuarioID = Yii::$app->user->id;
            $this->carpetaID = $carpetaID;
    
            return $this->save(); // Guardar en la base de datos
        }
    
        return false;
    }
    
}
