<?php

namespace app\models;

use yii\base\Model;
use yii\web\UploadedFile;
use Yii;

class formadesubir extends Model
{
    /**
     * @var UploadedFile
     */
    public $archivos;

    public function rules()
    {
        return [
            [['archivos'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg, pdf, docx'],
        ];
    }

    public function upload()
    {
        if ($this->validate()) {
            // Define la ruta de destino con el nombre y extensión del archivo
            $rutaDestino = Yii::getAlias('@app/uploads/') . $this->archivos->baseName . '.' . $this->archivos->extension;

            // Crear la carpeta si no existe
            if (!is_dir(Yii::getAlias('@app/uploads/'))) {
                mkdir(Yii::getAlias('@app/uploads/'), 0777, true);
                Yii::info('Carpeta uploads creada', __METHOD__);
            }

            // Intentar guardar el archivo
            if ($this->archivo->saveAs($rutaDestino)) {
                Yii::info('Archivo guardado exitosamente en ' . $rutaDestino, __METHOD__);
                return true;
            } else {
                Yii::error('Error al guardar el archivo en ' . $rutaDestino, __METHOD__);
            }
        } else {
            Yii::error('Validación fallida para el archivo', __METHOD__);
        }
        return false;
    }

}



