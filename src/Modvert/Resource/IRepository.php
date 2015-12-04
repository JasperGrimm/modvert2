<?php namespace Modvert\Resource;

interface IRepository {

	public function setDriver(\Modvert\Driver\IDriver $driver);

	/**
	 * Возвращает коллекцию объектов IResource
	 * @return Array<IResource>
	 */
	public function getAll(); 

	/**
	 * @param $id int
	 * @return IResource
	 */
	public function getOnce(int $id);

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