<?php
namespace tomk79\pickles2\px2report;

/**
 * PX Plugin "px2-report"
 */
class main{
	private $px;

	/**
	 * コンストラクタ
	 * @param $px = PxFWコアオブジェクト
	 */
	public function __construct($px){
		$this->px = $px;
	}

}
