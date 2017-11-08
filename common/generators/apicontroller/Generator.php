<?php
/**
 * @link http://www.modelical.com/yii-template
 * @copyright Copyright (c) 2017 Modelical Consultoría S.L.
 * @license http://www.modelical.com/yii-template
 */

namespace common\generators\apicontroller;

use Yii;
use yii\gii\CodeFile;
use yii\helpers\Html;
use yii\helpers\StringHelper;

/**
 * Description of Generator
 *
 * @author Juan Ma <juanma@modelical.com>
 * @since 0.1.0
 */
class Generator extends \yii\gii\generators\controller\Generator
{
    public $baseClass = '\api\components\ActiveController';

    public $author = 'Juan Ma &lt;juanma@modelical.com&gt;';

    public $sinceVersion = '0.1.0';
    
    public $apiVersions = 'v1';

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'REST API Controller Generator';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            ['author', 'match', 'pattern' => '/^.* <[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]+>$/i', 'message' => Html::encode('Use something like "Your Name <your@mail.com>"')],
            ['sinceVersion', 'match', 'pattern' => '/^\d+.\d+.\d+$/', 'message' => 'Only 0-9 and dot characters are allowed.'],
            ['apiVersions', 'match', 'pattern' => '/^[a-z][a-z0-9\\-,\\s]*$/', 'message' => 'Only a-z, 0-9, dashes (-), spaces and commas are allowed.'],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return array_merge(
            parent::attributeLabels(),
            [
                'author' => 'Author',
                'sinceVersion' => 'Since version',
                'apiVersions' => 'API versions',
            ]
        );
    }

    /**
     * @inheritdoc
     */
    public function requiredTemplates()
    {
        $templates = [
            'controller.php',
        ];
        
        if($this->template == 'api') {
            $templates[] = 'controller-version.php';
        } else {
            $templates[] = 'view.php';
        }
        
        return $templates;
    }
    
    /**
     * @inheritdoc
     */
    public function hints()
    {
        return array_merge(
            parent::hints(),
            [
                'author' => Html::encode('Author information in the following form: "Your Name <mail@domain.com>.'),
                'sinceVersion' => 'Version since this class is implemented in the following form "x.y.z".',
                'apiVersions' => 'Generate controllers for the following API versions.',
            ]
        );
    }

    /**
     * @inheritdoc
     */
    public function stickyAttributes()
    {
        return array_merge(parent::stickyAttributes(), ['author', 'sinceVersion', 'apiVersions']);
    }
    
    /**
     * @inheritdoc
     */
    public function render($template, $params = [])
    {
        $params['author'] = $this->author;
        $params['sinceVersion'] = $this->sinceVersion;
        $params['apiVersions'] = $this->apiVersions;

        return parent::render($template, $params);
    }

    /**
     * @inheritdoc
     */
    public function generate()
    {
        $files = [];

        $files[] = new CodeFile(
            $this->getControllerFile(),
            $this->render('controller.php')
        );

        if($this->template == 'api') {
            $tempBaseClass = $this->baseClass;
            $tempControllerClass = $this->controllerClass;

            $this->baseClass = $this->controllerClass;
            
            foreach ($this->getApiVersionIDs() as $version) {
                $this->controllerClass = 'api\\modules\\' . $version . '\\controllers\\' . StringHelper::basename($tempControllerClass);
                $modelClass = '\api\\modules\\' . $version . '\\models\\' . str_replace('Controller', '', StringHelper::basename($tempControllerClass));

                $files[] = new CodeFile(
                    $this->getApiVersionControllerFile($version),
                    $this->render('controller-version.php', ['modelClass' => $modelClass])
                );
            }

            $this->baseClass = $tempBaseClass;
            $this->controllerClass = $tempControllerClass;
        } else {
            foreach ($this->getActionIDs() as $action) {
                $files[] = new CodeFile(
                    $this->getViewFile($action),
                    $this->render('view.php', ['action' => $action])
                );
            }
        }

        return $files;
    }

    /**
     * Normalizes [[apiVersions]] into an array of API version IDs.
     * @return array an array of API version IDs entered by the user
     */
    public function getApiVersionIDs()
    {
        $versions = array_unique(preg_split('/[\s,]+/', $this->apiVersions, -1, PREG_SPLIT_NO_EMPTY));
        sort($versions);

        return $versions;
    }

    /**
     * @param string $version the API version ID
     * @return string the API version controller file path
     */
    public function getApiVersionControllerFile($version)
    {
        return Yii::getAlias('@api/modules/' . $version . '/controllers/' . StringHelper::basename($this->controllerClass) . ".php");
    }
}
