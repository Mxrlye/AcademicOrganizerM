<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "bloc".
 *
 * @property int $blocID
 * @property string $title
 * @property string $contenido
 * @property string $fechaCreaB
 * @property int $usuarioID
 */
class Bloc extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function primaryKey()
    {
        return ['blocID']; // Nombre correcto de la columna clave primaria
    }
    public static function tableName()
    {
        return 'bloc';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'contenido'], 'required'],
            [['contenido'], 'string'],
            [['fechaCreaB'], 'safe'],
            [['usuarioID'], 'integer'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'blocID' => 'Bloc ID',
            'title' => 'Título',
            'contenido' => 'Contenido',
            'fechaCreaB' => 'Fecha de Creación',
            'usuarioID' => 'Usuario ID',
        ];
    }
}
