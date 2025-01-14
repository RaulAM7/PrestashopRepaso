<?php


// Thew constant test -> Chequea si ahy una versión de Prestashop Preexistente

if (!defined('_PS_VERSION_')) {
    exit;
}

class MiModuloBasico extends Module
{
    public function __construct()
    {
        $this->name = 'mimodulobasico'; // Nombre real del modulo en las interfaces
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
        if (!parent::install()) {
            return false;
        }
        // Añadir configuraciones por defecto
        $defaultConfigurations = [
            'MI_MODULO_BASICO_CONFIG_UNICA' => 'Valor de configuración UNICA',
        ];
        foreach ($defaultConfigurations as $key => $value) {
            if (!Configuration::updateValue($key, $value)) {
                return false;
            }
        }
        // Añadimos hooks
        $hooks = array(
            'displayHome'
        );
        foreach ($hooks as $hook) {
            if (!$this->registerHook($hook)) {
                return false;
            }
        }
        return true;
    }
    // Funcion de desinstalacion del Modulo
    public function uninstall()
    {
        if (!parent::uninstall()) {
            return false;
        }
        $defaultConfigurations = [
            'MI_MODULO_BASICO_CONFIG_UNICA',
        ];
        foreach ($defaultConfigurations as $configuration) {
            if (!Configuration::deleteByName($configuration)) {
                return false;
            }
        }

        return true;
    }

    // PAGINA DE CONFIGURACION DEL MODULO EN EL FRONTEND DEL BACK-OFFICE

    public function renderForm()
    {
        $fields_form = [
            'form' => [
                'legend' => [
                    'title' => $this->trans('Configuración de Mi Modulo Básico'),
                    'icon' => 'icon-cogs',
                ],
                'input' => [
                    [
                        'type' => 'text',
                        'label' => $this->l('Mensaje personalizado'),
                        'name' => 'MI_MODULO_BASICO_CONFIG_UNICA',
                        'size' => 64,
                        'required' => true
                    ],
                ],
                'submit' => [
                    'title' => $this->l('Guardar'),
                    'class' => 'btn btn-default pull-right'
                ],
            ],
        ];

        // Configuracion del helperForm de Prestashop

        $helper = new HelperForm();
        
        $helper->module = $this;
        $helper->name_controller = $this->name;
        $helper->identifier = $this->identifier;
        $helper->token = Tools::getAdminTokenLite('AdminModules'); // Security Token
        $helper->currentIndex = AdminController::$currentIndex . '&configure=' . $this->name; // Current Index URL
        $helper->fields_value['MI_MODULO_BASICO_CONFIG_UNICA'] = Configuration::get('MI_MODULO_BASICO_CONFIG_UNICA'); // Valor actual de la configuracion
        $helper->submit_action = 'submit' . $this->name; // Accion de envio del formulario

        return $helper->generateForm([$fields_form]);
    }


    // Metodo getContent() -> Recupera la informacion del Form y ejecuta la Congiguracion
    public function getContent()
    {
        $output = '';

        // Procesar el formulario si se ha enviado

        if (Tools::isSubmit('submit' . $this->name)) // Comprueba si se ha enviado el formulario con el boton submitMyModule
        {
            $custom_setting = Tools::getValue('MI_MODULO_BASICO_CONFIG_UNICA');  // Recupera el valor enviado en el formulario
            if (!empty($custom_setting)) {
                Configuration::updateValue('MI_MODULO_BASICO_CONFIG_UNICA', $custom_setting);
                $output .= $this->displayConfirmation($this->l('Configuración actualizada'));
            } else {
                $output .= $this->displayError($this->l('Error: El campo no puede estar vacío'));
            }
            
        }

        // Genera y devuelve el formulario
        return $output . $this->renderForm(); // Devuelve el formulario
    }


    // REGISTRO DE HOOKS 

    // Hook Básico
    public function hookDisplayHome()
    {
        // Modificamos el metodo hookDisplayHome para leer el mensaje configurado por el usuario desde la base de datos
        return $this->display(__FILE__, 'views/templates/hook/displayHome.tpl');
    }
}
