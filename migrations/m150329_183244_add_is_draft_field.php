<?php
 
/**
 * @link http://www.matacms.com/
 * @copyright Copyright (c) 2015 Qi Interactive Limited
 * @license http://www.matacms.com/license/
 */

use yii\db\Schema;
use yii\db\Migration;

class m150329_183244_add_is_draft_field extends Migration
{
    
    public function safeUp()
    {
        $this->addColumn('{{%matacms_carousel}}', 'IsDraft', 'tinyint(1) NOT NULL DEFAULT 0');
    }

}
