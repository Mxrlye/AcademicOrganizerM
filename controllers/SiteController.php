<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\User;
use yii\web\UploadedFile;
use yii\helpers\Url;
use app\models\Archivos;
use app\models\Carpeta; // Referencia a tu modelo en `models`
use app\models\CarpetaForm;
use app\models\Bloc; 
use app\models\Event;
use app\models\Archivo;





class SiteController extends Controller
{
    /**
     * Configuración de comportamientos.
     */
    public function behaviors()
{
    return [
        'access' => [
            'class' => AccessControl::class,
            'only' => ['index', 'about', 'carpetas', 'contact', 'logout'], // Acciones restringidas
            'rules' => [
                // Regla para usuarios invitados (acceso solo a login y register)
                [
                    'actions' => ['login', 'register'], // Acciones permitidas a usuarios no autenticados
                    'allow' => true,
                    'roles' => ['?'], // Solo usuarios invitados
                ],
                // Regla para usuarios autenticados (acceso a subir archivo, carpetas, eliminar)
                [
                    'actions' => ['subirarchivo', 'carpetas', 'eliminararchivo','index', 'about', 'contact', 'logout'], // Acciones permitidas a usuarios autenticados
                    'allow' => true,
                    'roles' => ['@'], // Solo usuarios autenticados
                ],
                // Regla predeterminada (negamos el acceso si no coincide con ninguna anterior)
                [
                    'allow' => false,
                ],
            ],
        ],
        'verbs' => [
            'class' => VerbFilter::class,
            'actions' => [
                'logout' => ['post'],
            ],
        ],
    ];
}


    /**
     * Configuración de acciones externas.
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Página principal (index).
     */
    public function actionIndex()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        }

        return $this->render('index');
    }

    /**
     * Página de información (about).
     */
   // SiteController.php
   public function actionAbout()
   {
       // Instancia del modelo de eventos
       $eventModel = new Event();
   
       // Obtener mes y año desde el frontend o usar los valores actuales por defecto
       $month = Yii::$app->request->get('month', date('m')); // Mes actual (01-12) por defecto
       $year = Yii::$app->request->get('year', date('Y'));   // Año actual por defecto
   
       // Calcular el rango de fechas para el mes y año seleccionados
       $startDate = date("$year-$month-01");   // Primer día del mes
       $endDate = date("$year-$month-t");     // Último día del mes
   
       // Filtrar eventos del usuario autenticado dentro del rango de fechas
       $events = Event::find()
           ->select(['eventoID', 'titulo', 'descripcion', 'fecha', 'hora_inicio', 'hora_fin']) // Seleccionamos las columnas necesarias
           ->where(['usuarioID' => Yii::$app->user->id]) // Filtrar por usuario autenticado
           ->andWhere(['between', 'fecha', $startDate, $endDate]) // Rango de fechas
           ->asArray() // Convertimos los datos a un array asociativo
           ->all(); // Obtenemos todos los eventos
   
       // Manejo del formulario para guardar un nuevo evento
       if ($eventModel->load(Yii::$app->request->post())) {
           $eventModel->usuarioID = Yii::$app->user->id; // Asociar el evento al usuario autenticado
           if ($eventModel->save()) {
               Yii::$app->session->setFlash('success', 'Evento guardado correctamente.');
               return $this->refresh(); // Evitar doble envío del formulario
           } else {
               Yii::$app->session->setFlash('error', 'Hubo un error al guardar el evento.');
           }
       }
   
       // Renderizar la vista "about" y pasar los datos necesarios
       return $this->render('about', [
           'eventModel' => $eventModel, // Modelo para el formulario
           'events' => $events,         // Eventos del mes seleccionado
           'currentMonth' => $month,    // Mes actual o seleccionado
           'currentYear' => $year,      // Año actual o seleccionado
       ]);
   }
   

    /**
     * Acción para eliminar un evento.
     * @param int $id ID del evento a eliminar
     */
    public function actionDeleteEvent($id)
    {
        $event = Event::findOne(['eventoID' => $id, 'usuarioID' => Yii::$app->user->id]);
    
        if ($event !== null) {
            if ($event->delete()) {
                Yii::$app->session->setFlash('success', 'Evento eliminado correctamente.');
            } else {
                Yii::$app->session->setFlash('error', 'No se pudo eliminar el evento.');
            }
        } else {
            Yii::$app->session->setFlash('error', 'Evento no encontrado.');
        }
    
        return $this->redirect(['site/about']);
    }
    
    
    

   



    /**
     * Inicio de sesión.
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Cierre de sesión.
     */
    
    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }

    /**
     * Registro de nuevos usuarios.
     */
    public function actionRegistro()
    {
        $model = new User();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', '¡Registro exitoso!');
            return $this->redirect(['site/login']);
        }

        return $this->render('registro', [
            'model' => $model,
        ]);
    }
    

    /**
     * Gestión de carpetas.
     */
   

    /**
     * Subir archivo.
     */
    public function actionSubirarchivo()
    {
        // Verificar si se ha recibido un archivo
        $archivo = UploadedFile::getInstanceByName('archivo');

        if (!$archivo) {
            Yii::$app->session->setFlash('error', 'No se seleccionó ningún archivo para subir.');
            return $this->redirect(['site/carpetas']);
        }

        // Crear una nueva instancia del modelo Archivo
        $modeloArchivo = new Archivo();

        // Intentar guardar el archivo
        if ($modeloArchivo->guardarArchivo($archivo)) {
            Yii::$app->session->setFlash('success', 'El archivo se subió correctamente.');
        } else {
            Yii::$app->session->setFlash('error', 'Hubo un problema al subir el archivo. Asegúrate de que el servidor tiene permisos de escritura.');
        }

        return $this->redirect(['site/carpetas']);
    }
    



//NO TOCAR
public function actionCarpetas()
{
    // Obtener carpetas del usuario actual
    $carpetas = Carpeta::find()->where(['usuarioID' => Yii::$app->user->id])->all();

    // Obtener archivos (si es necesario)
    $archivos = Archivo::find()->all();

    // Renderizar la vista con los datos
    return $this->render('carpetas', [
        'carpetas' => $carpetas,
        'archivos' => $archivos,
    ]);
}


// En tu controlador SiteController





public function actionSubircarpeta()
{
    if (Yii::$app->request->isPost) {
        // Obtener los archivos enviados desde el formulario
        $archivos = UploadedFile::getInstancesByName('carpeta');
        $nombreCarpeta = Yii::$app->request->post('nombreCarpeta', 'Nueva Carpeta');
        $usuarioID = Yii::$app->user->id;

        // Crear un registro para la carpeta en la base de datos
        $carpetaModel = new \app\models\Carpeta();
        $carpetaModel->nombreC = $nombreCarpeta;
        $carpetaModel->usuarioID = $usuarioID;
        $carpetaModel->fechaC = date('Y-m-d H:i:s');

        if ($carpetaModel->save()) {
            $carpetaID = $carpetaModel->carpetaID;

            // Crear el directorio físico en el servidor
            $rutaBase = Yii::getAlias('@webroot/uploads/carpeta_' . $carpetaID);
            if (!is_dir($rutaBase)) {
                if (!mkdir($rutaBase, 0777, true) && !is_dir($rutaBase)) {
                    Yii::$app->session->setFlash('error', 'No se pudo crear el directorio en el servidor.');
                    return $this->redirect(['site/carpetas']);
                }
            }

            // Guardar los archivos subidos en el directorio
            $errores = [];
            foreach ($archivos as $archivo) {
                $rutaArchivo = $rutaBase . '/' . $archivo->name;
                if ($archivo->saveAs($rutaArchivo)) {
                    // Registrar cada archivo en la base de datos
                    $archivoModel = new \app\models\Archivo();
                    $archivoModel->carpetaID = $carpetaID;
                    $archivoModel->nombreA = $archivo->name;
                    $archivoModel->tipoA = $archivo->type;
                    $archivoModel->ruta = '/uploads/carpeta_' . $carpetaID . '/' . $archivo->name;
                    $archivoModel->usuarioID = $usuarioID;
                    $archivoModel->fechaSubi = date('Y-m-d H:i:s');

                    if (!$archivoModel->save()) {
                        $errores[] = $archivoModel->getErrors();
                    }
                } else {
                    $errores[] = "Error al guardar el archivo {$archivo->name} en el servidor.";
                }
            }

            // Verificar si hubo errores al guardar los archivos
            if (empty($errores)) {
                Yii::$app->session->setFlash('success', 'La carpeta y sus archivos se subieron correctamente.');
            } else {
                Yii::$app->session->setFlash('error', 'Algunos archivos no se pudieron guardar: ' . implode(', ', $errores));
            }
        } else {
            Yii::$app->session->setFlash('error', 'No se pudo crear la carpeta en la base de datos.');
        }
    }

    // Redirigir a la vista de carpetas
    return $this->redirect(['site/carpetas']);
}
public function actionCrearcarpeta()
{
    $carpeta = new \app\models\Carpeta();

    // Verifica si se envió el formulario con datos
    if (Yii::$app->request->isPost) {
        $nombreC = Yii::$app->request->post('nombreC', ''); // Obtén el nombre de la carpeta

        // Validar que el nombre no esté vacío
        if (empty($nombreC)) {
            Yii::$app->session->setFlash('error', 'El nombre de la carpeta no puede estar vacío.');
            return $this->redirect(['site/carpetas']);
        }

        // Asignar datos al modelo de la carpeta
        $carpeta->nombreC = htmlspecialchars($nombreC, ENT_QUOTES); // Limpieza básica de entrada
        $carpeta->usuarioID = Yii::$app->user->id; // ID del usuario actual
        $carpeta->fechaC = date('Y-m-d H:i:s'); // Fecha actual

        // Guardar la carpeta en la base de datos
        if ($carpeta->save()) {
            $carpetaID = $carpeta->carpetaID; // Obtener el ID de la carpeta recién creada

            // Crear directorio físico en el servidor
            $rutaBase = Yii::getAlias('@webroot/uploads/carpeta_' . $carpetaID);
            if (!is_dir($rutaBase)) {
                if (!mkdir($rutaBase, 0777, true) && !is_dir($rutaBase)) {
                    Yii::$app->session->setFlash('error', 'No se pudo crear el directorio en el servidor.');
                    return $this->redirect(['site/carpetas']);
                }
            }

            Yii::$app->session->setFlash('success', 'Carpeta creada correctamente.');
        } else {
            Yii::$app->session->setFlash('error', 'No se pudo crear la carpeta en la base de datos.');
        }
    }

    // Redirigir a la vista de carpetas
    return $this->redirect(['site/carpetas']);
}



 //Para ver datos en Icono de Usuario
 public function actionProfile()
{
    // Obtiene el ID del usuario autenticado
    $userId = Yii::$app->user->identity->usuarioID;

    // Consulta la información del usuario
    $user = (new \yii\db\Query())
        ->select(['nombres', 'apellidos', 'correo', 'genero', 'telefono'])
        ->from('usuario')
        ->where(['usuarioID' => $userId])
        ->one();

    // Si no se encuentra el usuario, redirige a otra página o muestra un error
    if (!$user) {
        Yii::$app->session->setFlash('error', 'Usuario no encontrado.');
        return $this->redirect(['site/index']);
    }

    // Renderiza la vista con los datos del usuario
    return $this->render('profile', ['user' => $user]);
}

//Para compartir
public function actionCompartir()
{
    $model = new \app\models\CompartirForm();

    // Obtiene el ID del usuario autenticado
    $userId = Yii::$app->user->identity->usuarioID;

    // Recupera la lista de archivos subidos por el usuario autenticado
    $archivos = (new \yii\db\Query())
        ->select(['archivoID', 'nombreA']) //ID y el nombre del archivo
        ->from('archivos') // tabla archivos
        ->where(['usuarioID' => $userId]) // Filtramos por el usuario autenticado
        ->all();

    if ($model->load(Yii::$app->request->post()) && $model->validate()) {
        // Obtenemos el archivo seleccionado desde el POST
        $archivoSeleccionado = Yii::$app->request->post('archivoSeleccionado');

        // Recuperamos la ruta completa del archivo seleccionado
        $archivoRuta = (new \yii\db\Query())
            ->select(['ruta'])
            ->from('archivos')
            ->where(['archivoID' => $archivoSeleccionado])
            ->scalar();

        
        $archivoRutaAbsoluta = Yii::getAlias('@webroot') . '/' . $archivoRuta;

        // Verifica si el archivo existe
        if (!file_exists($archivoRutaAbsoluta)) {
            Yii::$app->session->setFlash('error', 'El archivo seleccionado no existe.');
            return $this->redirect(['compartir']);
        }

        try {
            // Enviar el correo 
            Yii::$app->mailer->compose()
                ->setTo($model->email)
                ->setFrom(Yii::$app->params['adminEmail'])
                ->setSubject('Contenido Compartido')
                ->setTextBody($model->message ?: 'Un archivo ha sido compartido contigo.')
                ->attach($archivoRutaAbsoluta) // Adjuntar el archivo seleccionado
                ->send();

                
            Yii::$app->session->setFlash('success', 'El contenido ha sido compartido con éxito.');
        } catch (\Exception $e) {
            
            Yii::$app->session->setFlash('error', 'Error al enviar el correo: ' . $e->getMessage());
        }

        return $this->redirect(['compartir']);
    }

    return $this->render('compartir', [
        'model' => $model,
        'archivos' => $archivos,
    ]);
}


public function actionPruebaCorreo()
{
    try {
        Yii::$app->mailer->compose()
            ->setTo('marlycontreras8@gmail.com') // Reemplaza con un correo válido
            ->setFrom('academicorganizerm@gmail.com') // Asegúrate de que coincide con el correo configurado
            ->setSubject('Correo de prueba desde Yii')
            ->setTextBody('Este es un correo de prueba enviado desde la configuración de Gmail en Yii.')
            ->send();

        return 'Correo enviado correctamente.';
    } catch (\Exception $e) {
        return 'Error: ' . $e->getMessage();
    }
}
public function actionTestMailer()
{
    try {
        $mailer = Yii::$app->mailer;
        $transport = $mailer->getTransport(); // Obtén el transporte configurado
        var_dump($transport); // Imprime la configuración del transporte
        die();
    } catch (\Exception $e) {
        return 'Error: ' . $e->getMessage();
    }
}








 

    



 // Acción para eliminar una carpeta

 public function actionDescargarcarpeta($nombre)
    {
        // Ruta de la carpeta
        $rutaCarpeta = Yii::getAlias('@app/uploads/carpetas/' . $nombre);
        // Ruta temporal para el archivo .zip
        $rutaZip = Yii::getAlias('@app/uploads/temp/' . $nombre . '.zip');

        if (!file_exists($rutaCarpeta)) {
            throw new \yii\web\NotFoundHttpException("La carpeta no existe.");
        }

        // Si el archivo ZIP no existe, lo generamos
        if (!file_exists($rutaZip)) {
            $this->comprimirCarpeta($rutaCarpeta, $rutaZip);
        }

        // Enviamos el archivo ZIP para descarga
        return Yii::$app->response->sendFile($rutaZip);
    }

    private function comprimirCarpeta($carpeta, $archivoZip)
    {
        $zip = new ZipArchive();
        if ($zip->open($archivoZip, ZipArchive::CREATE) === true) {
            $archivos = new \RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator($carpeta),
                \RecursiveIteratorIterator::LEAVES_ONLY
            );

            foreach ($archivos as $archivo) {
                if (!$archivo->isDir()) {
                    $filePath = $archivo->getRealPath();
                    $relativePath = substr($filePath, strlen($carpeta) + 1);
                    $zip->addFile($filePath, $relativePath);
                }
            }

            $zip->close();
        } else {
            throw new \Exception("No se pudo crear el archivo ZIP.");
        }
    }
//borrar
public function actionEliminararchivo($id)
{
    $archivo = Archivo::findOne(['archivoID' => $id]);
    if (!$archivo) {
        Yii::$app->session->setFlash('error', 'Archivo no encontrado.');
        return $this->redirect(['site/carpetas']);
    }

    $rutaArchivo = Yii::getAlias('@app') . $archivo->ruta;

    Yii::info("Ruta del archivo: $rutaArchivo", 'debug');

    if (file_exists($rutaArchivo)) {
        if (unlink($rutaArchivo)) {
            $archivo->delete();
            Yii::$app->session->setFlash('success', 'El archivo fue eliminado correctamente.');
        } else {
            Yii::$app->session->setFlash('error', 'No se pudo eliminar el archivo físico.');
        }
    } else {
        Yii::$app->session->setFlash('error', 'El archivo no existe en el servidor.');
    }

    return $this->redirect(['site/carpetas']);
}





    // Acción para eliminar carpetas
    public function actionEliminarcarpeta($id)
    {
        // Buscar la carpeta usando 'carpetaID'
        $carpeta = Carpeta::findOne(['carpetaID' => $id]); 
        $rutaCarpeta = Yii::getAlias('@app/uploads/carpetas/' . $carpeta->nombreC);
    
        // Eliminar la carpeta del sistema de archivos
        if ($carpeta && $this->borrarDirectorio($rutaCarpeta)) {
            $carpeta->delete(); // Eliminar el registro de la base de datos
            Yii::$app->session->setFlash('success', 'La carpeta fue eliminada correctamente.');
        } else {
            Yii::$app->session->setFlash('error', 'No se pudo eliminar la carpeta.');
        }
    
        return $this->redirect(['site/carpetas']);
    }
    

    // Función para borrar directorios y sus contenidos
    private function borrarDirectorio($directorio)
    {
        if (!is_dir($directorio)) {
            return false;
        }

        $archivos = array_diff(scandir($directorio), ['.', '..']);
        foreach ($archivos as $archivo) {
            $rutaArchivo = $directorio . DIRECTORY_SEPARATOR . $archivo;
            if (is_dir($rutaArchivo)) {
                $this->borrarDirectorio($rutaArchivo);
            } else {
                unlink($rutaArchivo);
            }
        }

        return rmdir($directorio);
    }

// Acción para crear una nueva nota
public function actionCrearNota()
{
    $model = new Bloc();

    if ($model->load(Yii::$app->request->post()) && $model->validate()) {
        $model->fechaCreaB = date('Y-m-d H:i:s'); // Fecha actual
        $model->usuarioID = Yii::$app->user->id; // ID del usuario logueado

        if ($model->save()) {
            Yii::$app->session->setFlash('success', 'Nota creada exitosamente.');
            return $this->redirect(['site/contact']); // Redirige a la lista de notas
        }
    }

    Yii::$app->session->setFlash('error', 'Error al crear la nota.');
    return $this->redirect(['site/contact']);
}
public function actionBlocDeNotas()
{
    $notes = Bloc::find()->where(['usuarioID' => Yii::$app->user->id])->all();
    $model = new Bloc(); // Modelo para crear una nueva nota

    return $this->render('bloc-de-notas', [
        'notes' => $notes,
        'model' => $model,
    ]);
}
public function actionContact()
{
    $notes = Bloc::find()->where(['usuarioID' => Yii::$app->user->id])->all();
    $model = new Bloc();

    return $this->render('contact', [
        'notes' => $notes,
        'model' => $model,
    ]);
}

public function actionGuardarNota()
{
    $model = new Bloc();

    if ($model->load(Yii::$app->request->post())) {
        $model->usuarioID = Yii::$app->user->id;
        $model->fechaCreaB = date('Y-m-d H:i:s');

        if ($model->save()) {
            // Limpiar caracteres no válidos del título para el archivo
            $cleanTitle = preg_replace('/[^A-Za-z0-9_\-]/', '_', $model->title);
            
            $noteContent = "Título: " . $model->title . "\n\n" .
                           "Contenido: \n" . $model->contenido . "\n\n" .
                           "Creada el: " . $model->fechaCreaB . "\n";

            $folderPath = Yii::getAlias('@webroot') . '/notas';
            if (!file_exists($folderPath)) {
                mkdir($folderPath, 0777, true);
            }

            $filePath = $folderPath . '/' . $cleanTitle . '.txt';
            if (file_put_contents($filePath, $noteContent) !== false) {
                Yii::$app->session->setFlash('success', 'Nota creada exitosamente.');
            } else {
                Yii::$app->session->setFlash('error', 'La nota fue guardada, pero no se pudo generar el archivo.');
            }

            return $this->redirect(['site/contact']); // Ajusta la redirección a tu vista de notas
        } else {
            Yii::$app->session->setFlash('error', 'Error al guardar la nota en la base de datos.');
        }
    }

    Yii::$app->session->setFlash('error', 'Error al crear la nota.');
    return $this->redirect(['site/contac']); // Ajusta la redirección a tu vista de notas
}


//borrar Nota



public function actionDescargar($blocID)
{
    $bloc = Bloc::findOne($blocID); // Busca la nota por su ID

    if ($bloc) {
        $fileName = $bloc->title . '.txt'; // Nombre del archivo basado en el título
        $content = "Título: " . $bloc->title . "\n";
        $content .= "Fecha: " . $bloc->fechaCreaB . "\n";
        $content .= "Contenido:\n" . $bloc->contenido;

        // Envía el contenido como archivo para descargar
        return Yii::$app->response->sendContentAsFile($content, $fileName, [
            'mimeType' => 'text/plain',
            'inline' => false, // Forzar descarga
        ]);
    }

    Yii::$app->session->setFlash('error', 'Nota no encontrada.');
    return $this->redirect(['site/bloc']);
}


    public function actionBloc()
    {
        $blocs = Bloc::find()->all(); // Obtiene todas las notas desde el modelo Bloc
    
        // Generar el HTML manualmente (sin vista)
        $html = "<h1>Bloc de Notas</h1>";
    
        if (!empty($blocs)) {
            $html .= "<ul>";
            foreach ($blocs as $bloc) {
                $html .= "<li>";
                $html .= "<strong>" . htmlspecialchars($bloc->title) . "</strong><br>";
                $html .= "<small>Fecha: " . htmlspecialchars($bloc->fechaCreaB) . "</small><br>";
                $html .= htmlspecialchars($bloc->contenido) . "<br>";
                $html .= "<a href='" . \yii\helpers\Url::to(['site/descargar', 'blocID' => $bloc->blocID]) . "'>Descargar</a>";
                $html .= "</li><hr>";
            }
            $html .= "</ul>";
        } else {
            $html .= "<p>No hay notas disponibles.</p>";
        }
    
        return $html;
    }
    

    

 
   






public function actionCreateEvent()
    {
        $eventModel = new Event();

        // Asume que el usuario está autenticado y su ID está disponible en Yii::$app->user->id
        if (Yii::$app->user->isGuest) {
            Yii::$app->session->setFlash('error', 'Debes iniciar sesión para crear un evento.');
            return $this->redirect(['site/login']);
        }

        // Asigna el usuarioID del usuario logueado
        $eventModel->usuarioID = Yii::$app->user->id;

        // Si se envía el formulario y es válido, guarda el evento
        if ($eventModel->load(Yii::$app->request->post()) && $eventModel->save()) {
            Yii::$app->session->setFlash('success', 'Evento creado con éxito.');
            return $this->refresh(); // Vuelve a cargar la página (o redirige a donde desees)
        }

        return $this->render('calendar', ['eventModel' => $eventModel]); // Renderiza el formulario de eventos
    }


    /**
     * Función auxiliar para eliminar directorios.
     */
    private function deleteDirectory($dir)
    {
        if (!is_dir($dir)) {
            return false;
        }

        $items = scandir($dir);
        foreach ($items as $item) {
            if ($item == '.' || $item == '..') {
                continue;
            }
            $path = $dir . DIRECTORY_SEPARATOR . $item;
            if (is_dir($path)) {
                $this->deleteDirectory($path);
            } else {
                unlink($path);
            }
        }
        return rmdir($dir);
    }

    /**
     * Página de contacto.
     */
    // Singleton para gestión de sesiones


}

