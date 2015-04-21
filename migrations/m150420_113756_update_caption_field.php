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
 * @author Dmitry Erofeev <dmeroff@gmail.com>
 */
class m150420_113756_update_caption_field extends Migration
{
	public function up()
    {
        $this->alterColumn('{{%matacms_carouselitem}}', 'Caption', Schema::TYPE_TEXT);
    }

    public function down()
    {
        $this->alterColumn('{{%matacms_carouselitem}}', 'Caption', Schema::TYPE_STRING);
    }

}
