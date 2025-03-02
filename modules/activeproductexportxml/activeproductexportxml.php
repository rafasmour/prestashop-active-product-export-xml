<?php

if (!defined('_PS_VERSION_')) {
    exit;
}

class Activeproductexportxml extends Module
{
    protected $config_form = false;

    public function __construct()
    {
        $this->name = 'activeproductexportxml';
        $this->tab = 'export';
        $this->version = '1.0.0';
        $this->author = 'Rafail Mourouzidis';
        $this->need_instance = 0;
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('Export Active Products as xml');
        $this->description = $this->l('Exports active products\' basic information as an XML file');

        $this->ps_versions_compliancy = array('min' => '1.7', 'max' => _PS_VERSION_);
    }
    public function install()
    {
        return parent::install() && $this->installTab();
    }

    public function uninstall()
    {
        return parent::uninstall() && $this->uninstallTab();
    }

    public function installTab()
    {
        $tabId = (int) Tab::getIdFromClassName('ExportProductController');
        if (!$tabId) {
            $tabId = null;
        }
        $tab = new Tab($tabId);
        $tab->active=1;
        $tab->class_name='ExportProductController';
        $tab->route_name = 'export_product_route';
        $tab->name = array();
        foreach (Language::getLanguages() as $lang) {
            $tab->name[$lang['id_lang']] = $this->trans('Export Active Products as XML', array(), null, $lang['locale']);
        }
        $tab->id_parent = (int) Tab::getIdFromClassName('ShopParameters');
        $tab->module = $this->name;

        return $tab->save();
    }

    public function uninstallTab()
    {
        $tabId = (int) Tab::getIdFromClassName('ExportProductController');
        if (!$tabId) {
            return true;
        }

        $tab = new Tab($tabId);

        return $tab->delete();
    }

}
