<?php

namespace app\models;

use yii\base\Model;

class CompartirForm extends Model
{
    public $email;
    public $message;
    public $content;

    public function rules()
    {
        return [
            [['email'], 'required'],
            [['email'], 'email'],
            [['message'], 'string', 'max' => 500],
            [['content'], 'file', 'extensions' => 'png, jpg, pdf, docx, txt'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'email' => 'Correo Electrónico',
            'message' => 'Mensaje',
            'content' => 'Archivo a Compartir',
        ];
    }
}
