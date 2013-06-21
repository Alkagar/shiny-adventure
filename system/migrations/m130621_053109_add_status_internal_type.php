<?php

class m130621_053109_add_status_internal_type extends CDbMigration
{
	public function up()
	{
            $this->addColumn('status', 'internal_type', "VARCHAR(2) default 'o'");
	}

	public function down()
	{
            $this->dropColumn('status', 'internal_type');
	}

}
