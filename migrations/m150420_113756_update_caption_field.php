<?php
 
/**
 * @link http://www.matacms.com/
 * @copyright Copyright (c) 2015 Qi Interactive Limited
 * @license http://www.matacms.com/license/
 */

use yii\db\Schema;
use yii\db\Migration;

class m150420_113756_update_caption_field extends Migration
{
	
	public function safeUp()
    {
        $this->alterColumn('{{%matacms_carouselitem}}', 'Caption', Schema::TYPE_TEXT);
    }

    public function safeDown()
    {
        $this->alterColumn('{{%matacms_carouselitem}}', 'Caption', Schema::TYPE_STRING);
    }

}
