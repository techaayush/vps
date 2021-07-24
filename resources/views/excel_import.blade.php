<!DOCTYPE html>
<html>
<head>
 <title>How to Import Excel Data into Mysql in Codeigniter</title>
<link href="/stylesheet/bootstrap.min.css" rel="stylesheet"> 
</head>

<body>
 <div class="container">
  <br />
  <h3 align="center">How to Import Excel Data into Mysql in Codeigniter</h3>
  <form method="post" id="import_form" enctype="multipart/form-data">
  	@csrf
   <p><label>Select Excel File</label>
   <input type="file" name="file" id="file" required accept=".xls, .xlsx" /></p>
   <br />
   <input type="submit" name="import" value="Import" class="btn btn-info" />
  </form>
  <br />
 </div>
</body>
</html>