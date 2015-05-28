<?php
 
/**
 * @link http://www.matacms.com/
 * @copyright Copyright (c) 2015 Qi Interactive Limited
 * @license http://www.matacms.com/license/
 */

use yii\db\Schema;
use yii\db\Migration;

class m150310_174915_init extends Migration {

	public function safeUp() {
		$this->createTable('{{%matacms_carousel}}', [
			'Id' => Schema::TYPE_PK,
			'Title' => Schema::TYPE_STRING . '(128) NOT NULL',
			'Region' => Schema::TYPE_STRING . '(128) NOT NULL',
			]);

		$this->createTable('{{%matacms_carouselitem}}', [
			'Id' => Schema::TYPE_PK,
			'CarouselId' => Schema::TYPE_INTEGER . ' NOT NULL',
			'Caption' => Schema::TYPE_STRING . '(128)',
			'Order' => Schema::TYPE_INTEGER,
			]);
		$this->addForeignKey('fk_matacms_carouselitem', '{{%matacms_carouselitem}}', 'CarouselId', '{{%matacms_carousel}}', 'Id', 'CASCADE', 'RESTRICT');
	}

	public function safeDown() {
		$this->dropTable('{{%matacms_carouselitem}}');
		$this->dropTable('{{%matacms_carousel}}');
	}
}
