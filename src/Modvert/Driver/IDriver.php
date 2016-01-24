<?php namespace Modvert\Driver;

use Modvert\Resource\IResource;

interface IDriver {
	/**
	 * @param $type
	 * @param $id
	 * @return IResource
	 */
	public function find($type, $id);
	public function findAll($type);
	public function insert(IResource $resource);
	public function update(IResource $resource);
	public function remove($type, $id);
	public function truncate($type);

	/**
	 * Return TRUE, if passed resource is different with this resource stored in current store
	 *
	 * @param IResource $resource
	 * @return mixed
	 */
	public function isChanged(IResource $resource);

	public function isLocked();
	public function getLocks();
	public function unlock();

	public function truncateAll();
}
