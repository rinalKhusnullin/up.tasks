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
 * Class StatusTable
 * 
 * Fields:
 * <ul>
 * <li> ID int mandatory
 * <li> TITLE string(80) mandatory
 * <li> COLOR_SCHEME string(6) optional
 * </ul>
 *
 * @package Bitrix\Tasks
 **/

class StatusTable extends DataManager
{
	/**
	 * Returns DB table name for entity.
	 *
	 * @return string
	 */
	public static function getTableName()
	{
		return 'up_tasks_status';
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
			))->configureTitle(Loc::getMessage('STATUS_ENTITY_ID_FIELD'))
					->configurePrimary(true),
			(new StringField('TITLE',
				[
					'validation' => [__CLASS__, 'validateTitle']
				]
			))->configureTitle(Loc::getMessage('STATUS_ENTITY_TITLE_FIELD'))
					->configureRequired(true),
			(new StringField('COLOR_SCHEME',
				[
					'validation' => [__CLASS__, 'validateColorScheme']
				]
			))->configureTitle(Loc::getMessage('STATUS_ENTITY_COLOR_SCHEME_FIELD')),

			(new Reference(
				'TASK',
				TaskTable::class,
				Join::on('this.ID', 'ref.ID_STATUS')
			))->configureJoinType('inner'),
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
	 * Returns validators for COLOR_SCHEME field.
	 *
	 * @return array
	 */
	public static function validateColorScheme()
	{
		return [
			new LengthValidator(null, 6),
		];
	}
}