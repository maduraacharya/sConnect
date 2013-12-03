<?php
class Service
{
    // property declaration
    private $id;
    private $date_posted;
    private $title; // post title
    private $description; // post description
    private $price; // price
    private $seller_user_id;
    private $seller_first_name;
    private $seller_last_name;
    private $category;

    // constructor declaration
    public function setAttributes ($title, $description, $price, $seller_user_id, $category) {
        $this->title = $title;
        $this->description = $description;
        $this->price = $price;
        $this->seller_user_id = $seller_user_id;
        $this->category = $category;
    }
    
    public function setID ($item_id) {
        $this->id = $item_id;
    }
    
    public function setDatePosted ($date_posted) {
        $this->date_posted = $date_posted;
    }
    
    public function setTitle ($title) {
        $this->title = $title;
    }
    
    public function setDescription ($description) {
        $this->description = $description;
    }
    
    public function setPrice ($price) {
        $this->price = $price;
    }
    
    public function setSellerUserID ($seller_user_id) {
        $this->seller_user_id = $seller_user_id;
    }
    
    public function setSellerFirstName ($seller_first_name) {
        $this->seller_first_name = $seller_first_name;
    }
    
    public function setSellerLastName ($seller_last_name) {
        $this->seller_last_name = $seller_last_name;
    }
    
    public function setCategory ($category) {
        $this->category = $category;
    }
    
    public function getID () {
        return $this->id;
    }
    
    public function getDatePosted () {
        return $this->date_posted;
    }
    
    public function getTitle () {
        return $this->title;
    }
    
    public function getDescription () {
        return $this->description;
    }
    
    public function getPrice () {
        return $this->price;
    }
    
    public function getSellerUserID () {
        return $this->seller_user_id;
    }
    
    public function getSellerFirstName () {
        return $this->seller_first_name;
    }
    
    public function getSellerLastName () {
        return $this->seller_last_name;
    }
    
    public function getCategory () {
        return $this->category;
    }

    public function fetchAsArray($ch, $service_id) {
		$query = "SELECT sconnect_service.id, sconnect_service.seller_user_id, date_format(sconnect_service.date_posted, '%M %e, %Y') as date_posted, 
					sconnect_service.title, sconnect_service.description, sconnect_user.first_name, sconnect_user.last_name, 
					sconnect_service.price, sconnect_service.category
				  FROM sconnect_service, sconnect_user 
				  WHERE sconnect_service.seller_user_id = sconnect_user.user_id and sconnect_service.id = $service_id";
		$result = mysqli_query($ch, $query) or die("Query Error:" . mysqli_error($ch));
		if (mysqli_num_rows($result) > 0) { 
			$row = mysqli_fetch_assoc($result);
		}
		else {
			die("Error in fetching item data: Item does not exist");
		}
		return $row;
	}
    
    public function fetch($ch, $service_id) {
		$row = $this->fetchAsArray($ch, $service_id);
		extract($row);
		$this->setID($id);
		$this->setDatePosted($date_posted);
		$this->setTitle($title);
		$this->setDescription($description);
		$this->setPrice($price);
		$this->setSellerUserID($seller_user_id);
		$this->setSellerFirstName($first_name);
		$this->setSellerLastName($last_name);
		$this->setCategory($category);
	}
	
	public function insert($ch) {
		$query = "INSERT INTO sconnect_service
					(title, description, price, seller_user_id, category) 
				  VALUES
				  	('$this->title', '$this->description', NULLIF('$this->price',''), $this->seller_user_id, '$this->category')";
		if (!mysqli_query($ch, $query)) {
			die("Query Error:" . mysqli_error($ch));	
		}
		$this->id = mysqli_insert_id($ch);
	}
	
	public function update($ch) {
		$query = "UPDATE sconnect_service SET  
					title = '$this->title',
					description = '$this->description',
					price = NULLIF('$this->price','')
				  WHERE id = $this->id";			
		if (!mysqli_query($ch, $query)) {
			die("Query Error:" . mysqli_error($ch));	
		}
	}
	
	public function delete($ch) {
		$q = "DELETE FROM sconnect_service WHERE id = $this->id";
		if (!mysqli_query($ch, $q)) {
			die("Query Error:" . mysqli_error($ch));
		}
	}
     
}
?>