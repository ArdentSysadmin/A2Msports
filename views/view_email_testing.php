<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="utf-8">
 <title>Mass Email Example</title>
 <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
 <script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
 <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</head>
<body>
 <div class="container">
  <h1>Email Example With attchment</h1>
  <form action="<?php echo base_url()?>email_test/send_email" method="POST" enctype='multipart/form-data'>
    <div class="form-group">
      <label for="exampleInputEmail1">Enter Email</label>
      <input type="email" class="form-control" placeholder="Enter Email id" name="email_id"/>
    </div>
    <div class="form-group">
      <label for="exampleInputEmail1">Enter Subject</label>
      <input type="text" class="form-control" placeholder="Enter Email Subject" name="subject"/>
    </div>
    <div class="form-group">
      <label for="exampleInputPassword1">Body Content</label>
      <textarea class="form-control"  rows="3" placeholder="Enter Email Body Content" name="body"></textarea>
    </div>
    <div class="form-group">
      <label for="exampleInputFile">File input</label>
      <input type="file" id="exampleInputFile" name="attachment">
    </div>
    <button type="submit" name="send_email" value="send_email" class="btn btn-default">Submit</button>
  </form>
 </div>
</body>
</html> 