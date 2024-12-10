<?php

namespace app\models;

use yii\db\ActiveRecord;

class Carpeta extends ActiveRecord
{
    public static function tableName()
    {
        return 'carpetas'; // Nombre de la tabla en tu base de datos
    }

    public function rules()
    {
        return [
            [['nombreC', 'usuarioID', 'fechaC'], 'required'],
            [['usuarioID'], 'integer'],
            [['fechaC'], 'safe'],
            [['nombreC'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'nombreC' => 'Nombre de la Carpeta',
            'usuarioID' => 'ID del Usuario',
            'fechaC' => 'Fecha de Creación',
        ];
    }
}



