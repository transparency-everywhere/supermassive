<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of class_db
 *
 * @author Transparency Everywhere
 */
function save($string){
        return $string;
}
class db{
        /**
        *Inserts record with $options into db $table 
        *@param string $table Name of table
        *@param array $options Array with insert values mysql_field_name=>values
        *@return int auto_increment value of added record 
        */
	public function insert($table, $options){
					
            //generate update query	
            foreach($options AS $row=>$value){
                    $query[] = "`".save($row)."`";
                    $values[] = "'".save($value)."'";
            }


            $query = "(".implode(',', $query).")";
            $values = "(".implode(',', $values).");";


            mysql_query("INSERT INTO `$table` $query VALUES $values");
            return mysql_insert_id();
	}        /**
        *Updates record with $primary[0]=$primary[1] in db $table 
        *@param string $table Name of table
        *@param array $options Array with insert values mysql_field_name=>values
        *@param primary array Primary id of the record
        *@return int affected rows
        */
	public function update($table, $options, $primary){
					
            //generate update query	
            foreach($options AS $row=>$value){

                    //only add row to query if value is not empty
                    if(!empty($value) ||($value == 0)){
                            $query[] = " $row='".save($value)."'";
                    }
            }
            $query = implode(',', $query);

            
            mysql_query("UPDATE `$table` SET $query WHERE $primary[0]='".save($primary[1])."'");
            return mysql_affected_rows();
	}
        /**
        *Updates record with $primary[0]=$primary[1] in db $table 
        *@param string $table Name of table
        *@primary array Primary id of the record 
        */
        public function delete($table, $primary){
            mysql_query("DELETE FROM `$table` WHERE $primary[0]='".save($primary[1])."'");
            return mysql_affected_rows();
        }
        /**
        *Updates record with $primary[0]=$primary[1] in db $table 
        *@param string $table Name of table
        *@primary array Primary id of the record
        *@return array mysql_result 
        */
        public function select($table, $primary=NULL){
            if(!empty($primary)){
                $WHERE = "WHERE $primary[0]='".save($primary[1])."'";
            }else{
                $WHERE = "";
            }
                $query = "SELECT * FROM `$table` $WHERE";
                $sql = mysql_query($query);
                if($sql)
                while($data = mysql_fetch_array($sql)){
                    $return[] = $data;
                }
                if(empty($return)){
                    return "the query '$query' didn't return any results";
                }else{
                    if(count($return) == 1){
                        return $return[0];
                    }else if(count($return) > 1){
                        return $return;
                    }
                }


            return $return;
        }
        public function query($query){
            echo mysql_query("$query");
        }




 }

