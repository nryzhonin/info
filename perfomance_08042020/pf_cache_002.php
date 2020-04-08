<?
class User {
	private $userData;
	function __construct($userId = false) {
		if(!$userId) { global $USER; $userId = $USER->GetID(); }

		$cntStartCacheId = __CLASS__.'::'.__FUNCTION__.'|'.SITE_ID.'|'.$userId;
		$cache = new \CXxxCache(
			$cntStartCacheId.'sid0',
			604800, // одна неделя
			'user_data/'.substr(md5($userId),2,2).'/'.$userId
		);

		$this->userData = $cache->Init();

		if(null == $this->userData)
		{
			$this->putUserData(array("ID"=>$userId));
			$this->putUserData(\CUser::GetList(...)->Fetch());
			$this->putUserData(array("DEPARTMENT" => $this->getDepartment()));
			$cache->registerTag('USER_NAME_'.$userId);
			$cache->set($this->userData);
		}
	}
}
