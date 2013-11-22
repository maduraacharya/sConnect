<html>
<head>
<title>Paging Using PHP</title>
</head>
<body>
<?php
    $dbhost = 'localhost';
    $dbuser = 'root';
    $dbpass = 'root';
    $rec_limit = 10;
    
    $table_name = 'sconnect_service'; // 'sconnect_service'; 'sconnect_item';
    
    $conn = mysql_connect($dbhost, $dbuser, $dbpass);
    if(! $conn )
    {
        die('Could not connect: ' . mysql_error());
    }
    mysql_select_db('sconnect');
    /* Get total number of records */
    $sql = "SELECT count(id) FROM ". $table_name;
    $retval = mysql_query( $sql, $conn );
    if(! $retval )
    {
        die('Could not get data: ' . mysql_error());
    }
    $row = mysql_fetch_array($retval, MYSQL_NUM );
    $rec_count = $row[0];
    
    if( isset($_GET{'page'} ) )
    {
        $page = $_GET{'page'} + 1;
        $offset = $rec_limit * $page ;
    }
    else
    {
        $page = 0;
        $offset = 0;
    }
    $left_rec = $rec_count - ($page * $rec_limit);
    
    $item_sql = "SELECT id, date_posted, date_sold, title, description, price, seller_user_id ".
    "FROM sconnect_item ".
    "LIMIT $offset, $rec_limit";
    
    $service_sql = "SELECT id, date_posted, title, description, seller_user_id ".
    "FROM sconnect_service ".
    "LIMIT $offset, $rec_limit";
    
    
    $retval = mysql_query( $service_sql, $conn );
    if(! $retval )
    {
        die('Could not get data: ' . mysql_error());
    }
    while($row = mysql_fetch_array($retval, MYSQL_ASSOC))
    {
        //        echo "ITEM ID :{$row['id']}  <br> ".
        //        "Date Posted :{$row['date_posted']}  <br> ".
        //        "Date Sold :{$row['date_sold']}  <br> ".
        //        "Title :{$row['title']}  <br> ".
        //        "Description :{$row['description']}  <br> ".
        //        "Price :{$row['price']}  <br> ".
        //        "Seller ID :{$row['seller_user_id']}  <br> ".
        //        "--------------------------------<br>";
        
        echo "ITEM ID :{$row['id']}  <br> ".
        "Date Posted :{$row['date_posted']}  <br> ".
        "Title :{$row['title']}  <br> ".
        "Description :{$row['description']}  <br> ".
        "Seller ID :{$row['seller_user_id']}  <br> ".
        "--------------------------------<br>";
        
    }
    
    if( $page > 0 )
    {
        $last = $page - 2;
        echo "<a href=\"$_PHP_SELF?page=$last\">Last 10 Records</a> |";
        echo "<a href=\"$_PHP_SELF?page=$page\">Next 10 Records</a>";
    }
    else if( $page == 0 )
    {
        echo "<a href=\"$_PHP_SELF?page=$page\">Next 10 Records</a>";
    }
    else if( $left_rec < $rec_limit )
    {
        $last = $page - 2;
        echo "<a href=\"$_PHP_SELF?page=$last\">Last 10 Records</a>";
    }
    mysql_close($conn);
    ?>
