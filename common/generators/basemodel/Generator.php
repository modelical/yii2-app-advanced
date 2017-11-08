<?php
/**
 * @link http://www.modelical.com/yii-template
 * @copyright Copyright (c) 2017 Modelical Consultoría S.L.
 * @license http://www.modelical.com/yii-template
 */

namespace common\generators\basemodel;

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
class Generator extends \yii\gii\generators\model\Generator
{
    public $ns = 'common\models';

    public $author = 'Juan Ma &lt;juanma@modelical.com&gt;';

    public $sinceVersion = '0.1.0';

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'Base Model Generator';
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            ['author', 'match', 'pattern' => '/^.* <[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]+>$/i', 'message' => Html::encode('Use something like "Your Name <your@mail.com>"')],
            ['sinceVersion', 'match', 'pattern' => '/^\d+.\d+.\d+$/', 'message' => 'Only 0-9 and dot characters are allowed.'],
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
            ]
        );
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
            ]
        );
    }

    /**
     * @inheritdoc
     */
    public function stickyAttributes()
    {
        return array_merge(parent::stickyAttributes(), ['author', 'sinceVersion']);
    }
    
    /**
     * @inheritdoc
     */
    public function render($template, $params = [])
    {
        $params['author'] = $this->author;
        $params['sinceVersion'] = $this->sinceVersion;

        return parent::render($template, $params);
    }

    /**
     * @inheritdoc
     */
    public function generate()
    {
        $initialNamespace = $this->ns;
        $initialBaseClass = $this->baseClass;

        $files = [];
        $relations = $this->generateRelations();
        $db = $this->getDbConnection();
        foreach ($this->getTableNames() as $tableName) {
            // Custom model :
            $this->ns = $initialNamespace;
            $this->baseClass = $initialNamespace . "\\base\\" . $this->generateClassName($tableName) . "Base";
            
            $modelClassName = $this->generateClassName($tableName);
            $queryClassName = ($this->generateQuery) ? $this->generateQueryClassName($modelClassName) : false;
            $tableSchema = $db->getTableSchema($tableName);
            $params = [
                'tableName' => $tableName,
                'className' => $modelClassName,
                'queryClassName' => $queryClassName,
                'tableSchema' => $tableSchema,
                'labels' => $this->generateLabels($tableSchema),
                'rules' => $this->generateRules($tableSchema),
                'relations' => isset($relations[$tableName]) ? $relations[$tableName] : [],
            ];
            $files[] = new CodeFile(
                Yii::getAlias('@' . str_replace('\\', '/', $this->ns)) . '/' . $modelClassName . '.php',
                $this->render('model.php', $params)
            );
            
            // Base model :
            $this->ns = $initialNamespace . "\\base";
            $this->baseClass = $initialBaseClass;
            
            $modelClassName = $this->generateClassName($tableName) . "Base";
            $queryClassName = ($this->generateQuery) ? $this->generateQueryClassName($modelClassName) : false;
            $tableSchema = $db->getTableSchema($tableName);
            $params = [
                'tableName' => $tableName,
                'className' => $modelClassName,
                'queryClassName' => $queryClassName,
                'tableSchema' => $tableSchema,
                'labels' => $this->generateLabels($tableSchema),
                'rules' => $this->generateRules($tableSchema),
                'relations' => isset($relations[$tableName]) ? $relations[$tableName] : [],
            ];
            $files[] = new CodeFile(
                Yii::getAlias('@' . str_replace('\\', '/', $this->ns)) . '/' . $modelClassName . '.php',
                $this->render('model-base.php', $params)
            );

            // query :
            if ($queryClassName) {
                $params['className'] = $queryClassName;
                $params['modelClassName'] = $modelClassName;
                $files[] = new CodeFile(
                    Yii::getAlias('@' . str_replace('\\', '/', $this->queryNs)) . '/' . $queryClassName . '.php',
                    $this->render('query.php', $params)
                );
            }
        }
        
        //$files = parent::generate();
        
        $this->ns = $initialNamespace;
        $this->baseClass = $initialBaseClass;
        
        return $files;
    }
}