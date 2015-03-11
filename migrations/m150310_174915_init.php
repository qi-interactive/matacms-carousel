<?php

/*
 * This file is part of the mata project.
 *
 * (c) mata project <http://github.com/mata/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use yii\db\Schema;
use yii\db\Migration;

/**
 * @author Dmitry Erofeev <dmeroff@gmail.com
 */
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
			]);
		$this->addForeignKey('fk_matacms_carouselitem', '{{%matacms_carouselitem}}', 'CarouselId', '{{%matacms_carousel}}', 'Id', 'CASCADE', 'RESTRICT');
	}

	public function safeDown() {
		$this->dropTable('{{%matacms_carouselitem}}');
		$this->dropTable('{{%matacms_carousel}}');
	}
}