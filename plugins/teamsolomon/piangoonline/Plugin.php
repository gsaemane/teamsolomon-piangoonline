<?php namespace TeamSolomon\PiangoOnline;

use System\Classes\PluginBase;
use Backend\Classes\WidgetManager;

class Plugin extends PluginBase
{
    public function registerComponents()
    {
        return [
            'TeamSolomon\PiangoOnline\Components\EntryForm' => 'entryForm'
        ];
    }

    public function registerSettings()
    {
        
    }

    public function register() {
        WidgetManager::instance()->registerFormWidgets(function ($manager) {
          // You can add them as per need
          $manager->registerFormWidget('Backend\FormWidgets\RichEditor', 'richeditor');
  
          $manager->registerFormWidget('Backend\FormWidgets\CodeEditor', 'codeeditor');          
          $manager->registerFormWidget('Backend\FormWidgets\MarkdownEditor', 'markdown');
          $manager->registerFormWidget('Backend\FormWidgets\FileUpload', 'fileupload');
          $manager->registerFormWidget('Backend\FormWidgets\Relation', 'relation');
          $manager->registerFormWidget('Backend\FormWidgets\DatePicker', 'datepicker');
          $manager->registerFormWidget('Backend\FormWidgets\TimePicker', 'timepicker');
          $manager->registerFormWidget('Backend\FormWidgets\ColorPicker', 'colorpicker');
          $manager->registerFormWidget('Backend\FormWidgets\DataTable', 'datatable');
          $manager->registerFormWidget('Backend\FormWidgets\RecordFinder', 'recordfinder');
          $manager->registerFormWidget('Backend\FormWidgets\Repeater', 'repeater');
          $manager->registerFormWidget('Backend\FormWidgets\TagList', 'taglist');
          $manager->registerFormWidget('Backend\FormWidgets\MediaFinder', 'mediafinder');
          $manager->registerFormWidget('Backend\FormWidgets\NestedForm', 'nestedform');
        });
      }
}
