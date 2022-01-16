<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>pagination</title>
    <style>
        body {
            background-color: gray;

        }

        #container {
            width: 44.8%;
            margin: 0 auto;
            
        }

        th {
            font-size: 25px;
            padding-left: 40px;
            padding-right: 40px;
            background-color: rgb(48, 119, 224);
            font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
            letter-spacing: 1.5px;
        }

        tr:nth-child(odd) {
            background-color: rgba(209, 230, 114, 0.788);
        }
        tr:nth-child(even) {
            background-color: rgba(224, 185, 137, 0.836);
        }

        td {
            font-size: 15px;
            font-family: Arial, Helvetica, sans-serif;
        }

        .pagination {
  display: inline-block;
  font-size:23px;
  margin-top:20px;
}

.pagination a {
  color: black;
  float: left;
  padding: 8px 16px;
  text-decoration: none;
}

.pagination a.active {
  background-color: #4CAF50;
  color: white;
  border-radius: 5px;
}

.pagination a:hover:not(.active) {
  background-color: #ddd;
  border-radius: 5px;
}
    </style>
</head>

<body>
    <div id="container">

        <table border="3px" cellpadding="10px" cellspacing="0">

            <tr>
                <th>Id</th>
                <th>Name</th>
                <th>Age</th>
                <th>Gender</th>
            </tr>
            <tbody>
                <?php 
                 $limit = 5; 
                 //when we run the pgae at 1st time it will show an errror bcz page value is not passed
                //  for that we have to set page value at starting as 1
                if(isset($_GET["page"]))
                {
                    $pageno = $_GET["page"]; 
                }
                else
                {
                    $pageno =1; // so here page is set at 1st page
                }
                //  echo $pageno;
                //  now we have to find offset bcx from next page the record should be continue to find the offset value
                //  which is used in a querry 
                //  the formula  offset = (pagenumber-1)*limit
                $offset = ($pageno-1)*$limit;
                // echo $offset." ";
                $conn = mysqli_connect("localhost","root","","shah1") or die("connection fail");
                $sql = "select *
                from pagination
                limit {$offset},{$limit}
                ";
                $result = mysqli_query($conn,$sql) or die("query unsuccessfull");
                if(mysqli_num_rows($result)>0)
                {
                 while($rows = mysqli_fetch_assoc($result))
                 {

                 
                ?>
                <tr>
                    <td col="2"><?php echo $rows["id"]; ?></td>
                    <td><?php echo $rows["name"]; ?></td>
                    <td><?php echo $rows["age"]; ?></td>
                    <td><?php echo $rows["gender"]; ?></td>
                </tr>
                <?php 
                 }
                }
                else{
                   echo "<td colspan=4><center>no records find</center></td>";
                }
                ?>
            </tbody>
        </table>

   <center>
   <div class="pagination">
       <?php 
       $sql2= "select * 
       from pagination
       ";
       $result2 = mysqli_query($conn,$sql2);
       if(mysqli_num_rows($result2)>0)
       {
           $total_records = mysqli_num_rows($result2); //it will storing total no of records present in the table
        //    echo $total_records;  
        // $limit = 6;         //we have to set the limit till that only records will be showm
        $total_pages = ceil($total_records/$limit); //forula for finding the totalpages = totalrecords/limit and ceil method will give decimal value of an upper value
        // echo $total_pages;
        
        $j = $pageno-1; //this is a symbol change page for decrementing the page
        if($j==0)
        {
            $j=1; //when the page will become 0 it will show error soo again we need to change page to 1
        }
        echo "<a href='pagination.php?page=$j'>&laquo;</a>";


        for($i=1;$i<=$total_pages;$i++)
        {
            if($i==$pageno){
                $active = "active";
            }
            else{
                $active ="";
            }
            
            
               echo "<a href='pagination.php?page=$i' class='{$active}'>$i</a>";
            //    echo '<a href="#" class="active">2</a> ';
            
           
        }


        $k = $pageno+1; //this is a symbol change page for incrementing the page
        if($k>=$total_pages)
        {
            $k = $total_pages;
        }
           echo "<a href='pagination.php?page=$k'>&raquo;</a>";      




        }
        ?>
        </div>
    </center>
    </div>
</body>

</html>