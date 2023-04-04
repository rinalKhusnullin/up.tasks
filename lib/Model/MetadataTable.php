<?php
namespace Up\Tasks\Model;

use Bitrix\Main\Localization\Loc,
	Bitrix\Main\ORM\Data\DataManager,
	Bitrix\Main\ORM\Fields\DatetimeField,
	Bitrix\Main\ORM\Fields\IntegerField,
	Bitrix\Main\ORM\Fields\Relations\Reference,
	Bitrix\Main\ORM\Query\Join;

Loc::loadMessages(__FILE__);

/**
 * Class MetadataTable
 * 
 * Fields:
 * <ul>
 * <li> ID_TASK int mandatory
 * <li> DEADLINE datetime optional
 * <li> CREATING_DATE datetime mandatory
 * <li> UPDATING_DATE datetime mandatory
 * <li> LAST_ACTIVITY datetime optional
 * </ul>
 *
 * @package Bitrix\Tasks
 **/

class MetadataTable extends DataManager
{
	/**
	 * Returns DB table name for entity.
	 *
	 * @return string
	 */
	public static function getTableName()
	{
		return 'up_tasks_metadata';
	}

	/**
	 * Returns entity map definition.
	 *
	 * @return array
	 */
	public static function getMap()
	{
		return [
			(new IntegerField('ID_TASK',
				[]
			))->configureTitle(Loc::getMessage('METADATA_ENTITY_ID_TASK_FIELD'))
					->configurePrimary(true),
			(new DatetimeField('DEADLINE',
				[]
			))->configureTitle(Loc::getMessage('METADATA_ENTITY_DEADLINE_FIELD')),
			(new DatetimeField('CREATING_DATE',
				[]
			))->configureTitle(Loc::getMessage('METADATA_ENTITY_CREATING_DATE_FIELD'))
					->configureRequired(true),
			(new DatetimeField('UPDATING_DATE',
				[]
			))->configureTitle(Loc::getMessage('METADATA_ENTITY_UPDATING_DATE_FIELD'))
					->configureRequired(true),
			(new DatetimeField('LAST_ACTIVITY',
				[]
			))->configureTitle(Loc::getMessage('METADATA_ENTITY_LAST_ACTIVITY_FIELD')),

			(new Reference(
				'TASK',
				TaskTable::class,
				Join::on('this.ID_TASK', 'ref.ID')
			))->configureJoinType('inner'),
		];
	}
}