<?php
#
# @author  ajhai
# @license MIT License
#

	if (isset($_POST['submit'])) {
		
		//Inserting data into table biodata
		
		$date = $_POST['user_dob_year']."-".$_POST['user_dob_month']."-".$_POST['user_dob_year'];
		
		$edu_10 = $_POST['edu_101']."#@#".$_POST['edu_102']."#@#".$_POST['edu_103']."#@#".$_POST['edu_104']."#@#".$_POST['edu_105']."#@#".$_POST['edu_106'];
		$edu_12 = $_POST['edu_121']."#@#".$_POST['edu_122']."#@#".$_POST['edu_123']."#@#".$_POST['edu_124']."#@#".$_POST['edu_125']."#@#".$_POST['edu_126'];
		$edu_opt = $_POST['edu_opt1']."#@#".$_POST['edu_opt2']."#@#".$_POST['edu_opt3']."#@#".$_POST['edu_opt4']."#@#".$_POST['edu_opt5']."#@#".$_POST['edu_opt6'];
		$edu_grad = $_POST['edu_grad1']."#@#".$_POST['edu_grad2']."#@#".$_POST['edu_grad3']."#@#".$_POST['edu_grad4']."#@#".$_POST['edu_grad5']."#@#".$_POST['edu_grad6'];
		$edu_pg = $_POST['edu_pg1']."#@#".$_POST['edu_pg2']."#@#".$_POST['edu_pg3']."#@#".$_POST['edu_pg4']."#@#".$_POST['edu_pg5']."#@#".$_POST['edu_pg6'];
		$edu_phd = $_POST['edu_phd1']."#@#".$_POST['edu_phd2']."#@#".$_POST['edu_phd3']."#@#".$_POST['edu_phd4']."#@#".$_POST['edu_phd5']."#@#".$_POST['edu_phd6'];
		
		$insert = "INSERT INTO biodata (name, dob, nation, edu_10, edu_12, edu_opt, edu_grad, edu_pg, edu_phd, awards, extra, sop) VALUES ('".$_POST['name']."', '".$date."', '".$_POST['nation']."', '".$edu_10."', '".$edu_12."', '".$edu_opt."', '".$edu_grad."', '".$edu_pg."', '".$edu_phd."', '".$_POST['awards']."', '".$_POST['extra']."', '".$_POST['sop']."')";
		$add_member = mysql_query($insert);
		
		
		//Inserting data into table experiences
		
		
		
		
		
		//Inserting data into table publications
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
}

else{
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Home</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script> 
	var experienceNumber = 6; //The first option to be added is number 3 
	function addExperience() { 
		var theForm = document.getElementById("myForm");
		var theTable = document.getElementById("expTable");
		var newRow = document.createElement("tr");
		
		theTable.appendChild(newRow);
		
		var newOption = document.createElement("input");				
		var newCol = document.createElement("td");
		
		newOption.name = "experience+experienceNumber; // experience[optionX]
		newOption.type = "text";
		
		newRow.appendChild(newCol);		
		newCol.appendChild(newOption);
		experienceNumber++;
		
		var newOption1 = document.createElement("input");				
		var newCol1 = document.createElement("td");
		
		newOption1.name = "experience+experienceNumber; // experience[optionX]
		newOption1.type = "text";
		
		newRow.appendChild(newCol1);		
		newCol1.appendChild(newOption1);
		experienceNumber++;
		
		var newOption2 = document.createElement("input");				
		var newCol2 = document.createElement("td");
		
		newOption2.name = "poll+experienceNumber; // poll[optionX]
		newOption2.type = "text";
		
		newRow.appendChild(newCol2);		
		newCol2.appendChild(newOption2);
		experienceNumber++;
		
		var newOption3 = document.createElement("input");				
		var newCol3 = document.createElement("td");
		
		newOption3.name = "poll+experienceNumber; // poll[optionX]
		newOption3.type = "text";
		
		newRow.appendChild(newCol3);		
		newCol3.appendChild(newOption3);
		experienceNumber++;
		
		var newOption4 = document.createElement("input");				
		var newCol4 = document.createElement("td");
		
		newOption4.name = "poll+experienceNumber; // poll[optionX]
		newOption4.type = "text";
		
		newRow.appendChild(newCol4);		
		newCol4.appendChild(newOption4);
		experienceNumber++;
		
		var newOption5 = document.createElement("input");				
		var newCol5 = document.createElement("td");
		
		newOption5.name = "poll+experienceNumber; // poll[optionX]
		newOption5.type = "text";
		
		newRow.appendChild(newCol5);		
		newCol5.appendChild(newOption5);
		experienceNumber++;
	}
	
	var publicationNumber = 5; //The first option to be added is number 3 
	function addPublication() { 
		var theForm = document.getElementById("myForm");
		var theTable = document.getElementById("pubTable");
		var newRow = document.createElement("tr");
		
		theTable.appendChild(newRow);
		
		var newOption = document.createElement("input");				
		var newCol = document.createElement("td");
		
		newOption.name = "experience+publicationNumber; // experience[optionX]
		newOption.type = "text";
		
		newRow.appendChild(newCol);		
		newCol.appendChild(newOption);
		publicationNumber++;
		
		var newOption1 = document.createElement("input");				
		var newCol1 = document.createElement("td");
		
		newOption1.name = "experience+publicationNumber; // experience[optionX]
		newOption1.type = "text";
		
		newRow.appendChild(newCol1);		
		newCol1.appendChild(newOption1);
		publicationNumber++;
		
		var newOption2 = document.createElement("input");				
		var newCol2 = document.createElement("td");
		
		newOption2.name = "poll+publicationNumber; // poll[optionX]
		newOption2.type = "text";
		
		newRow.appendChild(newCol2);		
		newCol2.appendChild(newOption2);
		publicationNumber++;
		
		var newOption3 = document.createElement("input");				
		var newCol3 = document.createElement("td");
		
		newOption3.name = "poll+publicationNumber; // poll[optionX]
		newOption3.type = "text";
		
		newRow.appendChild(newCol3);		
		newCol3.appendChild(newOption3);
		publicationNumber++;
		

	} 
</script>

</head>

<body>
<form method="post" id="myForm" action = "index.php">


Name in Full:<BR>
<input name = "name" type="text" maxlength="50">
<BR><BR>
Date of Birth:
<BR>
<select name = "user_dob_date">
				<option>dd</option>
				<?php for($i = 1; $i <= 9; $i++)
					echo("<option>0".$i."</option>");
					for($i = 10; $i <= 31; $i++)
					echo("<option>".$i."</option>");
				?>
				</select>
				&nbsp;
				<select name = "user_dob_month">
				<option>mm</option>
				<?php for($i = 1; $i <= 9; $i++)
					echo("<option>0".$i."</option>");
				for($i = 10; $i <= 12; $i++)
					echo("<option>".$i."</option>");
				
				?>
				</select>
				&nbsp;
				<select name = "user_dob_year">
				<option>yyyy</option>
				<?php for($i = 1900; $i <= 2009; $i++){
					echo("<option>".$i."</option>");
				}
				?>
				</select>


<BR><BR>
Nationality:<BR>
<input name = "nation" type="text" maxlength="50">
<BR><BR>

Educational Qualifications:<BR>

<table border="1">
<tr><td>Degree/Examination</td><td>University/Institutions</td><td>Year</td><td>Discipline</td><td>Division/Class</td><td>% of Marks</td><td>Rank in Board/University</td></tr>
<tr><td>10th</td><td><input name = edu_101 type="text" maxlength="100"></td><td><input name = edu_102 type="text" maxlength="4"></td><td><input name = edu_103 type="text" maxlength="100"></td><td><input name = edu_104 type="text" maxlength="100"></td><td><input name = edu_105 type="text" maxlength="3"></td><td><input name = edu_106 type="text" maxlength="4"></td></tr>
<tr><td>12th</td><td><input name = edu_121 type="text" maxlength="100"></td><td><input name = edu_122 type="text" maxlength="4"></td><td><input name = edu_123 type="text" maxlength="100"></td><td><input name = edu_124 type="text" maxlength="100"></td><td><input name = edu_125 type="text" maxlength="3"></td><td><input name = edu_126 type="text" maxlength="4"></td></tr>
<tr><td>Optional</td><td><input name = edu_opt1 type="text" maxlength="100"></td><td><input name = edu_opt2 type="text" maxlength="4"></td><td><input name = edu_opt3 type="text" maxlength="100"></td><td><input name = edu_opt4 type="text" maxlength="100"></td><td><input name = edu_opt5 type="text" maxlength="3"></td><td><input name = edu_opt6 type="text" maxlength="4"></td></tr>
<tr><td>Graduation</td><td><input name = edu_grad1 type="text" maxlength="100"></td><td><input name = edu_grad2 type="text" maxlength="4"></td><td><input name = edu_grad3 type="text" maxlength="100"></td><td><input name = edu_grad4 type="text" maxlength="100"></td><td><input name = edu_grad5 type="text" maxlength="3"></td><td><input name = edu_grad6 type="text" maxlength="4"></td></tr>
<tr><td>Post Graduation</td><td><input name = edu_pg1 type="text" maxlength="100"></td><td><input name = edu_pg2 type="text" maxlength="4"></td><td><input name = edu_pg3 type="text" maxlength="100"></td><td><input name = edu_pg4 type="text" maxlength="100"></td><td><input name = edu_pg5 type="text" maxlength="3"></td><td><input name = edu_pg6 type="text" maxlength="4"></td></tr>
<tr><td>Phd</td><td><input name = edu_phd1 type="text" maxlength="100"></td><td><input name = edu_phd2 type="text" maxlength="4"></td><td><input name = edu_phd3 type="text" maxlength="100"></td><td><input name = edu_phd4 type="text" maxlength="100"></td><td><input name = edu_phd5 type="text" maxlength="3"></td><td><input name = edu_phd6 type="text" maxlength="4"></td></tr>
</table>

<br><BR>

Experience(Please indicate the latest first)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:addExperience();">Add another experience</a>
<BR>
<table border="1" id="expTable">
<tr><td>University/Organizcation</td><td>Designation</td><td>From</td><td>To</td><td>Total Period(approx)</td><td>Nature of Experience</td></tr>
<tr><td><input type="text" maxlength="100"></td><td><input type="text" maxlength="100"></td><td><input type="text" maxlength="4"></td><td><input type="text" maxlength="100"></td><td><input type="text" maxlength="2"></td><td><input type="text" maxlength="100"></td></tr>
</table



><BR><BR>



Publications:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:addPublication();">Add another publication</a>
<BR>
<table border="1" id="pubTable">
<tr><td>Publications in referred journals</td><td>Publications in proceedings of seminars/conferences</td><td>Books and Monographs</td><td>Patent/copyright obtained/filed</td></tr>
<tr><td><input type="text" maxlength="100"></td><td><input type="text" maxlength="100"></td><td><input type="text" maxlength="100"></td><td><input type="text" maxlength="100"></td></tr>
</table>
<BR><BR>

Academic or Professional Awards:
<br>
<textarea name = "awards" rows ="10" cols = "100">Please enter all your awards/honors.</textarea>
<br><br>
Any other information which you wish to bring to the notice of the selection committee:
<br>
	<textarea name = "extra" rows = "10" cols = "100"></textarea>
<br><br>
Statement of Purpose (Reason behind Applying):
<br>
	<textarea name = "sop" rows = "15" cols = "100">50-100 lines</textarea>
<br><br>

<input type = "submit" value = "Submit" name = "submit">
</form>

<?php
}
?>