<?php
namespace Helpers;

use Helpers\Database;
use Helpers\Cookie;

class CurrentUserData
{
    private static $db;

	// Get user data for requested user's profile
	public static function getCUD($where_id){
		self::$db = Database::get();
		$user_data = self::$db->select("
				SELECT 
					u.userID, 
					u.username, 
					u.firstName, 
					u.gender, 
					u.userImage,
					u.email,
					u.LastLogin, 
					u.SignUp,
					ue.userID,
					ue.website,
					ue.aboutme
				FROM 
					".PREFIX."users u
				LEFT JOIN
					".PREFIX."users_extprofile ue
					ON u.userID = ue.userID
				WHERE 
					u.userID = :userID
				",
			array(':userID' => $where_id));
		return $user_data;
	}
	
}


