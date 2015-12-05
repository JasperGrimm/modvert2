<?php namespace Modvert\Resource;

use Modvert\Driver\IDriver;

interface IRepository {

	public function setDriver(IDriver $driver);

	/**
	 * Возвращает коллекцию объектов IResource
	 *
	 * @param $type string
	 * @return Array<IResource>
	 */
	public function getAll($type);

	/**
	 * @param $type string
	 * @param $id int
	 * @return IResource
	 */
	public function getOnce($type, $id);

	/**
	 * @param $resources Array<IResource>
	 * @return bool
	 */
	public function updateAll($resources);

	/**
	 * @param $resource IResource
	 * @return bool
	 */
	public function updateOnce(IResource $resource);

}