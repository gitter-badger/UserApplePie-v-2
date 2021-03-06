<?php

/**
* Model to get all user Data from users database
*/

namespace Models;

class UserData extends \Core\Model {

	/**
	 * Get current user's username from database
	 */
	public function getUserName($where_id){
		$data = $this->db->select("SELECT username FROM ".PREFIX."users WHERE userID = :userID",
			array(':userID' => $where_id));
		return $data[0]->username;
	}

	/**
	 * Get current user's id from database
	 */
	public function getUserID($where_username){
		$data = $this->db->select("SELECT userID FROM ".PREFIX."users WHERE username = :username",
			array(':username' => $where_username));
		return $data[0]->userID;
	}
	
	/**
	 * Get current user's Email from database
	 */
	public function getUserEmail($where_id){
		$data = $this->db->select("SELECT email FROM ".PREFIX."users WHERE userID = :userID",
			array(':userID' => $where_id));
		return $data[0]->email;
	}
	
	/**
	 * Get current user's Last Login Date from database
	 */
	public function getUserLastLogin($where_id){
		$data = $this->db->select("SELECT LastLogin FROM ".PREFIX."users WHERE userID = :userID",
			array(':userID' => $where_id));
		return $data[0]->LastLogin;
	}
	
	/**
	 * Get current user's Sign Up Date from database
	 */
	public function getUserSignUp($where_id){
		$data = $this->db->select("SELECT SignUp FROM ".PREFIX."users WHERE userID = :userID",
			array(':userID' => $where_id));
		return $data[0]->SignUp;
	}
	
	/**
	 * Get current user's Group
	 */
	public function getUserGroupName($where_id){
		// Get user's group ID
		$data = $this->db->select("SELECT groupID FROM ".PREFIX."users_groups WHERE userID = :userID ORDER BY groupID ASC",
			array(':userID' => $where_id));
		//$groupID = $data[0]->groupID;
		foreach($data as $row){
			// Use group ID to get the group name
			$data2 = $this->db->select("SELECT groupName, groupFontColor, groupFontWeight FROM ".PREFIX."groups WHERE groupID = :groupID",
				array(':groupID' => $row->groupID));
			$groupName = $data2[0]->groupName;
			$groupColor = "color='".$data2[0]->groupFontColor."'";
			$groupWeight = "style='font-weight:".$data2[0]->groupFontWeight."'";
			// Format the output with font style
			$groupOutput[] = "<font $groupColor $groupWeight>$groupName</font>";
		}
		return $groupOutput;	
	}
	
	// Gets list of members that have activated accounts
	public function getMembers(){
		// Get online users userID
		$data = $this->db->select("
				SELECT 
					u.userID,
					u.username,
					u.firstName,
					u.isactive,
					ug.userID,
					ug.groupID,
					g.groupID,
					g.groupName,
					g.groupFontColor,
					g.groupFontWeight
				FROM 
					uap_users u
				LEFT JOIN
					uap_users_groups ug
					ON u.userID = ug.userID
				LEFT JOIN
					uap_groups g
					ON ug.groupID = g.groupID
				WHERE
					u.isactive=1
				GROUP BY
					u.userID
				ORDER BY 
					u.userID ASC, g.groupID DESC
		");
		return $data;
	}
	
}