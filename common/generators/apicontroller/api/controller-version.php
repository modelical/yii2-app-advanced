<?php
/**
 * This is the template for generating a controller class file.
 */

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator common\generators\controller\Generator */

echo "<?php\n";
?>
/**
 * @link http://www.modelical.com/yii-template
 * @copyright Copyright (c) 2017 Modelical Consultoría S.L.
 * @license http://www.modelical.com/yii-template
 */

namespace <?= $generator->getControllerNamespace() ?>;

/**
 * Description of <?= StringHelper::basename($generator->controllerClass) . "\n" ?>
 *
 * @author <?= $author . "\n" ?>
 * @since <?= $sinceVersion . "\n" ?>
 */
class <?= StringHelper::basename($generator->controllerClass) ?> extends <?= '\\' . trim($generator->baseClass, '\\') . "\n" ?>
{
    public $modelClass = '<?= $modelClass ?>';

<?php foreach ($generator->getActionIDs() as $action): ?>
    public function action<?= Inflector::id2camel($action) ?>()
    {
        return $this->render('<?= $action ?>');
    }

<?php endforeach; ?>
}
