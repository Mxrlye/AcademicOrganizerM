<?php
namespace app\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

class CarpetaUploadForm extends Model
{
    public $archivos;

    public function rules()
    {
        return [
            [['archivos'], 'required'],
            [['archivos'], 'file',
                'skipOnEmpty' => false,
                'extensions' => 'zip, tar, rar', // Extensiones permitidas
                'maxFiles' => 100, // Número máximo de archivos
                'maxSize' => 10 * 1024 * 1024, // Tamaño máximo (10 MB por archivo)
            ],
        ];
    }

    public function upload($path, $usuarioID)
    {
        if (!is_dir($path)) {
            mkdir($path, 0777, true); // Crear el directorio si no existe
        }
    
        if ($this->validate()) {
            foreach ($this->archivos as $archivo) {
                $filePath = $path . '/' . $archivo->baseName . '.' . $archivo->extension;
                if (!$archivo->saveAs($filePath)) {
                    $this->addError('archivos', "Error al guardar el archivo {$archivo->baseName}");
                    return false;
                }
            }
    
            // Registrar en la base de datos
            $db = Yii::$app->db;
            $transaction = $db->beginTransaction();
            try {
                $db->createCommand()->insert('carpetas', [
                    'nombreC' => basename($path),
                    'usuarioID' => $usuarioID,
                    'fechaC' => date('Y-m-d H:i:s'),
                ])->execute();
                $transaction->commit();
                return true;
            } catch (\Exception $e) {
                $transaction->rollBack();
                $this->addError('archivos', 'Error al registrar en la base de datos: ' . $e->getMessage());
                return false;
            }
        } else {
            return false;
        }
    }
    
}
