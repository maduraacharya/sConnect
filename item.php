<?php
class Item
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
    private $image_file_name;
    private $image;
    private $image_type;

    // constructor declaration
    public function setAttributes ($title, $description, $price, $seller_user_id, $category, $image_file_name, $image, $image_type) {
        $this->title = $title;
        $this->description = $description;
        $this->price = $price;
        $this->seller_user_id = $seller_user_id;
        $this->category = $category;
        $this->image_file_name = $image_file_name;
        $this->image = $image;
        $this->image_type = $image_type;
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
    
    public function setImageFileName ($image_file_name) {
        $this->image_file_name = $image_file_name;
    }
    
    public function setImage ($image) {
        $this->image = $image;
    }
    
    public function setImageType ($image_type) {
        $this->image_type = $image_type;
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
    
    public function getImageFileName () {
        return $this->image_file_name;
    }
    
    public function getImage () {
        return $this->image;
    }
    
    public function getImageType () {
        return $this->image_type;
    }
    
    public function fetchAsArray($ch, $item_id) {
		$query = "SELECT sconnect_item.id, sconnect_item.seller_user_id, date_format(sconnect_item.date_posted, '%M %e, %Y') as date_posted, sconnect_item.title, 
					sconnect_item.description, sconnect_item.price, sconnect_item.category, sconnect_user.first_name, sconnect_user.last_name, 
					sconnect_item.image_file_name, sconnect_item.image_type, sconnect_item.image 
					FROM sconnect_item, sconnect_user WHERE sconnect_item.seller_user_id = sconnect_user.user_id and sconnect_item.id = $item_id";
		$result = mysqli_query($ch, $query) or die("Query Error:" . mysqli_error($ch));
		if (mysqli_num_rows($result) > 0) { 
			$row = mysqli_fetch_assoc($result);
		}
		else {
			die("Error in fetching item data: Item does not exist.");
		}
		return $row;
	}
    
    public function fetch($ch, $item_id) {
		$row = $this->fetchAsArray($ch, $item_id);
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
		$this->setImageFileName($image_file_name);
		$this->setImage($image);
		$this->setImageType($image_type);
	}
	
	public function insert($ch) {
		$query = "INSERT INTO sconnect_item 
					(title, description, price, seller_user_id, category, image_file_name, image_type, image) 
				  VALUES
				  	('$this->title', '$this->description', '$this->price', $this->seller_user_id, '$this->category', '$this->image_file_name', '$this->image_type', '$this->image')";
		if (!mysqli_query($ch, $query)) {
			die("Query Error:" . mysqli_error($ch));
		}
		$this->id = mysqli_insert_id($ch);
	}
	
	public function update($ch) {
		if ($this->image == '') {
			$query = "UPDATE sconnect_item SET  
						title = '$this->title',
						description = '$this->description',
						price = '$this->price'
					  WHERE id = $this->id";
		}
		else {
			$query = "UPDATE sconnect_item SET  
						title = '$this->title',
						description = '$this->description',
						price = '$this->price',
						image_file_name = '$this->image_file_name',
						image_type = '$this->image_type',
						image = '$this->image'
					  WHERE id = $this->id";
		}
					
		if (!mysqli_query($ch, $query)) {
			die("Query Error:" . mysqli_error($ch));	
		}
	}
	
	public function delete($ch) {
		$q = "DELETE FROM sconnect_item WHERE id = $this->id";
		if (!mysqli_query($ch, $q)) {
			die("Query Error:" . mysqli_error($ch));
		}
	}
     
}
?>