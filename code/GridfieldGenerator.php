<?php
/**
 * Created by PhpStorm.
 * User: mac
 * Date: 03.12.2013
 * Time: 12:00
 */

class GridfieldGenerator {
  public static function  create($name, $title, $value, $orderable = null) {
    $config = GridFieldConfig_RelationEditor::create(); // create a config object for the grid field

    $new_btn = $config->getComponentByType('GridFieldAddNewButton');
    $new_btn->setButtonName('New '.$title);

    if ($orderable) {
      $config->addComponent(new GridFieldSortableRows('Order'));
    }

    $pagination = $config->getComponentByType('GridFieldPaginator');
    $pagination->setItemsPerPage ( 1000 );

    $gridField = new GridField($name, $title, $value ,$config);
    return $gridField;
  }

  public static function createBulkUpload($name, $title, $value, $displayfields = null, $folder = '') {
    $config = GridFieldConfig_RelationEditor::create(); // create a config object for the grid field

    $config->addComponent(new GridFieldSortableRows('Order'));
    $dataColumns = $config->getComponentByType('GridFieldDataColumns');

    if (isset($displayfields)) {
      $dataColumns->setDisplayFields($displayfields);
    }

    $gfbu = new GridFieldBulkUpload();
    $gfbu->setUfSetup('setFolderName', $folder=='' ? $name : $folder);

    $config->addComponent($gfbu);

    $pagination = $config->getComponentByType('GridFieldPaginator');
    $pagination->setItemsPerPage ( 1000 );

    $gridField = new GridField($name, $title, $value ,$config);
    return $gridField;
  }
} 