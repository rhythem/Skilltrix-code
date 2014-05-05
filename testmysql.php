 <?php
        $connect=mysql_connect("mysqlrds.cnlumbwae2nk.us-east-1.rds.amazonaws.com","stlrusr","QvaVKPTZrpmEQFZA") or die("Unable to Connect");
        mysql_select_db("lr") or die("Could not open the db");
        $showtablequery="SHOW TABLES FROM lr";
        $query_result=mysql_query($showtablequery);
        while($showtablerow = mysql_fetch_array($query_result))
        {
        echo $showtablerow[0]." ";
        } 
        ?>