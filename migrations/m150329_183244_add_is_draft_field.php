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
class m150329_183244_add_is_draft_field extends Migration
{
    
    public function up()
    {
        $this->addColumn('{{%matacms_carousel}}', 'IsDraft', 'tinyint(1) NOT NULL DEFAULT 0');
    }

}
