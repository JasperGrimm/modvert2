<?php namespace Modvert\Resource;

interface IResource {
	public function getId();
	public function getName();
	public function getType();

	/**
	 * @return mixed
	 */
	public function getCleanFields();

	public function getStringInfo();

	public function getInfo();

	public function getContent();

	public function setData($data);

	public function getData();
}
