<?php
class uniqueProcess {

	/**
	 * --------------------------------------------------------------
	 * 利用微秒时间和10000~30000的随机数产生唯一id
	 * --------------------------------------------------------------
	 * @return $		唯一id
	 */
	public function produceUniqueId1() {
		$timeString = explode(".", microtime());
		$namestr = str_replace(" ", "", $timeString[1]);
		return rand(10000, 30000).$namestr;
	}
}
?>