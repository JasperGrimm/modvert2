<?php namespace Modvert\Driver;

interface IDriver {
	public function find($id);
	public function insert($data);
	public function update(Modvert\Resource\IResource $resource);
	public function remove($id);
}