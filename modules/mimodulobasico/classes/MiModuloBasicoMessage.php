<?php

/* Esto es un Modelo de prueba para aprender a crear Modulos en Prestashop 

Se encarga de guardar un mensaje en la base de datos y mostrarlo en el Front Office

*/

class MiModuloBasicoMessage extends ObjectModel
{
    public $id_mimodulobasico; // La ID de mi modulo
    public $message; // El mensaje que quiero guardar

    // Definir la estrucutra de la tabla
    public static $definition = [
        'table' => 'mimodulobasico_message',
        'primary' => 'id_mimodulobasico',
        'fields' => [
            'message' => [
                'type' => self::TYPE_STRING,
                'validate' => 'isString',
                'required' => true,
                'size' => 255,
            ],
        ],
    ];

    // Constructor

    public function __construct($id = null, $id_lang = null)
    {
        parent::__construct($id, $id_lang);
    }
}
