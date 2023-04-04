<?php 
  if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

  require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");

  $APPLICATION->SetTitle("Tasks");

  $APPLICATION->includeComponent('up:tasks.list', '', []);

  require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); 
?>