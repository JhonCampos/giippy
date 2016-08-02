<?php
use papaya\giippy\helpers\StringHelper;
use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $generator yii\gii\generators\form\Generator */

$dbConnections = [];
foreach (array_keys(\Yii::$app->components) as $componentId) {
	if (StringHelper::startsWith($componentId, 'db'))
		$dbConnections[$componentId] = $componentId;
}
$onClick = '$("#' . Html::getInputId($generator, 'module') . '").val($(this).html()).keyup()';
echo $form->field($generator, 'module', ['inputOptions' => [
	'class' => 'form-control',
	'autofocus' => 'autofocus',
	'onkeyup' => 'populateModule(this);'
]])->hint("<button type='button' class='btn btn-xs' onclick='{$onClick}'>admin</button> ".
"<button type='button' class='btn btn-xs' onclick='{$onClick}'>identity</button> ".
"<button type='button' class='btn btn-xs' onclick='{$onClick}'>cine</button> ".
"<button type='button' class='btn btn-xs' onclick='{$onClick}'>pay</button> " .
"<button type='button' class='btn btn-xs' onclick='{$onClick}'>cron</button> " .
"<button type='button' class='btn btn-xs' onclick='{$onClick}'>payment</button> " .
"<button type='button' class='btn btn-xs' onclick='{$onClick}'>mongo</button>", ["style" => "display:block;"]);
echo $form->field($generator, 'ns');
echo $form->field($generator, 'db');
echo $form->field($generator, 'tableName', ['inputOptions' => [
	'class' => 'form-control',
	'autofocus' => 'autofocus',
]]);
echo $form->field($generator, 'modelClass');
echo $form->field($generator, 'baseClass');
echo $form->field($generator, 'enableI18N')->checkbox();
echo $form->field($generator, 'messageCategory');

$keys = ['module','db','tableName','modelClass','ns','baseClass', 'messageCategory'];
$ids = [];
foreach ($keys as $key)
	$ids[$key] = Html::getInputId($generator, $key);
?>
<script>
function populateModule()
{
	var moduleName = $("#<?= $ids['module'] ?>").val();
	var moduleNameCap = moduleName.charAt(0).toUpperCase() + moduleName.slice(1);
	if (moduleName == 'mongo')
		$("#<?= $ids['db'] ?>").val("dbMongo");
	else if (moduleName == 'pay')
		$("#<?= $ids['db'] ?>").val("dbPay");
	else if (moduleName == 'cron')
		$("#<?= $ids['db'] ?>").val("dbCron");
	else
		$("#<?= $ids['db'] ?>").val("db");
	<?php if (\Yii::$app->id == 'papaya-rest') : ?>
	$("#<?= $ids['ns'] ?>").val("orm\\v1\\" + moduleName);
	<?php else: ?>
	$("#<?= $ids['ns'] ?>").val("orm\\" + moduleName);
	<?php endif; ?>
	if (moduleName == 'pay')
		$("#<?= $ids['tableName'] ?>").val("*");
	else
		$("#<?= $ids['tableName'] ?>").val("papaya_" + moduleName + ".*");
	$("#<?= $ids['messageCategory'] ?>").val("orm/" + moduleName);
}
</script>