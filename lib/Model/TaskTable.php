<?php
namespace Up\Tasks\Model;

use Bitrix\Main\Localization\Loc,
	Bitrix\Main\ORM\Data\DataManager,
	Bitrix\Main\ORM\Fields\IntegerField,
	Bitrix\Main\ORM\Fields\StringField,
	Bitrix\Main\ORM\Fields\Validators\LengthValidator,
	Bitrix\Main\ORM\Fields\Relations\OneToMany,
	Bitrix\Main\ORM\Fields\Relations\Reference,
	Bitrix\Main\ORM\Query\Join;

Loc::loadMessages(__FILE__);

/**
 * Class TaskTable
 * 
 * Fields:
 * <ul>
 * <li> ID int mandatory
 * <li> TITLE string(80) mandatory
 * <li> DESCRIPTION string(255) mandatory
 * <li> IS_COMPLETED int mandatory
 * <li> ID_PRIORITY int mandatory
 * </ul>
 *
 * @package Bitrix\Tasks
 **/

class TaskTable extends DataManager
{
	/**
	 * Returns DB table name for entity.
	 *
	 * @return string
	 */
	public static function getTableName()
	{
		return 'up_tasks_task';
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
			))->configureTitle(Loc::getMessage('TASK_ENTITY_ID_FIELD'))
					->configurePrimary(true),
			(new StringField('TITLE',
				[
					'validation' => [__CLASS__, 'validateTitle']
				]
			))->configureTitle(Loc::getMessage('TASK_ENTITY_TITLE_FIELD'))
					->configureRequired(true),
			(new StringField('DESCRIPTION',
				[
					'validation' => [__CLASS__, 'validateDescription']
				]
			))->configureTitle(Loc::getMessage('TASK_ENTITY_DESCRIPTION_FIELD'))
					->configureRequired(true),
			(new IntegerField('IS_COMPLETED',
				[]
			))->configureTitle(Loc::getMessage('TASK_ENTITY_IS_COMPLETED_FIELD'))
					->configureRequired(true),
			(new IntegerField('ID_PRIORITY',
				[]
			))->configureTitle(Loc::getMessage('TASK_ENTITY_ID_PRIORITY_FIELD'))
					->configureRequired(true),

			(new Reference(
				'METADATA',
				MetadataTable::class,
				Join::on('this.ID', 'ref.ID_TASK')
			))->configureJoinType('inner'),

			(new Reference(
				'PRIORITY',
				PriorityTable::class,
				Join::on('this.ID_PRIORITY', 'ref.ID')
			))->configureJoinType('inner'),

			(new OneToMany('COMMENTS', CommentTable::class, 'TASK'))->configureJoinType('inner'),
		];
	}

	/**
	 * Returns validators for TITLE field.
	 *
	 * @return array
	 */
	public static function validateTitle()
	{
		return [
			new LengthValidator(null, 80),
		];
	}

	/**
	 * Returns validators for DESCRIPTION field.
	 *
	 * @return array
	 */
	public static function validateDescription()
	{
		return [
			new LengthValidator(null, 255),
		];
	}
}