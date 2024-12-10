<?php
namespace app\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;
use app\models\Carpeta;
use app\models\Archivos;

class CarpetaForm extends Model
{
    public $carpeta;
    public $usuarioID;

    // Definimos las reglas de validación para los archivos
    public function rules()
    {
        return [
            [['carpeta'], 'file', 'skipOnEmpty' => false, 'extensions' => 'zip,rar', 'maxFiles' => 100],
            [['usuarioID'], 'required'],
        ];
    }

    // Método para manejar la subida
    public function upload()
{
    if ($this->validate()) {
        // Crear un registro en la tabla "carpetas"
        $carpeta = new Carpeta();
        $carpeta->nombreC = 'Carpeta ' . uniqid(); // Asignamos un nombre único
        $carpeta->usuarioID = $this->usuarioID;
        $carpeta->fechaC = date('Y-m-d H:i:s');

        if ($carpeta->save()) {
            // Directorio donde se almacenarán los archivos
            $baseDir = Yii::getAlias('@webroot') . '/uploads/';

            // Procesamos cada archivo
            foreach ($this->carpeta as $file) {
                $path = $baseDir . $file->baseName . '.' . $file->extension;

                // Guardamos el archivo en el servidor
                if ($file->saveAs($path)) {
                    // Crear un registro para el archivo en la base de datos
                    $archivo = new Archivos();
                    $archivo->nombreA = $file->baseName;
                    $archivo->tipoA = $file->type;
                    $archivo->ruta = '/uploads/' . basename($path);  // Ruta relativa
                    $archivo->carpetaID = $carpeta->carpetaID; // Relacionamos el archivo con la carpeta
                    $archivo->usuarioID = $this->usuarioID;
                    $archivo->fechaSubi = date('Y-m-d H:i:s');
                    $archivo->save();
                } else {
                    Yii::error('Error al guardar el archivo: ' . json_encode($file->errors));
                    return false;
                }
            }
            return true;
        } else {
            Yii::error('Error al guardar la carpeta en la base de datos: ' . json_encode($carpeta->errors));
            return false;
        }
    } else {
        // Registrar los errores de validación
        Yii::error('Error en la validación: ' . json_encode($this->getErrors()));
        return false;
    }
}

}

