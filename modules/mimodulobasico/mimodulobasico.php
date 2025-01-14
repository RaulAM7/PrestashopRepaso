<?php


// Thew constant test -> Chequea si ahy una versión de Prestashop Preexistente
if (defined('_PS_VERSION_')) {
    exit;
}

class MiModuloBasico extends ModuleCore
{
    public function __construct()
    {
        $this->name = 'Mi Primer Modulo Básico'; // Nombre real del modulo en las interfaces
        $this->tab = 'front_office_features'; // Tab del FRONTEND DEL BACK OFFICE en el que se mostrará el modulo
        $this->version = '1.0.0'; // Versión del modulo
        $this->author = 'Github: raulAM'; // Autor del modulo
        $this->need_instance = 0; // Si es 1, se instanciará el modulo en la página de módulos
        $this->ps_versions_compliancy = array(
            'min' => '1.7',
            'max' => _PS_VERSION_
        ); // Versiones de Prestashop con las que es compatible
        $this->bootstrap = true; // Si es true, se cargará el archivo bootstrap.min.css es decir si las templates que usa este módulo estan pensadas para las Boostrap Prestasop Tools

        parent::__construct();

        $this->displayName = $this->l('Mi Primer Modulo Básico'); // Nombre del modulo en el back office
        $this->description = $this->l('Este es el primer Módulo creado en el Repaso Prestashop'); // Descripción del modulo en el back office
        $this->confirmUninstall = $this->l('¿Estás seguro de que quieres desinstalar?'); // Mensaje de confirmación de desinstalación
    }
    // Funcion de instalacion del Modulo
    public function install()
    {
        if (!parent::install())
        {
            return false;
        }
        // Añadir configuraciones por defecto
        $defaultConfigurations = array(
            'MI_MODULO_BASICO_CONFIG_1' => 'Valor de configuración 1',
            'MI_MODULO_BASICO_CONFIG_2' => 'Valor de configuración 2',
            'MI_MODULO_BASICO_CONFIG_3' => 'Valor de configuración 3',
        );
        foreach($defaultConfigurations as $key => $value)
        {
            if (!Configuration::updateValue($key, $value))
            {
                return false;
            }
        }
        // Añadimos hooks
        $hooks = array(
            'displayHome'
        );
        foreach( $hooks as $hook)
        {
            if (!$this->registerHook($hook))
            {
                return false;
            }
        } 
    }
    // Funcion de desinstalacion del Modulo
    public function uninstall()
    {
        if (!parent::uninstall())
        {
            return false;
        }
        foreach($defaultConfigurations as $key => $value)
        {
            if (!Configuration::deleteByName($key))
            {
                return false;
            }
        }
    }

    // PAGINA DE CONFIGURACION DEL MODULO EN EL FRONTEND DEL BACK-OFFICE
    

}
