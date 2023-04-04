<?php
namespace Up\Tasks\Model;

use Bitrix\Main\Localization\Loc,
	Bitrix\Main\ORM\Data\DataManager,
	Bitrix\Main\ORM\Fields\IntegerField,
	Bitrix\Main\ORM\Fields\StringField,
	Bitrix\Main\ORM\Fields\Validators\LengthValidator,
	Bitrix\Main\ORM\Fields\Relations\Reference,
	Bitrix\Main\ORM\Query\Join;

Loc::loadMessages(__FILE__);

/**
 * Class CommentTable
 * 
 * Fields:
 * <ul>
 * <li> ID int mandatory
 * <li> ID_TASK int mandatory
 * <li> COMMENT string(255) mandatory
 * </ul>
 *
 * @package Bitrix\Tasks
 **/

class CommentTable extends DataManager
{
	/**
	 * Returns DB table name for entity.
	 *
	 * @return string
	 */
	public static function getTableName()
	{
		return 'up_tasks_comment';
	}

	/**
	 * Returns entity map definition.
	 *
	 * @return array
	 */
	public static function getMap()
	{
		return [
			(new IntegerField('ID',
				[]
			))->configureTitle(Loc::getMessage('COMMENT_ENTITY_ID_FIELD'))
					->configurePrimary(true),
			(new IntegerField('ID_TASK',
				[]
			))->configureTitle(Loc::getMessage('COMMENT_ENTITY_ID_TASK_FIELD'))
					->configureRequired(true),
			(new StringField('COMMENT',
				[
					'validation' => [__CLASS__, 'validateComment']
				]
			))->configureTitle(Loc::getMessage('COMMENT_ENTITY_COMMENT_FIELD'))
					->configureRequired(true),
			
			(new Reference(
				'TASK',
				TaskTable::class,
				Join::on('this.ID_TASK', 'ref.ID')
			))->configureJoinType('inner'),
		];
	}

	/**
	 * Returns validators for COMMENT field.
	 *
	 * @return array
	 */
	public static function validateComment()
	{
		return [
			new LengthValidator(null, 255),
		];
	}
}