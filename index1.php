<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
     <title>スケジュール帳</title>
     <link rel="stylesheet" href="http://netdna.bootstrapcdn.com/bootstrap/3.0.2/css/bootstrap.min.css">
     <link rel="stylesheet" type="text/css" href="assets/zabuto_calendar.min.css">
     <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
     <script src="http://netdna.bootstrapcdn.com/bootstrap/3.0.2/js/bootstrap.min.js"></script>
     <script src="assets/zabuto_calendar.min.js"></script>
     <script type="application/javascript">
$(document).ready(function () {
  $("#my-calendar").zabuto_calendar({
    cell_border: true,
    today: true,
    weekstartson: 0,
    ajax: {
      url: "data.php",
      modal: true
    }
  });
});
</script>
</head>
<body>
<h4>スケジュール帳</h4>
<div class="row">
  <div id="my-calendar"></div>
</div>
</body>
</html>