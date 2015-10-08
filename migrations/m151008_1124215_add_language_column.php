<?php

/**
 * @link http://www.matacms.com/
 * @copyright Copyright (c) 2015 Qi Interactive Limited
 * @license http://www.matacms.com/license/
 */

use yii\db\Schema;
use yii\db\Migration;

class m151008_1124215_add_language_column extends Migration {

	public function safeUp() {
		$this->addColumn('{{%matacms_carousel}}', 'Language', 'varchar(16) NULL');
		$this->addColumn('{{%matacms_carouselitem}}', 'Language', 'varchar(16) NULL');
	}

	public function safeDown() {
		$this->dropColumn('{{%matacms_carousel}}', 'Language');
		$this->dropColumn('{{%matacms_carouselitem}}', 'Language');
	}
}
