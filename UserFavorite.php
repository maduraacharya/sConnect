<?php
class UserFavorite
{
    // property declaration
    private $id;
    private $user_id; // person creating the favorite
    private $post_id; // item or service identifier
    private $post_type; // item or service

    // constructor declaration
    public function setAttributes ($user_id, $post_id, $post_type) {
        $this->user_id = $user_id;
        $this->post_id = $post_id;
        $this->post_type = $post_type;
    }
    
    public function setFavoriteID ($favorite_id) {
        $this->id = $favorite_id;
    }
    
    public function setUserID ($user_id) {
        $this->user_id = $user_id;
    }
    
    public function setPostID ($post_id) {
        $this->post_id = $post_id;
    }
    
    public function setPostType ($post_type) {
        $this->post_type = $post_type;
    }
    
    public function getFavoriteID () {
        return $this->id;
    }
    
    public function getUserID () {
        return $this->user_id;
    }
    
    public function getPostID () {
        return $this->post_id;
    }
    
    public function getPostType () {
        return $this->post_type;
    }
    
    public function fetch($ch) {
    	$query = "SELECT id, user_id, post_id, post_type FROM sconnect_user_favorites
    				WHERE user_id = $this->user_id
    				AND post_id = $this->post_id
    				AND post_type = '$this->post_type'";
    	$result = mysqli_query($ch, $query);

    	if (mysqli_num_rows($result) > 0) {
    		$row = mysqli_fetch_assoc($result);
    		extract($row);
    		$this->id = $id;
			$this->user_id = $user_id;
        	$this->post_id = $post_id;
        	$this->post_type = $post_type;
		}
    }
    
    public function insert($ch) {
    	$query = "SELECT COUNT(1) as rec_count FROM sconnect_user_favorites
    				WHERE user_id = $this->user_id
    				AND post_id = $this->post_id
    				AND post_type = '$this->post_type'";
    	$result = mysqli_query($ch, $query);
    	$row = mysqli_fetch_assoc($result);

    	if ($row['rec_count'] == 0) {
			$query = "INSERT INTO sconnect_user_favorites (user_id, post_id, post_type) VALUES
					($this->user_id, $this->post_id, '$this->post_type')";
			if (!mysqli_query($ch, $query)) {
				die("Query Error: " . mysqli_error($ch));
			}
		}
    }
    
    public function delete($ch) {
		$query = "DELETE FROM sconnect_user_favorites 
					WHERE id = $this->id";
		if (!mysqli_query($ch, $query)) {
			die("Query Error: " . mysqli_error($ch));
		}
    }
     
}
?>